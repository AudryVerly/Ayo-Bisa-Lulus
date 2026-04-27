<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KualitasKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kualitas_kinerja')->insert([
            // ===================== UNIT 1 =====================
            [
                'idUnit' => 1,
                'nilaiMin' => 0,
                'nilaiMax' => 59.99,
                'kategori' => 'Sangat Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'nilaiMin' => 60,
                'nilaiMax' => 69.99,
                'kategori' => 'Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'nilaiMin' => 70,
                'nilaiMax' => 79.99,
                'kategori' => 'Cukup',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'nilaiMin' => 80,
                'nilaiMax' => 89.99,
                'kategori' => 'Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'nilaiMin' => 90,
                'nilaiMax' => 100,
                'kategori' => 'Sangat Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===================== UNIT 2 =====================
            [
                'idUnit' => 2,
                'nilaiMin' => 0,
                'nilaiMax' => 59.99,
                'kategori' => 'Sangat Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'nilaiMin' => 60,
                'nilaiMax' => 69.99,
                'kategori' => 'Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'nilaiMin' => 70,
                'nilaiMax' => 79.99,
                'kategori' => 'Cukup',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'nilaiMin' => 80,
                'nilaiMax' => 89.99,
                'kategori' => 'Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'nilaiMin' => 90,
                'nilaiMax' => 100,
                'kategori' => 'Sangat Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ===================== UNIT 3 =====================
            [
                'idUnit' => 3,
                'nilaiMin' => 0,
                'nilaiMax' => 59.99,
                'kategori' => 'Sangat Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'nilaiMin' => 60,
                'nilaiMax' => 69.99,
                'kategori' => 'Buruk',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'nilaiMin' => 70,
                'nilaiMax' => 79.99,
                'kategori' => 'Cukup',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'nilaiMin' => 80,
                'nilaiMax' => 89.99,
                'kategori' => 'Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'nilaiMin' => 90,
                'nilaiMax' => 100,
                'kategori' => 'Sangat Baik',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
