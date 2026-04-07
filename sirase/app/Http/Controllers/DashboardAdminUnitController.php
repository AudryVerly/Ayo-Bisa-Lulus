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
            ->select('l.*')
            ->distinct()
            ->get();

        // jadwalWawancara
        $jadwal = DB::table('jadwal_wawancara as jw')
            ->join('pendaftaran as p', 'jw.idPendaftaran', '=', 'p.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('l.idUnit', $idUnit)
            ->where('jw.status', '=', 'terjadwal')
            ->select(
                'jw.tanggal_wawancara',
                'u.name as namaKandidat',
                'l.judulLowongan as namaLowongan')
            ->get();
        // kandidat belum nilai
        $kandidatPerluTindakan = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->leftJoin('jadwal_wawancara as jw', 'jw.idPendaftaran', '=', 'p.id')
            ->leftJoin('penilaian_kandidat as pk', 'pk.idPendaftaran', '=', 'p.id')
            ->where('l.idUnit', $idUnit)
            ->whereDate('l.batasPendaftaran', '<', now())
            ->where(function ($q) {
                $q->whereNull('jw.id')
                    ->orWhereNull('pk.nilaiFinal');
            })
            ->select(
                'u.name as namaKandidat',
                'l.judulLowongan as namaLowongan',
                DB::raw('CASE 
                WHEN jw.id IS NULL THEN "Belum Ada Jadwal"
                ELSE "Belum Dinilai"
                END as status')
            )
            ->distinct()
            ->get();
        $events = [];
        foreach ($lowongan as $l) {
            $events[] = [
                'title' => 'Buka - '.$l->judulLowongan,
                'start' => $l->awalPendaftaran,
                'color' => 'green',
            ];

            $events[] = [
                'title' => 'Tutup - '.$l->judulLowongan,
                'start' => $l->batasPendaftaran,
                'color' => 'green',
            ];
        }

        foreach ($jadwal as $j) {
            $events[] = [
                'title' => 'Wawancara - '.$j->namaKandidat,
                'start' => $j->tanggal_wawancara,
                'color' => 'blue',
            ];
        }

        return view('adminUnitPage.dashboard', compact(
            'lowongan',
            'totalLowongan',
            'lowonganAktif',
            'lowonganTutup',
            'lowonganBelumLengkap',
            'lowonganBelumLengkap',
            'kandidatPerluTindakan',
            'events'));
    }
}
