<?php

namespace App\Http\Controllers;

use App\Models\PenilaianKandidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
                    ->join('jadwal_wawancara as jw','wp.idJadwalWawancara','=','jw.id')
                    ->join('pendaftaran as p', 'jw.idPendaftaran','=','p.id')
                    ->join('lowongan as l','p.idLowongan','=','l.id')
                    ->join('mahasiswa as m','p.idMahasiswa','=','m.id')
                    ->join('users as u','m.idUser','=','u.id')
                    ->where('wp.status','terjadwal')
                    ->where('wp.idStaffUnit',$idStaff->id)
                    ->select(
                        'wp.id',
                        'l.judulLowongan as namaLowongan',
                        'l.posisiLowongan as posisiLowongan',
                        'u.name as namaKandidat'
                    )
                    ->get();
        return view('penilaiankandidat.index',compact('kandidat'));
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
