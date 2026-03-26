<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AHPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $kriteria = DB::table('bobot_kriteria as b')
                    ->join('kriteria as k', 'k.id','=','b.idKriteria')
                    ->where('b.idUnit', $idUnit)
                    ->where('b.is_active', 1)
                    ->select(
                        'k.id',
                        'k.namaKriteria as namaKriteria'
                    )
                    ->get();
        return view('AHP.pairwise',compact('kriteria'));
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
