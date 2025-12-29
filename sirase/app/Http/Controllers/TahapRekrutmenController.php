<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\TahapRekrutmen;

class TahapRekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idunit')->first();
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit',$idUnit)
                    ->orderBy('status','desc')
                    ->get();
        return view('tahapanRekrutmen.utama', compact('lowongan'));
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
        $lowongan = Lowongan::findOrFail($id);
        $tahapan = TahapRekrutmen::where('idLowongan', $id)->get();
        return view('tahapanRekrutmen.tahapanform', compact('lowongan','tahapan'));
    }

    //ini nuat soft delete tahapan tersebut
    public function toggle(string $id,Request $request){
        $tahapan = TahapRekrutmen::findorFail($id);
        $tahapan->update(['status' => $request->status ? 1 : 0]);

        return response()->json([
            'message' => $request->status ? 
            'Tahap berhasil diaktifkan' :
            'Tahap ini berhasil dinonaktifkan'
        ]);
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
