<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use App\Models\Lowongan;

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
                    ->get();
        return view('tahapanRekrutmen.utama', compact('lowongan'));
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
