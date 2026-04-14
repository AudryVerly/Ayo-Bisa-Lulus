<?php

namespace App\Http\Controllers;

use App\Models\KualitasKerja;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenilaianKinerjaController extends Controller
{
    public function showNilaiKinerja()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $unit = Unit::findOrFail($idUnit);
        $nilaiKinerja = KualitasKerja::with(['unit'])
            ->where('idUnit', $idUnit)
            ->orderBy('status', 'desc')
            ->get();

        return view('penilaiankinerja.indexnilai', compact('nilaiKinerja', 'unit'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'idUnit' => 'required',
            'nilaiMin' => 'required|numeric|min:0|max:100',
            'nilaiMax' => 'required|numeric|gt:nilaiMin|max:100',
            'kategori' => 'nullable|string|max:100',
            'kategori_select' => 'nullable|string',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'numeric' => 'Bagian :attribute wajib berupa angka.',
            'min' => 'Bagian :attribute minimal sesuai yang ditentukan',
            'max' => 'Bagian :attribute max sesuai yang ditentukan',
            'nilaiMax.gt' => 'nilai Max harus lebih besar dari nilai min',
        ], [
            'idUnit' => 'id Unit',
            'nilaiMin' => 'nilai minimal',
            'nilaiMax' => 'nilai maksimal',
            'kategori' => 'kategori',
            'kategori_select' => 'kategori lainnya',
        ]);

        if ($request->kategori_select === 'lainnya') {
            $kategori = $request->kategori;
        } else {
            $kategori = $request->kategori_select;
        }

        if (! $kategori) {
            return back()->withErrors(['kategori' => 'Kategori wajib diisi'])->withInput();
        }

        KualitasKerja::create([
            'idUnit' => $request->idUnit,
            'nilaiMin' => $request->nilaiMin,
            'nilaiMax' => $request->nilaiMax,
            'kategori' => $kategori,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function updateNilaiKinerja(Request $request, $id)
    {
        $request->validate([
            'nilaiMin' => 'required|numeric|min:0|max:100',
            'nilaiMax' => 'required|numeric|gt:nilaiMin|max:100',
            'kategori' => 'nullable|string|max:100',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'numeric' => 'Bagian :attribute wajib berupa angka.',
            'min' => 'Bagian :attribute minimal sesuai yang ditentukan',
            'max' => 'Bagian :attribute max sesuai yang ditentukan',
            'nilaiMax.gt' => 'nilai Max harus lebih besar dari nilai min',
        ], [
            'nilaiMin' => 'nilai minimal',
            'nilaiMax' => 'nilai maksimal',
            'kategori' => 'kategori',
        ]);

        $data = KualitasKerja::findOrFail($id);

        $kategori = $request->kategori_select === 'lainnya'
            ? $request->kategori
            : $request->kategori_select;

        if (! $kategori) {
            return back()->withErrors(['kategori' => 'Kategori wajib diisi'])->withInput();
        }

        $data->update([
            'nilaiMin' => $request->nilaiMin,
            'nilaiMax' => $request->nilaiMax,
            'kategori' => $kategori,
        ]);

        return back()->with('success', 'Data berhasil diupdate');

    }

    public function toggleStatus($id)
    {
        $data = KualitasKerja::findOrFail($id);

        $newStatus = $data->status == 1 ? 0 : 1;

        KualitasKerja::where('id', $id)->update([
            'status' => $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'id' => $id,
        ]);
    }
}
