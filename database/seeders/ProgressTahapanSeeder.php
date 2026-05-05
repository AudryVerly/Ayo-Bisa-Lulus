<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgressTahapanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('progress_tahapan_kandidat')->insert([
            //pendaftaran 1
            [
                'idTahapRekrutmen' => 21,
                'idPendaftaran' => 1,
                'status' => 'Lulus',
                'catatan' => "Semua berkas yang diperlukan sudah aman"
            ],
            [
                'idTahapRekrutmen' => 22,
                'idPendaftaran' => 1,
                'status' => 'Lulus',
                'catatan' => "Semua wawancara telah di siapkan"
            ],
            [
                'idTahapRekrutmen' => 23,
                'idPendaftaran' => 1,
                'status' => 'Lulus',
                'catatan' => "Penilaian telah dia lakukan"
            ],
            [
                'idTahapRekrutmen' => 24,
                'idPendaftaran' => 1,
                'status' => 'Lulus',
                'catatan' => "Hasil akhir pengumuman"
            ],

            //pendaftaran 2
            [
                'idTahapRekrutmen' => 25,
                'idPendaftaran' => 2,
                'status' => 'Lulus',
                'catatan' => "Semua berkas yang diperlukan sudah aman"
            ],
            [
                'idTahapRekrutmen' => 26,
                'idPendaftaran' => 2,
                'status' => 'Lulus',
                'catatan' => "Semua wawancara telah di siapkan"
            ],
            [
                'idTahapRekrutmen' => 27,
                'idPendaftaran' => 2,
                'status' => 'Lulus',
                'catatan' => "Penilaian telah dia lakukan"
            ],
            [
                'idTahapRekrutmen' => 28,
                'idPendaftaran' => 2,
                'status' => 'Lulus',
                'catatan' => "Hasil akhir pengumuman"
            ],
            //pendaftaran 5
            [
                'idTahapRekrutmen' => 5,
                'idPendaftaran' => 5,
                'status' => 'Proses',
                'catatan' => ''
            ],
            //pendaftaran 6
            [
                'idTahapRekrutmen' => 9 ,
                'idPendaftaran' => 6,
                'status' => 'Proses',
                'catatan' => ''
            ]
        ]);
    }
}
