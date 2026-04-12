<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardAdminUnitController extends Controller
{
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->get();
        $totalLowongan = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->count();
        $lowonganAktif = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->whereDate('batasPendaftaran', '>=', now())
            ->count();
        $lowonganTutup = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->whereDate('batasPendaftaran', '<', now())
            ->count();
        $lowonganBelumLengkap = DB::table('lowongan as l')
            ->leftJoin('tahap_rekrutmen as t', 'l.id', '=', 't.idLowongan')
            ->leftJoin('konten_formulir as kf', 'l.id', '=', 'kf.idLowongan')
            ->where('l.idUnit', $idUnit)
            ->where(function ($q) {
                $q->whereNull('t.id')
                    ->orWhereNull('kf.id');
            })
            ->select(
                'l.id',
                'l.judulLowongan as namaLowongan',
                DB::raw('CASE WHEN t.id IS NULL THEN 1 ELSE 0 END as kurang_tahapan'),
                DB::raw('CASE WHEN kf.id IS NULL THEN 1 ELSE 0 END as kurang_formulir')
            )
            ->distinct()
            ->get();
        // jadwalWawancara
        $jadwal = DB::table('jadwal_wawancara as jw')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->leftJoin('wawancara_penilai as wp', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->leftJoin('staffUnit as su', 'su.id', '=', 'wp.idStaffUnit')
            ->leftJoin('users as us', 'us.id', '=', 'su.idUser')
            ->where('l.idUnit', $idUnit)
            ->whereIn('jw.status', ['terjadwal', 'selesai'])
            ->select(
                'jw.id',
                'jw.tanggal_wawancara',
                'jw.status',
                'u.name as namaKandidat',
                'l.judulLowongan as namaLowongan',
                DB::raw('GROUP_CONCAT(DISTINCT us.name SEPARATOR ", ") as pewawancara')
            )
            ->groupBy(
                'jw.id',
                'jw.tanggal_wawancara',
                'jw.status',
                'u.name',
                'l.judulLowongan'
            )
            ->get();
        // kandidat belum nilai
        $kandidatPerluTindakan = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->leftJoin('jadwal_wawancara as jw', 'jw.idPendaftaran', '=', 'p.id')
            ->leftJoin('penilaian_kandidat as pk', 'pk.idPendaftaran', '=', 'p.id')
            ->leftJoin('wawancara_penilai as wp', 'wp.idJadwalWawancara', '=', 'jw.id')
            ->where('l.idUnit', $idUnit)
            ->whereDate('l.batasPendaftaran', '<', now())
            ->select(
                'p.id as idPendaftaran',
                'u.name as namaKandidat',
                'l.judulLowongan as namaLowongan',

                DB::raw('COUNT(DISTINCT jw.id) as jumlahJadwal'),
                DB::raw('COUNT(DISTINCT wp.idStaffUnit) as jumlahPenilai'),

                DB::raw('COUNT(DISTINCT CASE 
            WHEN wp.status = "sudah" THEN wp.idStaffUnit 
        END) as sudahMenilai'),

                DB::raw('CASE WHEN COUNT(jw.id) = 0 THEN 1 ELSE 0 END as belumadajadwal'),
                DB::raw('CASE WHEN pk.nilaiFinal IS NULL THEN 1 ELSE 0 END as belumdinilai')
            )
            ->groupBy(
                'p.id',
                'u.name',
                'l.judulLowongan',
                'pk.nilaiFinal'
            )
            ->havingRaw('
                (COUNT(jw.id) = 0)
                OR (COUNT(DISTINCT wp.idStaffUnit) = 0)
                OR (
                    COUNT(DISTINCT CASE 
                        WHEN wp.status = "sudah" THEN wp.idStaffUnit 
                    END) < COUNT(DISTINCT wp.idStaffUnit)
                )
                OR (pk.nilaiFinal IS NULL)
            ')
            ->get();

        $progressKandidat = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->leftJoin('progress_tahapan_kandidat as pt', 'pt.idPendaftaran', '=', 'p.id')
            ->leftJoin('tahap_rekrutmen as tr', 'tr.id', '=', 'pt.idTahapRekrutmen')
            ->where('l.idUnit', $idUnit)
            ->select(
                'l.id as idLowongan',
                'p.id as idPendaftaran',
                'u.name as namaKandidat',
                'l.judulLowongan',

                DB::raw('MAX(tr.urutan) as maxUrutan'),

                DB::raw('MAX(CASE 
                            WHEN pt.status = "Proses" THEN tr.name
                             END) as tahapProses'),

                DB::raw('MAX(CASE 
                            WHEN pt.status = "Lulus" THEN tr.name
                            END) as tahapSelesai'),

                DB::raw('COUNT(pt.id) as totalTahap'),

                DB::raw('COUNT(CASE 
                    WHEN pt.status = "Lulus" THEN 1 
                END) as totalTahapSelesai'),

                DB::raw('(
                    SELECT COUNT(*)
                    FROM tahap_rekrutmen tr2
                    WHERE tr2.idLowongan = l.id
                ) as totalTahapLowongan')
            )
            ->groupBy('l.id', 'p.id', 'u.name', 'l.judulLowongan')
            ->get();

        foreach ($progressKandidat as $k) {
            $k->progressCount = $k->totalTahapSelesai.' / '.$k->totalTahapLowongan;

            if ($k->totalTahap == 0) {
                $k->statusProgress = 'Belum mulai';
                $k->tahapSekarang = '-';
            } elseif ($k->totalTahap > 0 && $k->totalTahapSelesai == 0) {
                $k->statusProgress = 'Gagal';
                $k->tahapSekarang = '-';
            } elseif ($k->tahapProses) {
                $k->statusProgress = 'Sedang proses';
                $k->tahapSekarang = $k->tahapProses;
            } elseif ($k->tahapSelesai) {
                $k->statusProgress = 'Selesai';
                $k->tahapSekarang = $k->tahapSelesai;
            } else {
                $k->statusProgress = 'Tidak diketahui';
                $k->tahapSekarang = '-';
            }
        }

        $events = [];
        foreach ($lowongan as $l) {
            $events[] = [
                'title' => 'Buka - Lowongan '.$l->judulLowongan,
                'start' => $l->awalPendaftaran,
                'color' => 'blue',
            ];

            $events[] = [
                'title' => 'Tutup - Lowongan '.$l->judulLowongan,
                'start' => $l->batasPendaftaran,
                'color' => 'red',
            ];
        }

        foreach ($jadwal as $j) {
            $events[] = [
                'title' => 'Wawancara - '.$j->namaKandidat,
                'start' => $j->tanggal_wawancara,
                'color' => $j->status == 'selesai' ? 'green' : 'blue',
                'extendedProps' => [
                    'kandidat' => $j->namaKandidat,
                    'lowongan' => $j->namaLowongan,
                    'pewawancara' => $j->pewawancara,
                    'status' => $j->status,
                    'tipe' => 'wawancara',
                ],
            ];
        }

        return view('adminUnitPage.dashboard', compact(
            'lowongan',
            'totalLowongan',
            'lowonganAktif',
            'lowonganTutup',
            'lowonganBelumLengkap',
            'kandidatPerluTindakan',
            'progressKandidat',
            'events'));
    }
}
