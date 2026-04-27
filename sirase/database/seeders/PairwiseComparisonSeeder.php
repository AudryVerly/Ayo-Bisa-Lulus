<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PairwiseComparisonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pairwise_comparison')->insert([
            [
                'idUnit' => 1,
                'kriteriaAwal' => 3,
                'kriteriaPembanding' => 4,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'kriteriaAwal' => 3,
                'kriteriaPembanding' => 5,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 1,
                'kriteriaAwal' => 4,
                'kriteriaPembanding' => 5,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Unit 2
            [
                'idUnit' => 2,
                'kriteriaAwal' => 1,
                'kriteriaPembanding' => 2,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 1,
                'kriteriaPembanding' => 4,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 1,
                'kriteriaPembanding' => 5,
                'nilai' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 1,
                'kriteriaPembanding' => 6,
                'nilai' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 2,
                'kriteriaPembanding' => 4,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 2,
                'kriteriaPembanding' => 5,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 2,
                'kriteriaPembanding' => 6,
                'nilai' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 4,
                'kriteriaPembanding' => 5,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 4,
                'kriteriaPembanding' => 6,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 2,
                'kriteriaAwal' => 5,
                'kriteriaPembanding' => 6,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Unit 3
            [
                'idUnit' => 3,
                'kriteriaAwal' => 3,
                'kriteriaPembanding' => 4,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'kriteriaAwal' => 3,
                'kriteriaPembanding' => 5,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'kriteriaAwal' => 3,
                'kriteriaPembanding' => 6,
                'nilai' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'kriteriaAwal' => 4,
                'kriteriaPembanding' => 5,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'kriteriaAwal' => 4,
                'kriteriaPembanding' => 6,
                'nilai' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idUnit' => 3,
                'kriteriaAwal' => 5,
                'kriteriaPembanding' => 6,
                'nilai' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
