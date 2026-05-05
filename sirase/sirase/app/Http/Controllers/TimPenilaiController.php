<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\StaffUnit;
use App\Models\timPenilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TimPenilaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit', $idUnit)
                    ->orderBy('status','desc')
                    ->get();
        return view('timpenilai.utama',compact('lowongan'));
    }

    public function showStaffUnit (Request $request)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $idLowongan = $request ->idLowongan;

        //ini untuk mengecek 
        $staffExist = DB::table('tim_penilai as tp')
                     ->where('tp.idLowongan', $idLowongan)
                     ->pluck('tp.idStaffUnit');
        $staffName = DB::table('staffUnit as s')
                    ->join('users as u','s.idUser', '=', 'u.id')
                    ->where('s.idUnit',$idUnit)
                    ->whereNotIn('s.id',$staffExist)
                    ->where('u.role', '!=', 'AdminUnit')
                    ->select('s.id as idStaffUnit', 'u.name')
                    ->get();

        return response()->json($staffName);
    }

    public function store(Request $request){
        $request->validate([
            'idLowongan' => 'required|exists:lowongan,id',
            'idStaffUnit' => 'required|exists:staffUnit,id'
        ]);

        //ini biar gak double insert dengan nama yang sama
        $exist = timPenilai::where('idLowongan', $request->idLowongan)
                             ->where('idStaffUnit', $request->idStaffUnit)
                             ->exists();
        if($exist){
            return redirect()->back()
                                ->withErrors(['idStaffUnit' => 'Staff ini sudah ada '])
                                ->withInput();
        }

        timPenilai::create([
            'idStaffUnit' => $request->idStaffUnit,
            'idLowongan' => $request->idLowongan,
            'statusPenilaian'=> 'Belum',
            'isActive' => 1

        ]);

        return redirect()->back()->with('success','Tim Penilai berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {   $lowongan = Lowongan::findOrFail($id);
        $penilai = DB::table('tim_penilai as tp')
                   ->join('staffUnit as su', 'tp.idStaffUnit', '=','su.id')
                   ->join('users as u', 'su.idUser', '=', 'u.id')
                   ->where('tp.idLowongan', $id)
                   ->select('tp.*', 'u.name')
                   ->get();
        return view('timpenilai.teampenilai', compact('lowongan', 'penilai'));
    }

    public function showStaffUnitEdit(Request $request){
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $idLowongan = $request->idLowongan;
        $idPenilai = $request->idPenilai;

        $staffExist = DB::table('tim_penilai as tp')
                      ->where('tp.idLowongan', '=',$idLowongan)
                      //supaya dia tetap muncul karena dia mau diedit
                      ->where('tp.id','!=', $idPenilai)
                      ->pluck('idStaffUnit');
        $staffName = DB::table('staffUnit as su')
                     ->join('users as u', 'su.idUser','=', 'u.id')
                     ->where('su.idUnit', '=', $idUnit)
                     ->whereNotIn('su.id',$staffExist)
                     ->where('u.role','!=','AdminUnit')
                     ->select('su.id as idStaffUnit','u.name')
                     ->get();
                     
        return response()->json($staffName);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'idStaffUnit' => 'required|exists:staffUnit,id',
            'statusPenilaian' => 'required|in:Sudah,Belum'
        ]);

        $penilai = timPenilai::findOrFail($id);
        //cek apakah staff ini sudah dipakai di penilai lain
        $exist = timPenilai::where('idLowongan', $penilai->idLowongan)
                ->where('idStaffUnit',$request->idStaffUnit)
                //yang udah di display tetap ada
                ->where('id','!=', $id)
                ->exists();

        if($exist){
            return response()->json([
                'message' => 'Staff ini sudah menjadi tim penilai'
            ], 422);
        }

        $penilai->update([
            'idStaffUnit' =>$request->idStaffUnit,
            'statusPenilaian' => $request->statusPenilaian
        ]);

        return response()->json(['message' => 'Tim penilai berhasil diperbarui']);

    }    

    //ini buat on off
    public function toggle(string $id){
        $penilai = timPenilai::findorFail($id);

        TimPenilai::where('id', $id)->update([
            'isActive' => $penilai->isActive == 1 ? 0 : 1
        ]);

        return response()->json([
            'message' => $penilai->isActive == 1 
                ? 'Penilai berhasil dinonaktifkan'
                : 'Penilai berhasil diaktifkan'
        ]);

    }
}
