<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TahapRekrutmenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tahap_rekrutmen')->insert([

            // ================= LOWONGAN 1 =================
            ['idLowongan' => 1, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 1, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 1, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 1, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 2 =================
            ['idLowongan' => 2, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 2, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 2, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 2, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 3 =================
            ['idLowongan' => 3, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 3, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 3, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 3, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 4 =================
            ['idLowongan' => 4, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 4, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 4, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 4, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 5 =================
            ['idLowongan' => 5, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 5, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 5, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 5, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 6 =================
            ['idLowongan' => 6, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 6, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 6, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 6, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],

            // ================= LOWONGAN 7 =================
            ['idLowongan' => 7, 'name' => 'Seleksi Administrasi', 'urutan' => 1, 'tipe_tahap' => 'Seleksi', 'status' => 1],
            ['idLowongan' => 7, 'name' => 'Wawancara', 'urutan' => 2, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 7, 'name' => 'Penilaian / Evaluasi', 'urutan' => 3, 'tipe_tahap' => 'Wawancara', 'status' => 1],
            ['idLowongan' => 7, 'name' => 'Pengumuman Hasil', 'urutan' => 4, 'tipe_tahap' => 'Final', 'status' => 1],
        ]);
    }
}
