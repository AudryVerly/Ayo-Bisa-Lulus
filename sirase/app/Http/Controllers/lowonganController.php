<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class lowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Ini untuk mencari idUnit dari user yang login 
        //ini pakai pluck soalnya relasinya one to many 
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit', $idUnit)
                    ->orderBy('status','desc')
                    ->get();
        return view('lowongan.utama', compact('lowongan'));
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
