<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\Kriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'namaKriteria' => 'required',
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

    public function showKriteriaUnit()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $kriteriaExists = DB::table('bobot_kriteria')
            ->where('idUnit', $idUnit)
            ->where('is_active', 1)
            ->exists();

        $today = Carbon::today();
        $isLocked = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->whereDate('batasPendaftaran', '<', $today)
            ->whereDate('mulaiKerja', '>=', $today)
            ->exists();

        $kriteria = DB::table('kriteria')
            ->where('status', 1)
            ->get();
        $selected = DB::table('bobot_kriteria')
            ->where('idUnit', $idUnit)
            ->where('is_active', 1)
            ->pluck('idKriteria')
            ->toArray();
        $lockedKriteria = DB::table('penilaian_setiap_bobot as psb')
            ->join('bobot_kriteria as bk', 'psb.idBobotKriteria', '=', 'bk.id')
            ->where('bk.idUnit', $idUnit)
            ->pluck('bk.idKriteria')
            ->unique()
            ->toArray();
        $kriteriaUnit = DB::table('bobot_kriteria as bk')
            ->join('kriteria as k', 'bk.idKriteria', '=', 'k.id')
            ->where('bk.idUnit', $idUnit)
            ->select(
                'k.namaKriteria',
                'bk.nilaiBobot',
                'bk.is_active'
            )
            ->get();

        return view('kriteria.kriteriaunit', compact('kriteria', 'selected', 'kriteriaUnit', 'isLocked', 'kriteriaExists','lockedKriteria'));
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

    public function saveBobotKriteriaUnit(Request $request)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        $kriteriaDipilih = $request->kriteria;

        if (! $kriteriaDipilih || count($kriteriaDipilih) < 2) {
            return redirect()->back()
                ->with('error', 'Minimal pilih 2 kriteria');
        }

        $lockedKriteria = DB::table('penilaian_setiap_bobot')
            ->pluck('idBobotKriteria')
            ->toArray();

        // if (count($kriteriaDipilih) > 5) {
        //     return back()->with('error', 'Maksimal 5 kriteria');
        // }

        DB::transaction(function () use ($idUnit, $kriteriaDipilih, $lockedKriteria) {

            $sudahada = DB::table('bobot_kriteria')
                ->where('idUnit', $idUnit)
                ->pluck('idKriteria')
                ->toArray();

            foreach ($kriteriaDipilih as $idKriteria) {
                if (in_array($idKriteria, $lockedKriteria)) {
                    continue;
                }

                $cek = DB::table('bobot_kriteria')
                    ->where('idUnit', $idUnit)
                    ->where('idKriteria', $idKriteria)
                    ->first();
                if ($cek) {
                    DB::table('bobot_kriteria')
                        ->where('idUnit', $idUnit)
                        ->where('idKriteria', $idKriteria)
                        ->update([
                            'is_active' => 1,
                        ]);
                } else {
                    DB::table('bobot_kriteria')->insert([
                        'idUnit' => $idUnit,
                        'idKriteria' => $idKriteria,
                        'nilaiBobot' => 0,
                        'is_active' => 1,
                    ]);
                }
            }
        });

        return redirect()->route('ahp.show')
            ->with('success', 'Konfigurasi kriteria berhasil disimpan');
    }

    public function resetKriteria()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();

        DB::table('bobot_kriteria')
            ->where('idUnit', $idUnit)
            ->update([
                'is_active' => 0,
            ]);

        return response()->json([
            'status' => true,
            'message' => 'kriteria berhasil direset',
        ]);
    }
}
