<?php

namespace App\Http\Controllers;

use App\Models\BobotKriteria;
use App\Models\PairwiseComparison;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AHPController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $kriteria = DB::table('bobot_kriteria as b')
            ->join('kriteria as k', 'k.id', '=', 'b.idKriteria')
            ->where('b.idUnit', $idUnit)
            ->where('b.is_active', 1)
            ->select(
                'k.id',
                'k.namaKriteria as namaKriteria'
            )
            ->get();

        $pairwise = PairwiseComparison::where('idUnit', $idUnit)->get();
        $today = Carbon::today();

        $isLocked = DB::table('lowongan')
            ->where('idUnit', $idUnit)
            ->whereDate('batasPendaftaran','<', $today )
            ->whereDate('mulaiKerja', '>', $today)
            ->exists();

        return view('AHP.pairwise', compact('kriteria', 'pairwise', 'isLocked'));
    }

    public function storeBobot(Request $request)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $data = $request->data;

        $today = Carbon::today();

        $isLocked = DB::table('lowongan')
            ->where('idUnit', $idUnit)
             ->whereDate('batasPendaftaran','<', $today )
            ->whereDate('mulaiKerja', '>=', $today)
            ->exists();

        if ($isLocked) {
            return response()->json([
                'message' => 'Tidak bisa mengubah bobot karena masih ada lowongan aktif',
            ], 403);
        }

        $matrix = [];

        // ini buat matriks
        foreach ($data as $item) {
            // $i adalah baris dan $j adalah kolom
            $i = $item['kriteria1'];
            $j = $item['kriteria2'];
            $value = $item['nilai'];

            $matrix[$i][$j] = $value;
            $matrix[$j][$i] = 1 / $value;

            $matrix[$i][$i] = 1;
            $matrix[$j][$j] = 1;
        }

        $allKriteria = array_unique(array_merge(
            array_column($data, 'kriteria1'),
            array_column($data, 'kriteria2')
        ));

        foreach ($allKriteria as $i) {
            foreach ($allKriteria as $j) {
                if (!isset($matrix[$i][$j])) {
                    $matrix[$i][$j] = ($i == $j) ? 1 : 0;
                }
            }
        }

        // ini buat hitung kolom
        $colsum = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                if (! isset($colsum[$j])) {
                    $colsum[$j] = 0;
                }
                $colsum[$j] += $val;
            }
        }

        // normalisasi
        $normalized = [];
        foreach ($matrix as $i => $row) {
            foreach ($row as $j => $val) {
                $normalized[$i][$j] = $val / $colsum[$j];
            }
        }

        $bobot = [];
        foreach ($normalized as $i => $row) {
            $bobot[$i] = array_sum($row) / count($row);
        }

        $totalBobot = array_sum($bobot);

        $eigen = [];
        foreach ($matrix as $i => $row) {
            $sum = 0;
            foreach ($row as $j => $val) {
                $sum += $val * $bobot[$j];
            }
            $eigen[$i] = $sum;
        }

        $lambda = [];
        foreach ($eigen as $i => $val) {
            $lambda[$i] = $bobot[$i] != 0 ? $val / $bobot[$i] : 0;
        }

        $lambdaMax = array_sum($lambda) / count($lambda);

        $n = count($bobot);

        $CI = ($lambdaMax - $n) / ($n - 1);

        $RI = [
            1 => 0.00,
            2 => 0.00,
            3 => 0.58,
            4 => 0.90,
            5 => 1.12,
            6 => 1.24,
            7 => 1.32,
            8 => 1.41,
            9 => 1.45,
            10 => 1.49,
        ];

        $CR = $RI[$n] != 0 ? $CI / $RI[$n] : 0;
        $isConsistent = $CR < 0.1;

        $isBobotValid = abs($totalBobot - 1) < 0.01;

        if (! $isConsistent) {
            return response()->json([
                'matrix' => $matrix,
                'column' => $colsum,
                'normalisasi' => $normalized,
                'bobot' => $bobot,
                'totalBobot' => $totalBobot,
                'eigen' => $eigen,
                'lambda' => $lambda,
                'lambdaMax' => $lambdaMax,
                'CI' => $CI,
                'CR' => $CR,
                'isConsistent' => false,
                'isBobotValid' => false,
                'message' => 'Tidak konsisten, tidak disimpan',
            ]);
        }

        // simpan pairwise
        // ini delete supaya data pairwise di id itu tidak duplikat
        PairwiseComparison::where('idUnit', $idUnit)->delete();

        foreach ($data as $item) {
            PairwiseComparison::create([
                'idUnit' => $idUnit,
                'kriteriaAwal' => $item['kriteria1'],
                'kriteriaPembanding' => $item['kriteria2'],
                'nilai' => $item['nilai'],
            ]);
        }

        // ini tinggal di update aja sesuai idkriteria dan idUnit
        foreach ($bobot as $idKriteria => $nilai) {
            BobotKriteria::updateOrCreate(
                [
                    'idUnit' => $idUnit,
                    'idKriteria' => $idKriteria,
                    'is_active' => 1,
                ],
                [
                    'nilaiBobot' => $nilai,
                ]
            );
        }

        return response()->json([
            'matrix' => $matrix,
            'column' => $colsum,
            'normalisasi' => $normalized,
            'bobot' => $bobot,
            'totalBobot' => $totalBobot,
            'eigen' => $eigen,
            'lambda' => $lambda,
            'lambdaMax' => $lambdaMax,
            'CI' => $CI,
            'CR' => $CR,
            'isConsistent' => true,
            'isBobotValid' => $isBobotValid,
            'message' => $isBobotValid
                ? 'Perhitungan berhasil & bobot valid'
                : 'Bobot tidak valid (total tidak = 1)',
        ]);
    }
}
