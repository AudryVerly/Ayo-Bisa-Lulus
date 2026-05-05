<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penilaian_kinerja')->insert([
            [
                'idTugas' => 1,
                'idMahasiswa' => 1,
                'nilaiAwal' => 80,
                'penalti' => 0,
                'nilaiAkhir' => 80,
                'catatan' => 'Baik',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 2,
                'idMahasiswa' => 1,
                'nilaiAwal' => 75,
                'penalti' => 5,
                'nilaiAkhir' => 70,
                'catatan' => 'Terlambat',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 3,
                'idMahasiswa' => 1,
                'nilaiAwal' => 85,
                'penalti' => 0,
                'nilaiAkhir' => 85,
                'catatan' => 'Sangat baik',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 4,
                'idMahasiswa' => 1,
                'nilaiAwal' => 70,
                'penalti' => 0,
                'nilaiAkhir' => 70,
                'catatan' => 'Cukup',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 5,
                'idMahasiswa' => 1,
                'nilaiAwal' => 90,
                'penalti' => 10,
                'nilaiAkhir' => 80,
                'catatan' => 'Kurang Memuaskan',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 6,
                'idMahasiswa' => 7,
                'nilaiAwal' => 85,
                'penalti' => 0,
                'nilaiAkhir' => 85,
                'catatan' => 'Baik',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 7,
                'idMahasiswa' => 7,
                'nilaiAwal' => 90,
                'penalti' => 0,
                'nilaiAkhir' => 90,
                'catatan' => 'Sangat Baik',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 8,
                'idMahasiswa' => 7,
                'nilaiAwal' => 80,
                'penalti' => 5,
                'nilaiAkhir' => 75,
                'catatan' => 'Terlambat',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 9,
                'idMahasiswa' => 7,
                'nilaiAwal' => 75,
                'penalti' => 0,
                'nilaiAkhir' => 75,
                'catatan' => 'Cukup',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idTugas' => 10,
                'idMahasiswa' => 7,
                'nilaiAwal' => 95,
                'penalti' => 0,
                'nilaiAkhir' => 95,
                'catatan' => 'Sangat Baik',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
