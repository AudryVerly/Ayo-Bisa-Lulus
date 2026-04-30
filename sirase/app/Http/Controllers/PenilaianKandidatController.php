<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianKandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idStaffIds = Auth::user()
            ->staffUnit()
            ->pluck('id')
            ->toArray();
        $kandidat = DB::table('wawancara_penilai as wp')
            ->join('jadwal_wawancara as jw', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->whereIn('wp.status', ['terjadwal', 'sudah'])
            ->whereIn('wp.idStaffUnit', $idStaffIds)
            ->select(
                'wp.id',
                'l.judulLowongan as namaLowongan',
                'l.posisiLowongan as posisiLowongan',
                'u.name as namaKandidat',
                'wp.status as status',
                'jw.tanggal_wawancara as tanggalWawancara'
            )
            ->orderByRaw("
                    CASE 
                        WHEN wp.status = 'terjadwal' THEN 0
                        ELSE 1
                    END
                ")
            ->get();

        return view('penilaiankandidat.index', compact('kandidat'));
    }

    public function showForm(string $id)
    {
        $data = DB::table('wawancara_penilai as wp')
            ->join('jadwal_wawancara as jw', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->where('wp.id', $id)
            ->select(
                'wp.id',
                'u.name as namaKandidat',
                'l.judulLowongan',
                'l.posisiLowongan',
                'l.idUnit'
            )
            ->first();

        $kriteria = DB::table('bobot_kriteria as bk')
            ->join('kriteria as k', 'bk.idKriteria', '=', 'k.id')
            ->where('bk.idUnit', $data->idUnit)
            ->where('is_active', '1')
            ->select(
                'bk.id as idBobot',
                'bk.nilaiBobot',
                'k.namaKriteria'
            )
            ->orderBy('bk.nilaiBobot', 'desc')
            ->get();

        return view('penilaiankandidat.formnilai', compact('data', 'kriteria'));
    }

    public function saveNilai(Request $request)
    {
        $request->validate([
            'idWawancaraPenilai' => 'required|integer',
            'nilai' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {

            $wawancaraPenilai = DB::table('wawancara_penilai')
                ->where('id', $request->idWawancaraPenilai)
                ->first();
            if (! $wawancaraPenilai) {
                abort(404, 'Data wawancara tidak ditemukan');
            }

            $jadwal = DB::table('jadwal_wawancara')
                ->where('id', $wawancaraPenilai->idJadwalWawancara)
                ->first();

            $idPendaftaran = $jadwal->idPendaftaran;

            $dataUnit = DB::table('pendaftaran as p')
                ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
                ->where('p.id', $idPendaftaran)
                ->select('l.idUnit')
                ->first();

            // kita cek dulu double input nilai gak
            $nilaiExists = DB::table('penilaian_kandidat')
                ->where('idWawancaraPenilai', $request->idWawancaraPenilai)
                ->exists();

            if ($nilaiExists) {
                abort(403, 'Sudah Pernah menilai kandidat ini');
            }

            // kita akan count datanya disini juga
            $bobotList = DB::table('bobot_kriteria')
                ->where('idUnit', $dataUnit->idUnit)
                ->where('is_active', 1)
                ->pluck('nilaiBobot', 'id');
            $total = 0;

            foreach ($request->nilai as $idBobot => $nilai) {
                if (! isset($bobotList[$idBobot])) {
                    continue; // skip kalau bobot tidak valid
                }

                $bobot = $bobotList[$idBobot] ?? 0;
                $hasil = ($nilai / 5) * $bobot;

                $total += $hasil;
            }

            $idPenilaian = DB::table('penilaian_kandidat')->insertGetId([
                'idPendaftaran' => $idPendaftaran,
                'idWawancaraPenilai' => $request->idWawancaraPenilai,
                'nilaiFinal' => $total,
                'catatan' => $request->catatan ?? '-',
                'tanggal_menilai' => now(),
            ]);

            // ini bagian simpan nilai bobot perkriteria
            foreach ($request->nilai as $idBobot => $nilai) {
                $bobot = $bobotList[$idBobot] ?? 0;
                $hasil = ($nilai / 5) * $bobot;

                DB::table('penilaian_setiap_bobot')->insert([
                    'idPenilaianKandidat' => $idPenilaian,
                    'idBobotKriteria' => $idBobot,
                    'bobotKriteria' => $bobot,
                    'nilaiAwal' => $nilai,
                    'nilaiAkhir' => $hasil,
                ]);

            }

            DB::table('wawancara_penilai')
                ->where('id', $request->idWawancaraPenilai)
                ->update([
                    'status' => 'sudah',
                ]);

            // cek apakah pada jadwal itu masih belum nilai
            $cekPenilai = DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $wawancaraPenilai->idJadwalWawancara)
                ->where('status', '=', 'terjadwal')
                ->count();
            if ($cekPenilai == 0) {
                DB::table('jadwal_wawancara')
                    ->where('id', $wawancaraPenilai->idJadwalWawancara)
                    ->update([
                        'status' => 'selesai',
                    ]);
            }
        });

        return redirect()->route('penilaian.show')->with('success', 'Penilaian berhasil disimpan');
    }

    public function detailKandidat(string $id)
    {
        $idStaffIds = Auth::user()
            ->staffUnit()
            ->pluck('id')
            ->toArray();

        $dataKandidat = DB::table('wawancara_penilai as wp')
            ->join('jadwal_wawancara as jw', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->join('staffUnit as sf', 'wp.idStaffUnit', '=', 'sf.id')
            ->join('users as up', 'up.id', '=', 'sf.idUser')
            ->join('penilaian_kandidat as pk', 'wp.id', '=', 'pk.idWawancaraPenilai')
            ->where('wp.id', $id)
            ->whereIn('wp.idStaffUnit', $idStaffIds)
            ->select(
                'wp.id',
                'u.name as namaKandidat',
                'l.judulLowongan as judulLowongan',
                'l.posisiLowongan as posisiLowongan',
                'jw.tanggal_wawancara as tanggalWawancara',
                'wp.status as status',
                'pk.nilaiFinal as nilaiFinal',
                'pk.catatan as catatan',
                'up.name as namaPewawanacara'
            )
            ->first();
        $nilaiDetail = DB::table('penilaian_setiap_bobot as pb')
            ->join('penilaian_kandidat as pk', 'pb.idPenilaianKandidat', '=', 'pk.id')
            ->join('bobot_kriteria as bk', 'pb.idBobotKriteria', '=', 'bk.id')
            ->join('kriteria as k', 'bk.idKriteria', '=', 'k.id')
            ->where('pk.idWawancaraPenilai', $id)
            ->select(
                'k.namaKriteria',
                'pb.nilaiAwal',
                'pb.nilaiAkhir',
                'pb.bobotKriteria'
            )
            ->get();

        return view('penilaiankandidat.detailnilaikandidat', compact('dataKandidat', 'nilaiDetail'));
    }

    public function showLowonganAdmin()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = Lowongan::with(['unit'])
            ->where('idUnit', $idUnit)
                    // ini kita tunjukkin lowongan yang dah tutup supaya gak salah tekan keterima
            ->where('status', 0)
            ->get();

        return view('penilaiankandidat.listlowongannilai', compact('lowongan'));
    }

    public function kandidatPerLowongan($idLowongan)
    {
        $lowongan = DB::table('lowongan')
            ->where('id', $idLowongan)
            ->first();
        $kuota = $lowongan->kuota_diterima;

        $jumlahDiterima = DB::table('pengumuman as pg')
            ->join('pendaftaran as p', 'p.id', '=', 'pg.idPendaftaran')
            ->where('p.idLowongan', $idLowongan)
            ->where('pg.status', 'Terima')
            ->count();

        $lockedMahasiswa = DB::table('pengumuman as pg')
            ->join('pendaftaran as p', 'pg.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('pg.status', 'Terima')
            ->where('p.idLowongan', '!=', $idLowongan)
            ->whereDate('l.akhirKerja', '>=', now())
            ->pluck('p.idMahasiswa')
            ->toArray();

        $kandidat = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->leftjoin('jadwal_wawancara as jw', 'jw.idPendaftaran', '=', 'p.id')
            ->leftJoin('wawancara_penilai as wp', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->leftJoin('penilaian_kandidat as pk', 'pk.idWawancaraPenilai', '=', 'wp.id')
            ->leftJoin('pengumuman as pg', 'pg.idPendaftaran', '=', 'p.id')
            ->where('p.idLowongan', $idLowongan)
            ->where('p.statusPendaftaran', '!=', 'ditolak')
            ->select(
                'p.id as idPendaftaran',
                'p.idMahasiswa',
                'u.name as namaKandidat',
                'pg.status',
                'pg.is_publish',

                // nilai akhir kandidat
                DB::raw('COALESCE(AVG(pk.nilaiFinal),0) as nilaiAkhir'),
                DB::raw('
                    COUNT(DISTINCT CASE 
                        WHEN pk.id IS NOT NULL
                        THEN wp.idStaffUnit
                    END) as jumlahPenilai
                '),

                // jumlah penilai seharusnya
                DB::raw("
                     COUNT(DISTINCT CASE 
                        WHEN wp.status IN ('terjadwal','sudah') 
                        THEN wp.idStaffUnit 
                    END) as totalPenilai
                ")
            )
            ->groupBy('p.id', 'u.name', 'pg.status', 'pg.is_publish', 'p.idMahasiswa')
            // Yang belum lengkap penilaian ditaruh bawah
            ->orderByRaw("
                CASE 
                    WHEN COUNT(DISTINCT CASE 
                        WHEN pk.id IS NOT NULL THEN wp.idStaffUnit 
                    END)
                    <
                    COUNT(DISTINCT CASE 
                        WHEN wp.status IN ('terjadwal','selesai') THEN wp.idStaffUnit 
                    END)
                    THEN 1
                    ELSE 0
                END
            ")
            ->orderByDesc('nilaiAkhir')
            ->get();
        foreach ($kandidat as $k) {
            $k->isLocked = in_array($k->idMahasiswa, $lockedMahasiswa);
        }

        // $semuaDinilai = DB::table('wawancara_penilai as wp')
        //     ->leftJoin('penilaian_kandidat as pk', 'pk.idWawancaraPenilai', '=', 'wp.id')
        //     ->join('jadwal_wawancara as jw', 'jw.id', '=', 'wp.idJadwalWawancara')
        //     ->join('pendaftaran as p', 'p.id', '=', 'jw.idPendaftaran')
        //     ->where('p.idLowongan', $idLowongan)
        //     ->whereIn('wp.status', ['terjadwal', 'selesai'])
        //     ->whereNull('pk.id') // ini kalau kasus belum ada yang menilai
        //     ->doesntExist(); // true kalau semuanya dinilai
        $semuaDinilai = true;

        foreach ($kandidat as $k) {
            if ($k->totalPenilai == 0 || $k->jumlahPenilai < $k->totalPenilai) {
                $semuaDinilai = false;
                break;
            }
        }

        return view('penilaiankandidat.nilaikandidatadmin', compact('kandidat', 'lowongan', 'semuaDinilai', 'jumlahDiterima', 'kuota'));
    }

    public function showDetailKandidatAdmin($idPendaftaran)
    {
        $kandidat = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.id', $idPendaftaran)
            ->select(
                'p.id',
                'u.name as namaKandidat',
                'l.judulLowongan',
                'l.posisiLowongan',
            )
            ->first();
        $penilaian = DB::table('wawancara_penilai as wp')
            ->leftJoin('penilaian_kandidat as pk', 'pk.idWawancaraPenilai', '=', 'wp.id')
            ->join('jadwal_wawancara as jw', 'jw.id', '=', 'wp.idJadwalWawancara')
            ->join('staffUnit as sf', 'wp.idStaffUnit', '=', 'sf.id')
            ->join('users as u', 'sf.idUser', '=', 'u.id')
            ->where('jw.idPendaftaran', $idPendaftaran)
            ->where('wp.status', 'sudah')
            ->select(
                'wp.id as idWawancaraPenilai',
                'pk.id as idPenilaian',
                DB::raw('COALESCE(pk.nilaiFinal, 0) as nilaiFinal'),
                'pk.catatan',
                'u.name as namaPenilai',
                'jw.tanggal_wawancara',
            )
            ->get();

        $summary = DB::table('wawancara_penilai as wp')
            ->leftJoin('penilaian_kandidat as pk', 'pk.idWawancaraPenilai', '=', 'wp.id')
            ->join('jadwal_wawancara as jw', 'jw.id', '=', 'wp.idJadwalWawancara')
            ->where('jw.idPendaftaran', $idPendaftaran)
            ->where('wp.status', 'sudah')
            ->select(
                DB::raw('COALESCE(AVG(pk.nilaiFinal), 0) as nilaiAkhir'),
                DB::raw('COUNT(wp.id) as jumlahPenilai')
            )
            ->first();
        $detailKriteria = DB::table('penilaian_setiap_bobot as pb')
            ->join('penilaian_kandidat as pk', 'pk.id', '=', 'pb.idPenilaianKandidat')
            ->join('wawancara_penilai as wp', 'wp.id', '=', 'pk.idWawancaraPenilai')
            ->join('jadwal_wawancara as jw', 'jw.id', '=', 'wp.idJadwalWawancara')
            ->join('bobot_kriteria as bk', 'bk.id', '=', 'pb.idBobotKriteria')
            ->join('kriteria as k', 'bk.idKriteria', '=', 'k.id')
            ->where('jw.idPendaftaran', $idPendaftaran)
            // ->where('wp.status', 'sudah')
            // ->where('wp.status'.'sudah')
            ->select(
                'pb.idPenilaianKandidat',
                'k.namaKriteria',
                'pb.nilaiAwal',
                'pb.nilaiAkhir',
                'pb.bobotKriteria'
            )
            ->get()
            ->groupBy('idPenilaianKandidat');

        return view('penilaiankandidat.detailnilaikandidatadmin', compact('kandidat', 'penilaian', 'detailKriteria', 'summary'));
    }
}
