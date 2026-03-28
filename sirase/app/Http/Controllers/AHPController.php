<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        return view('AHP.pairwise', compact('kriteria'));
    }

    public function storeBobot(Request $request)
    {
        $data = $request->data;

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
            $lambda[$i] = $val / $bobot[$i];
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
            'isConsistent' => $isConsistent,
        ]);
    }
}
