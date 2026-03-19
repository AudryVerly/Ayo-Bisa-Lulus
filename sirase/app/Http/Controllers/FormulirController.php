<?php

namespace App\Http\Controllers;

use App\Models\formulir;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormulirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        // dd($idUnit);
        //ini untuk tampilan index supaya muncul lowongan di unit tersebut doang
        //with itu adalh relasi atau join
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit',$idUnit)
                    ->orderBy('status','desc')
                    ->get();
        return view('formulir.utama', compact('lowongan'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lowongan = Lowongan::findorFail($request->idLowongan);
        if($lowongan->status == 1){
            return redirect()->back()->with('error','Lowongan sudah dibuka,Field tidak bisa ditambah lagi');
        }
        
        $request->validate([
            'namaField' =>'required|string',
            'tipeField' => 'required|string',
            'opsi_field' => 'required_if:tipeField,select,checkbox,radio',
            'required'   => 'required',
            'help_text' => 'required|string|max:225',
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'string'   => 'Bagian :attribute harus berupa teks.',
            'opsi_field.required_if' => 'Opsi wajib diisi untuk tipe pilihan.',
            'help_text.string' => 'Help text harus dalam bentuk tulisan.',
            'help_text.max' => 'Help_text maksimumnya 255 kata.',
        ],[
            'namaField' => 'Nama Field',
            'tipe Field' => 'Tipe Field',
            'required'  => 'Penanda Required',
            'help_text' => 'Help Text'
        ]);

        formulir::create([
            'idLowongan' => $request->idLowongan,
            'namaField' =>$request ->namaField,
            'tipeField' => $request->tipeField,
            'opsi_field' => $request->opsi_field,
            'help_text' => $request-> help_text,
            'required' => $request->required,
            'status' => 1
        ]);

        $this->checkReady($request->idLowongan);

        return redirect()->back()->with('success','Field berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {  
        //ini untuk nyimpan nama lowongan dan munculin tipefield dari lowongan tersebut
        $lowongan = Lowongan::findOrFail($id);
        $field = formulir::where('idLowongan', $id)->get();
        $cekTahapan = DB::table('tahap_rekrutmen')
                      ->where('idLowongan',$id)
                      ->where('status', 1)
                      ->count();
        return view('formulir.applicationForm', compact('lowongan','field','cekTahapan'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formulir = formulir::findorfail($id);
        $lowongan = $formulir->lowongan;

        if($lowongan->status == 1){
            return redirect()->back()->with('error','Lowongan sudah dibuka,Field tidak bisa diedit lagi');
        }
        
        $request->validate([
            'namaField' =>'required|string',
            'tipeField' => 'required|string',
            'required'   => 'required',
            'help_text' => 'required|string|max:225',
            'opsi_field' => 'required_if:tipeField,select,checkbox,radio',
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'string'   => 'Bagian :attribute harus berupa teks.',
            'opsi_field.required_if' => 'Opsi wajib diisi untuk tipe pilihan.',
            'help_text.string' => 'Help text harus dalam bentuk tulisan.',
            'help_text.max' => 'Help_text maksimumnya 255 kata.',
        ],[
            'namaField' => 'Nama Field',
            'tipe Field' => 'Tipe Field',
            'required'  => 'Penanda Required',
            'help_text' => 'Help text'
        ]);

        $formulir->update([
            'namaField' =>$request ->namaField,
            'tipeField' => $request->tipeField,
            'opsi_field' => $request->opsi_field,
            'required' => $request->required,
            'help_text' => $request->help_text
        ]);

        return redirect()->back()->with('success','Field berhasil ditambahkan');
    
    }

    public function active(string $id){
        $formulir = formulir::findorFail($id);
        $lowongan = $formulir->lowongan;
        if($lowongan->status == 1){
             return response()->json(['message' => 'Lowongan sudah dibuka. Field tidak bisa diubah.'],422);
        }
        $formulir->update(['status' => 1]);

        return response()->json(['message' => 'Field ini berhasil diaktifkan']);
    }

    public function nonactive(string $id){
        $formulir = formulir::findorFail($id);
        //ini kalau misalnya field itu udah di pakai gak boleh lagi
        $formulirTerpakai = $formulir->jawabanFormulir()->count();

        if($formulirTerpakai > 0){
            return response()->json(['message' => 'Field sudah dipakai pelamar. Tidak bisa dinonaktifkan.'],422);
        }
        $formulir->update(['status' => 0]);

        return response()->json(['message' => 'Field ini berhasil dinonktifkan']);
    }

    //ini buat cek misalnya salah satu udah ada atau belum (tahapan atau formulir)
    private function checkReady($idLowongan){
        $formulir = DB::table('konten_formulir')
                    ->where('idLowongan', $idLowongan)
                    ->where('status', 1)
                    ->count();
        $tahapan = DB::table('tahap_rekrutmen')
                   ->where('idLowongan',$idLowongan)
                   ->where('status',1)
                   ->count();
        if($formulir > 0 && $tahapan > 0){
            DB::table('lowongan')
                ->where('id', $idLowongan)
                ->update([
                    'is_ready' => 1
                ]);
        }else{
            DB::table('lowongan')
                ->where('id', $idLowongan)
                ->update([
                    'is_ready' => 0
                ]);
        }
    }
}
