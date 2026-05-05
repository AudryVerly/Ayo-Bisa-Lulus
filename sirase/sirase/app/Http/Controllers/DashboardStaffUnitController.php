<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardStaffUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idStaffUnit = Auth::user()->staffUnit->pluck('id');
        $unit = DB::table('staffunit as s')
            ->join('unit as u', 's.idUnit', '=', 'u.id')
            ->whereIn('s.id', $idStaffUnit)
            ->pluck('u.name');

        $totalKandidat = DB::table('wawancara_penilai as wp')
            ->join('jadwal_wawancara as j', 'wp.idJadwalWawancara', '=', 'j.id')
            ->distinct('j.idPendaftaran')
            ->whereIn('wp.idStaffUnit', $idStaffUnit)
            ->count('j.idPendaftaran');

        $belumDinilai = DB::table('wawancara_penilai')
            ->whereIn('idStaffUnit', $idStaffUnit)
            ->whereIn('status', ['terjadwal'])
            ->count();

        $sudahDinilai = DB::table('wawancara_penilai')
            ->whereIn('idStaffUnit', $idStaffUnit)
            ->where('status', 'sudah')
            ->count();

        $kandidat = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'j.idPendaftaran', '=', 'p.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as us', 'us.id', '=', 'm.idUser')
            ->join('wawancara_penilai as w', 'w.idJadwalWawancara', '=', 'j.id')
            ->whereIn('w.status',['terjadwal','sudah'])
            ->select(
                'us.name as nama',
                'w.status as status',
                'j.tanggal_wawancara as tanggal',
                'j.waktu_mulai as mulai'
            )
            ->whereIn('w.idStaffUnit', $idStaffUnit)
            ->orderByDesc('j.tanggal_wawancara')
            ->get();

        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'j.idPendaftaran', '=', 'p.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('wawancara_penilai as w', 'w.idJadwalWawancara', '=', 'j.id')
            ->select(
                'j.id',
                'j.tanggal_wawancara as tanggal',
                'j.waktu_mulai as mulai',
                'j.waktu_selesai as selesai',
                'j.lokasi as lokasi',
                'j.status as status',
                'j.link_wawancara as link',
                'w.status as statusPenilai',
                'u.name as namaMahasiswa'
            )
            ->where('w.idStaffUnit', $idStaffUnit)
            ->where('w.status', 'terjadwal')
            ->whereDate('j.tanggal_wawancara', '>=', now())
            ->orderBy('j.tanggal_wawancara')
            ->first();

        // if($jadwal){
        //     $penilai = DB::table('wawancara_penilai as w')
        //                ->join('staffunit as s','w.idStaffUnit','=','s.id')
        //                ->join('users as u', 's.idUser', '=', 'u.id')
        //                ->where('w.idJadwalWawancara', $jadwal->id)
        //                ->pluck('u.name')
        //                ->toArray();
        //     $jadwal->penilaiStr = implode(', ', $penilai);
        // }
        return view('staffUnitPage.dashboard', compact('jadwal','unit','totalKandidat','belumDinilai','sudahDinilai','kandidat'));
    }
}
