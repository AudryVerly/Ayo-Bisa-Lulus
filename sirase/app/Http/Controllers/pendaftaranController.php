<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pendaftaranController extends Controller
{
    public function formulirPendaftaran(string $idLowongan){
        $lowongan = DB::table('lowongan')
                    ->where('id', $idLowongan)
                    ->where('status', 1)
                    ->first();
        if(!$lowongan){
            abort(404, 'Lowongan tidak ditemukan atau tidak aktif');
        }

        $fieldFormulir = DB::table('konten_formulir')
                         ->where('idLowongan', $idLowongan)
                         ->where('status', 1)
                         ->orderBy('id')
                         ->get();
        if($fieldFormulir->count() === 0){
            abort(404, 'Formulir belum tersedia');
        }

        return view('pendaftaran.formulir', compact('lowongan', 'fieldFormulir'));

    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
