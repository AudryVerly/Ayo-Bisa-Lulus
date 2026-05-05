<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianBobotKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penilaian_setiap_bobot')->insert([
            // ===== ID PENILAIAN 2 =====
            [
                'idPenilaianKandidat' => 2,
                'idBobotKriteria' => 1,
                'bobotKriteria' => 0.63334572030224,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.63334572030224,
            ],
            [
                'idPenilaianKandidat' => 2,
                'idBobotKriteria' => 2,
                'bobotKriteria' => 0.26049795615013,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.2083983649201,
            ],
            [
                'idPenilaianKandidat' => 2,
                'idBobotKriteria' => 3,
                'bobotKriteria' => 0.10615632354763,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.10615632354763,
            ],

            // ===== ID PENILAIAN 3 =====
            [
                'idPenilaianKandidat' => 3,
                'idBobotKriteria' => 1,
                'bobotKriteria' => 0.63334572030224,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.63334572030224,
            ],
            [
                'idPenilaianKandidat' => 3,
                'idBobotKriteria' => 2,
                'bobotKriteria' => 0.26049795615013,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.2083983649201,
            ],
            [
                'idPenilaianKandidat' => 3,
                'idBobotKriteria' => 3,
                'bobotKriteria' => 0.10615632354763,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.084925058838104,
            ],

            // ===== ID PENILAIAN 4 =====
            [
                'idPenilaianKandidat' => 4,
                'idBobotKriteria' => 4,
                'bobotKriteria' => 0.49904685624455,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.49904685624455,
            ],
            [
                'idPenilaianKandidat' => 4,
                'idBobotKriteria' => 5,
                'bobotKriteria' => 0.24920781806126,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.24920781806126,
            ],
            [
                'idPenilaianKandidat' => 4,
                'idBobotKriteria' => 6,
                'bobotKriteria' => 0.15056927872858,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.12045542298286,
            ],
            [
                'idPenilaianKandidat' => 4,
                'idBobotKriteria' => 7,
                'bobotKriteria' => 0.067071686688692,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.053657349350954,
            ],
            [
                'idPenilaianKandidat' => 4,
                'idBobotKriteria' => 8,
                'bobotKriteria' => 0.034104360276913,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.034104360276913,
            ],

            // ===== ID PENILAIAN 5 =====
            [
                'idPenilaianKandidat' => 5,
                'idBobotKriteria' => 4,
                'bobotKriteria' => 0.49904685624455,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.49904685624455,
            ],
            [
                'idPenilaianKandidat' => 5,
                'idBobotKriteria' => 5,
                'bobotKriteria' => 0.24920781806126,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.19936625444901,
            ],
            [
                'idPenilaianKandidat' => 5,
                'idBobotKriteria' => 6,
                'bobotKriteria' => 0.15056927872858,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.12045542298286,
            ],
            [
                'idPenilaianKandidat' => 5,
                'idBobotKriteria' => 7,
                'bobotKriteria' => 0.067071686688692,
                'nilaiAwal' => 5,
                'nilaiAkhir' => 0.067071686688692,
            ],
            [
                'idPenilaianKandidat' => 5,
                'idBobotKriteria' => 8,
                'bobotKriteria' => 0.034104360276913,
                'nilaiAwal' => 4,
                'nilaiAkhir' => 0.02728348822153,
            ],
        ]);
    }
}
