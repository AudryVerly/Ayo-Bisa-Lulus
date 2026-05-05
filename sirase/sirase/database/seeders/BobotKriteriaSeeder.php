<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BobotKriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bobot_kriteria')->insert([
            [
                'id' => 1,
                'idUnit' => 1,
                'idKriteria' => 3,
                'nilaiBobot' => 0.63334572030224,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'idUnit' => 1,
                'idKriteria' => 4,
                'nilaiBobot' => 0.26049795615013,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'idUnit' => 1,
                'idKriteria' => 5,
                'nilaiBobot' => 0.10615632354763,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'idUnit' => 2,
                'idKriteria' => 1,
                'nilaiBobot' => 0.49904685624455,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' =>now(),
            ],
            [
                'id' => 5,
                'idUnit' => 2,
                'idKriteria' => 2,
                'nilaiBobot' => 0.24920781806126,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 6,
                'idUnit' => 2,
                'idKriteria' => 4,
                'nilaiBobot' => 0.15056927872858,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'idUnit' => 2,
                'idKriteria' => 5,
                'nilaiBobot' => 0.067071686688692,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'idUnit' => 2,
                'idKriteria' => 6,
                'nilaiBobot' => 0.034104360276913,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'idUnit' => 3,
                'idKriteria' => 3,
                'nilaiBobot' => 0.55789247517189,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' =>now(),
            ],
            [
                'id' => 10,
                'idUnit' => 3,
                'idKriteria' => 4,
                'nilaiBobot' => 0.26334511077158,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' =>now(),
            ],
            [
                'id' => 11,
                'idUnit' => 3,
                'idKriteria' => 5,
                'nilaiBobot' => 0.12187261268144,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 12,
                'idUnit' => 3,
                'idKriteria' => 6,
                'nilaiBobot' => 0.056889801375096,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
