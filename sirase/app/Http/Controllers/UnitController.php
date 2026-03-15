<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $unit = Unit::orderBy('status','desc')->get();

        return view('units.index', compact('unit'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'deskripsi' => 'required',
            'lokasi'=> 'required',
            'kontak'=>'required',
            'emailUnit'=> 'required|email|unique:unit',
            'status'=> 'required|boolean'
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'email'     => ':attribute wajib mengguna format email yang valid.',
            'unique'     => ':attribute tidak boleh sama dengan email unit yang sudah terdaftar',
        ],[
            'name' => 'nama unit',
            'deskripsi' => 'deskripsi unit',
            'lokasi' => 'lokasi unit',
            'kontak' => 'kontak unit',
            'emailUnit' => 'email unit',
            'status' => 'Status Unit'
        ]);
        Unit::create([
            'name'=>$request->name,
            'deskripsi'=>$request->deskripsi,
            'lokasi'=>$request->lokasi,
            'kontak'=>$request->kontak,
            'emailUnit'=>$request->emailUnit,
            'status'=> $request->status
        ]);
        return redirect()->route('units.index')->with('success','Unit berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.show',compact('unit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $unit = Unit::findOrFail($id);
        return view('units.edit',compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $unit = Unit::findOrFail($id);
        $request->validate([
            'name'=>'required',
            'deskripsi' => 'required',
            'lokasi'=> 'required',
            'kontak'=>'required',
            'emailUnit'=> 'required|email|unique:unit,emailUnit,' . $unit->id . ',id',

        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'email'     => ':attribute wajib mengguna format email yang valid.',
            'unique'     => ':attribute tidak boleh sama dengan email unit yang sudah terdaftar',
        ],[
            'name' => 'nama unit',
            'deskripsi' => 'deskripsi unit',
            'lokasi' => 'lokasi unit',
            'kontak' => 'kontak unit',
            'emailUnit' => 'email unit',
        ]);

        $unit->update([
            'name' => $request->name,
            'deskripsi' =>$request->deskripsi,
            'lokasi' =>$request->lokasi,
            'kontak' =>$request->kontak,
            'emailUnit'=>$request->emailUnit
        ]);

        return redirect()->route('units.index')->with('success','Data berhasil diUpdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $unit = Unit::findOrFail($id);
        $unit->update(['status' => 0]);

        return response()->json(['message' => 'Unit berhasil dinonaktifkan']);
    }

    public function active(string $id){
        $unit = Unit::findOrFail($id);
        $unit->update(['status' => 1]);

        return response()->json(['message' => 'Unit berhasil diaktifkan']);
    }
}
