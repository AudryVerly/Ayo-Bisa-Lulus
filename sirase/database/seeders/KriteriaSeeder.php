<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kriteria')->insert([
            [
                'namaKriteria' => 'IPK',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Jadwal Kuliah',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Problem Solving',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Critical Thinking',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Time Management',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Team Work',
                'status' => 1
            ],
            [
                'namaKriteria' => 'Kreativitas',
                'status' => 1
            ]
        ]);
    }
}
