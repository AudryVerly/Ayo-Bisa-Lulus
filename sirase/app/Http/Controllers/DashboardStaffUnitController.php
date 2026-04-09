<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardStaffUnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idStaffUnit = Auth::user()->staffUnit->first()->id; 
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
            ->where('w.status','terjadwal')
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
        return view('staffUnitPage.dashboard', compact('jadwal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
