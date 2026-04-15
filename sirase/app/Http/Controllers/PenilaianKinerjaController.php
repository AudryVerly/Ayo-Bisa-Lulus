<?php

namespace App\Http\Controllers;

use App\Models\KualitasKerja;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    // ini untuk bagian tugas yess
    public function listUnitTugas()
    {
        $unitId = Auth::user()->staffUnit()->pluck('idUnit');

        $unit = Unit::whereIn('id', $unitId)->get();

        return view('penilaiankinerja.listunit', compact('unit'));
    }

    public function listTugasStaff($idUnit)
    {
        $data = DB::table('tugas as t')
            ->join('tugas_mahasiswa as tm', 'tm.idTugas', '=', 't.id')
            ->join('mahasiswa as m', 'm.id', '=', 'tm.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->where('t.idUnit', $idUnit)
            ->select(
                'u.name as namaMahasiswa',
                't.namaTugas',
                't.deskripsi',
                't.bobotNilai',
                't.tenggatPengumpulan',
                't.progressTugas',
                'tm.file_path',
                'tm.statusPengumpulan',
                'tm.tanggalPengumpulan'
            )
            ->get();

        return view('penilaiankinerja.listtugasstaff', compact('data', 'idUnit'));
    }

    public function createTugas($idUnit)
    {
        $mahasiswa = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->where('p.statusPendaftaran', 'diterima')
            ->where('l.idUnit', $idUnit)
            ->where('l.akhirKerja', '>=', now())
            ->select(
                'm.id as idMahasiswa',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan'
            )
            ->get();

        return view('penilaiankinerja.createTugas', compact('mahasiswa', 'idUnit'));
    }

    public function storeTugas(Request $request)
    {
        $request->validate([
            'idUnit' => 'required',
            'idMahasiswa' => 'required',
            'namaTugas' => 'required',
            'deskripsi' => 'required',
            'bobotNilai' => 'required|numeric',
            'tenggatPengumpulan' => 'required|date',
        ], [
            'required' => 'Bagian :attribute wajib untuk diisi.',
            'numeric' => 'Bagian :attribute wajib dalam bentuk angka',
            'date' => 'Bagian :attribute wajib dalam bentuk tanggal',
        ], [
            'idUnit' => 'isUnit',
            'idMahasiswa' => 'idMahasiswa',
            'namaTugas' => 'nama Tugas',
            'deskripsi' => 'deskripsi',
            'bobotNilai' => 'bobot nilai',
            'tenggatPengumpulan' => 'tenggat pengumpulan',
        ]);

        DB::transaction(function () use ($request) {
            $idStaffUnit = Auth::user()->staffUnit()->pluck('id')->first();

            $idTugas = DB::table('tugas')->insertGetId([
                'idStaffUnit' => $idStaffUnit,
                'idUnit' => $request->idUnit,
                'namaTugas' => $request->namaTugas,
                'deskripsi' => $request->deskripsi,
                'bobotNilai' => $request->bobotNilai,
                'tenggatPengumpulan' => $request->tenggatPengumpulan,
                'progressTugas' => 'assigned',
            ]);

            DB::table('tugas_mahasiswa')->insert([
                'idMahasiswa' => $request->idMahasiswa,
                'idTugas' => $idTugas,
                'statusPengumpulan' => null,
                'tanggalPengumpulan' => null,
                'file_path' => null,
                'catatan' => null,
            ]);
        });

        return redirect()
            ->route('tugas.listtugas', $request->idUnit)
            ->with('success', 'Tugas berhasil ditambahkan');
    }
}
