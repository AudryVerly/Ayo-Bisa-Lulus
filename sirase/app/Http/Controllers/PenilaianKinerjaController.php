<?php

namespace App\Http\Controllers;

use App\Models\KualitasKerja;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianKinerjaController extends Controller
{
    public function showNilaiKinerja(){
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $unit = Unit::findOrFail($idUnit);
        $nilaiKinerja = KualitasKerja::with(['unit'])
                        ->where('idUnit', $idUnit)
                        ->orderBy('status','desc')
                        ->get();
        return view('penilaiankinerja.indexnilai',compact('nilaiKinerja','unit'));
    }
}
