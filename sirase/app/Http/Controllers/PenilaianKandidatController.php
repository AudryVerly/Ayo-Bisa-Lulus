<?php

namespace App\Http\Controllers;

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
        $idStaff = Auth::user()->staffUnit()->first();
        $kandidat = DB::table('wawancara_penilai as wp')
            ->join('jadwal_wawancara as jw', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->whereIn('wp.status', ['terjadwal', 'sudah'])
            ->where('wp.idStaffUnit', $idStaff->id)
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

            // kita cek dulu double input nilai gak
            $nilaiExists = DB::table('penilaian_kandidat')
                ->where('idWawancaraPenilai', $request->idWawancaraPenilai)
                ->exists();
            if ($nilaiExists) {
                abort(403, 'Sudah Pernah menilai kandidat ini');
            }

            // kita akan count datanya disini juga
            $bobotList = DB::table('bobot_kriteria')
                ->pluck('nilaiBobot', 'id');
            $total = 0;

            foreach ($request->nilai as $idBobot => $nilai) {

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

    public function detailKandidat(string $id){
        $idStaff = Auth::user()->staffUnit()->first();
        $dataKandidat = DB::table('wawancara_penilai as wp')
                        ->join('jadwal_wawancara as jw','wp.idJadwalWawancara','=','jw.id')
                        ->join('pendaftaran as p', 'jw.idPendaftaran','=','p.id')
                        ->join('lowongan as l','p.idLowongan','=','l.id')
                        ->join('mahasiswa as m','p.idMahasiswa','=','m.id')
                        ->join('users as u','m.idUser','=', 'u.id')
                        ->join('staffUnit as sf','wp.idStaffUnit','=','sf.id')
                        ->join('users as up','up.id','=','sf.idUser')
                        ->join('penilaian_kandidat as pk','wp.id','=','pk.idWawancaraPenilai')
                        ->where('wp.id', $id)
                        ->where('wp.idStaffUnit', $idStaff->id)
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
                       ->join('penilaian_kandidat as pk','pb.idPenilaianKandidat','=','pk.id')
                       ->join('bobot_kriteria as bk','pb.idBobotKriteria','=','bk.id')
                       ->join('kriteria as k','bk.idKriteria','=','k.id')
                       ->where('pk.idWawancaraPenilai', $id)
                       ->select(
                        'k.namaKriteria',
                        'pb.nilaiAwal',
                        'pb.nilaiAkhir',
                        'bk.nilaiBobot as bobot'
                       )
                       ->get();
        return view('penilaiankandidat.detailnilaikandidat',compact('dataKandidat','nilaiDetail'));
    }
}
