<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['user'])
        ->orderBy('status','desc')
        ->get();
        return view('mahasiswa.index',compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::whereIn('role',['Mahasiswa'])
                ->where('status',1)
                ->doesntHave('mahasiswa') //ini supaya data yang muncul adalaha user dengan role mahasiswa yang belum ada datanya di mahasiswa
                ->orderBy('name')
                ->get();
        return view('mahasiswa.create',compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idUser' => 'required:exists:users,id',
            'nrp' => 'required|integer',
            'fakultas' => 'required',
            'jurusan' => 'required',
            'tahunMasuk' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'noTelepon' => 'required',
            'status' => 'required|boolean',
        ]);

            // simpan ke tabel mahasiswa
        Mahasiswa::create([
            'idUser' => $request->idUser,
            'nrp' => $request->nrp,
            'fakultas' => $request->fakultas,
            'jurusan' => $request->jurusan,
            'tahunMasuk' => $request->tahunMasuk,
            'noTelepon' => $request->noTelepon,
            'status' => $request->status,
        ]);

         return redirect()->route('mahasiswa.index')->with('success', 'Mahasiswa berhasil ditambahkan ke data');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mahasiswa = Mahasiswa::with(['user'])
                    ->findOrFail($id);
        return view('mahasiswa.show',compact('mahasiswa'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $fakultasList = [
            'Fakultas Farmasi', 'Fakultas Hukum', 'Fakultas Bisnis', 'Fakultas Psikologi',
                'Fakultas Teknik', 'Fakultas Industri Kreatif', 'Fakultas Kedokteran', 'Fakultas Bioteknologi'
        ];
        $mahasiswa = Mahasiswa::with(['user'])
                    ->findOrFail($id);
        return view('mahasiswa.edit', compact('mahasiswa','fakultasList'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $request->validate([
            'nrp' => 'required|integer',
            'fakultas' => 'required',
            'jurusan' => 'required',
            'tahunMasuk' => 'required|digits:4|integer|min:1900|max:' . date('Y'),
            'noTelepon' => 'required',
        ]);

            // simpan ke tabel mahasiswa
         $mahasiswa->update([
            'nrp' => $request->nrp,
            'fakultas' => $request->fakultas,
            'jurusan' => $request->jurusan,
            'tahunMasuk' => $request->tahunMasuk,
            'noTelepon' => $request->noTelepon,
         ]);
        return redirect()->route('mahasiswa.index')->with('success', 'Berhasil Menggubah data Mahasiswa');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update(['status' => 0]);

        return response()->json(['message' => 'Mahasiswa berhasil dinonaktifkan']);
    }

    public function active(string $id)
    {
        $mahasiswa = Mahasiswa::findOrFail($id);
        $mahasiswa->update(['status' => 1]);

        return response()->json(['message' => 'Mahasiswa berhasil diaktifkan']);

    }
}
