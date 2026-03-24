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
        $request->validate([
            'namaKriteria' => 'required|unique:kriteria,namaKriteria',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'namaKriteria.unique' => 'Nama Kriteria yang dimasukkan sudah ada didata ',
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

        $request->validate([
            'namaKriteria' => 'required|unique:kriteria,namaKriteria,'.$id,
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'namaKriteria.unique' => 'Nama Kriteria yang dimasukkan sudah ada didata ',
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
