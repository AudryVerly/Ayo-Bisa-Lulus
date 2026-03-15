<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       //$lowongan = Lowongan::where('status', 1)->get();
       $lowongan = DB::table('lowongan as l')
                   ->join('unit as u', 'l.idUnit', '=', 'u.id')
                   ->where('l.status',1)
                   ->select('l.*', 'u.name as unitName')
                   ->get();
        $units = DB::table('unit')
                 ->orderBy('name')
                 ->where('status',1)
                 ->get();

       return view('mahasiswaPage.dashboard', compact('lowongan', 'units'));
    }

    public function detailLowongan(string $id){
        $detailLowongan = DB::table('lowongan as l')
                        ->join('unit as u','l.idUnit', '=', 'u.id')
                        ->where('l.id',$id)
                        ->select('l.*', 'u.name as unitName')
                        ->first();

        return response()->json([
            'judulLowongan' => $detailLowongan->judulLowongan,
            'posisiLowongan' => $detailLowongan->posisiLowongan,
            'unitName' => $detailLowongan->unitName,
            'durasiKerja' => $detailLowongan->durasiKerja,
            'deskripsi' =>$detailLowongan->deskripsi,
            'kualifikasi' =>$detailLowongan->kualifikasi,
            'batasPendaftaran' => $detailLowongan->batasPendaftaran
                ? Carbon::parse($detailLowongan->batasPendaftaran)->translatedFormat('d F Y')
                : '-',

            'mulaiKerja' => $detailLowongan->mulaiKerja
                ? Carbon::parse($detailLowongan->mulaiKerja)->translatedFormat('d F Y')
                : '-',

            'akhirKerja' => $detailLowongan->akhirKerja
                ? Carbon::parse($detailLowongan->akhirKerja)->translatedFormat('d F Y')
                : '-',
        ]);
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
