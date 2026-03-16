<?php

namespace App\Http\Controllers;

use App\Models\formulir;
use App\Models\Lowongan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
        return view('formulir.applicationForm', compact('lowongan','field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $formulir = formulir::findorfail($id);
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
        $formulir->update(['status' => 1]);

        return response()->json(['message' => 'Field ini berhasil diaktifkan']);
    }

    public function nonactive(string $id){
        $formulir = formulir::findorFail($id);
        $formulir->update(['status' => 0]);

        return response()->json(['message' => 'Field ini berhasil dinonktifkan']);
    }
}
