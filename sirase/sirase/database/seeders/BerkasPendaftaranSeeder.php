<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BerkasPendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('berkas_pendaftaran')->insert([
            [
                'idPendaftaran' => 1,
                'idKontenFormulir' => 39, 
                'namaFile' => 'CV_Ahmad_Fauzan.pdf',
                'filePath' => 'berkas_pendaftaran/1/CV_Ahmad_Fauzan.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 45, // CV Lowongan 7
                'namaFile' => 'CV_Raka_Putra.pdf',
                'filePath' => 'berkas_pendaftaran/2/CV_Raka_Putra.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 8, // CV Lowongan 1
                'namaFile' => 'CV_Siti_Rahma.pdf',
                'filePath' => 'berkas_pendaftaran/3/CV_Siti_Rahma.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 21, // CV Lowongan 3
                'namaFile' => 'CV_Bima_Prakoso.pdf',
                'filePath' => 'berkas_pendaftaran/4/CV_Bima_Prakoso.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 15, // CV Lowongan 2
                'namaFile' => 'CV_Cindy_Oktavia.pdf',
                'filePath' => 'berkas_pendaftaran/4/CV_Cindy_Oktavia.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 21, // CV Lowongan 3
                'namaFile' => 'CV_Yoga_Saputra.pdf',
                'filePath' => 'berkas_pendaftaran/6/CV_Yoga_Saputra.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 8, // CV Lowongan 1
                'namaFile' => 'CV_Dewi_Lestari.pdf',
                'filePath' => 'berkas_pendaftaran/7/CV_Dewi_Lestari.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 15, // CV Lowongan 2
                'namaFile' => 'CV_Nadya_Safira.pdf',
                'filePath' => 'berkas_pendaftaran/8/CV_Nadya_Safira.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
