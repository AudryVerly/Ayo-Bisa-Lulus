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
        $unit = Unit::orderBy('status','desc')->paginate(3);

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
        try
        {
            $request->validate([
                'name' => 'required',
                'deskripsi' => 'required',
                'lokasi'=> 'required',
                'kontak'=>'required',
                'emailUnit'=> 'required|email|unique:unit',
                'status'=> 'required|boolean'
            ]);
            Unit::create([
                'name'=>$request->name,
                'deskripsi'=>$request->deskripsi,
                'lokasi'=>$request->lokasi,
                'kontak'=>$request->kontak,
                'emailUnit'=>$request->emailUnit,
                'status'=> $request->status
            ]);
            return redirect()->route('units.index')->with('successs','Unit berhasil ditambahkan.');
        }catch(\Exception $e){
            return redirect()->route('units.index')->with('error','Gagal menambahkan Unit: '.$e->getMessage());
        }
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
        try{
            $unit = Unit::findOrFail($id);
            $request->validate([
                'name'=>'required',
                'deskripsi' => 'required',
                'lokasi'=> 'required',
                'kontak'=>'required',
                'emailUnit'=> 'required|email|unique:unit',

            ]);

            $unit->update([
                'name' => $request->name,
                'deskripsi' =>$request->deskripsi,
                'lokasi' =>$request->lokasi,
                'kontak' =>$request->kontak,
                'emailUnit'=>$request->emailUnit
            ]);

            return redirect()->route('units.index')->with('successs','Data berhasil diUpdate.');
        }catch(\Exception $e){
             return redirect()->route('units.index')->with('error','Gagal mengubah data unit: ' .$e->getMessage());
        }
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
