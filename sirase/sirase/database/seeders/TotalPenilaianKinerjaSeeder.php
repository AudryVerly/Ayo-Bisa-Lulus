<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TotalPenilaianKinerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('total_penilaian_kinerja')->insert([
            [
                'idPendaftaran' => 1,
                'totalNilai' => 77,
                'kategori' => 'Cukup',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPendaftaran' => 2,
                'totalNilai' => 84,
                'kategori' => 'Baik',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
