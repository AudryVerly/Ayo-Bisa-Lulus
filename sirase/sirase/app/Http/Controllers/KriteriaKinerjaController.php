<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KriteriaKinerjaController extends Controller
{
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $kriteria = DB::table('kriteria')
            ->where('status', 1)
            ->whereNotIn('namaKriteria', ['IPK', 'Jadwal Kuliah'])
            ->get();
        $selected = DB::table('kriteria_kinerja')
            ->where('idUnit', $idUnit)
            ->where('status', 1)
            ->pluck('idKriteria')
            ->toArray();
        $kriteriaUnit = DB::table('kriteria_kinerja as kk')
            ->where('idUnit', $idUnit)
            ->select(
                'kk.nama',
                'kk.status'
            )
            ->get();

        return view('kriteriakinerja.index', compact('kriteria', 'selected', 'kriteriaUnit'));
    }

    public function storeKriteriaUnit(Request $request)
    {
        $namaInput = trim($request->namaKriteria);

        if (Kriteria::whereRaw('LOWER(TRIM(namaKriteria)) = ?', [strtolower($namaInput)])->exists()) {
            return response()->json([
                'status' => false, 'message' => 'Nama Kriteria sudah ada',
            ]);
        }

        if ($namaInput == '') {
            return response()->json([
                'status' => false,
                'message' => 'Bagian nama kriteria wajib diisi.',
            ]);
        }

        $idkriteria = DB::table('kriteria')->insertGetId([
            'namaKriteria' => $namaInput,
            'status' => 1,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Kriteria berhasil ditambahkan.',
            'id' => $idkriteria,
            'namaKriteria' => $namaInput,
        ]);

    }

    public function saveKriteriaUnit(Request $request)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $kriteriaDipilih = $request->kriteria;

        if (! $kriteriaDipilih || count($kriteriaDipilih) == 0) {
            return redirect()->back()->with('error', 'Minimal pilih 1 kriteria');
        }

        DB::transaction(function () use ($idUnit, $kriteriaDipilih) {

            DB::table('kriteria_kinerja')
                ->where('idUnit', $idUnit)
                ->update(['status' => 0]);
            foreach ($kriteriaDipilih as $idKriteria) {
                $nama = DB::table('kriteria')
                    ->where('id', $idKriteria)
                    ->value('namaKriteria');
                $cek = DB::table('kriteria_kinerja')
                    ->where('idUnit', $idUnit)
                    ->where('idKriteria', $idKriteria)
                    ->first();
                if ($cek) {
                    DB::table('kriteria_kinerja')
                        ->where('idUnit', $idUnit)
                        ->where('idKriteria', $idKriteria)
                        ->update([
                            'status' => 1,
                            'nama' => $nama,
                        ]);
                } else {
                    DB::table('kriteria_kinerja')->insert([
                        'idUnit' => $idUnit,
                        'idKriteria' => $idKriteria,
                        'nama' => $nama,
                        'status' => 1,
                    ]);
                }
            }
        });

        return redirect()->back()->with('success', 'Kriteria kinerja berhasil disimpan');
    }

    public function resetKriteria()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        DB::table('kriteria_kinerja')
            ->where('idUnit', $idUnit)
            ->update([
                'status' => 0,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'Kriteria kinerja berhasil direset',
        ]);
    }
}
