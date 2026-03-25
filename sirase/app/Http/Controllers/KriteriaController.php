<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index()
    {
        $kriteria = Kriteria::orderBy('status', 'desc')->get();

        return view('kriteria.index', compact('kriteria'));
    }

    public function storeData(Request $request)
    {
        // ini ngecek supaya kek misalnya sama atau hurig besar kecil bisa gak double update
        $namaInput = trim($request->namaKriteria);
        if (Kriteria::whereRaw('LOWER(TRIM(namaKriteria)) = ?', [strtolower($namaInput)])->exists()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Nama Kriteria sudah ada.');
        }

        $request->validate([
            'namaKriteria' => 'required',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
        ], [
            'namaKriteria' => 'nama kriteria',
        ]);

        Kriteria::create([
            'namaKriteria' => $request->namaKriteria,
            'status' => 1,
        ]);

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $dipakai = BobotKriteria::where('idKriteria', $id)->exists();

        if ($dipakai) {
            return redirect()->back()
                ->with('error', 'Kriteria sudah dipakai unit, tidak bisa diedit.');
        }

        $namaInput = trim($request->namaKriteria);

        if (Kriteria::whereRaw('LOWER(TRIM(namaKriteria)) = ?', [strtolower($namaInput)])
            ->where('id', '<>', $id)
            ->exists()
        ) {
            return redirect()->back()->withInput()->with('error', 'Nama Kriteria sudah ada.');
        }

        $request->validate([
            'namaKriteria' => 'required'
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
        ], [
            'namaKriteria' => 'nama kriteria',
        ]);

        $kriteria->update([
            'namaKriteria' => $request->namaKriteria,
        ]);

        return redirect()->back()->with('success', 'Berhasil update');
    }

    public function toggle($id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $dipakai = BobotKriteria::where('idKriteria', $id)->exists();

        if ($dipakai) {
            return redirect()->back()
                ->with('error', 'Kriteria sudah dipakai unit, tidak bisa diubah status.');
        }

        $kriteria->update([
            'status' => $kriteria->status == 1 ? 0 : 1,
        ]);

        return redirect()->back()->with('success', 'Status berhasil diubah');

    }
}
