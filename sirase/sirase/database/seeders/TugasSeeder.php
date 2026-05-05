<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tugas')->insert([
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Input Data Mahasiswa',
                'deskripsi' => 'Melakukan input data mahasiswa ke sistem',
                'bobotNilai' => 80,
                'tenggatPengumpulan' => '2026-05-01',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Rekap Absensi',
                'deskripsi' => 'Merekap data absensi harian',
                'bobotNilai' => 75,
                'tenggatPengumpulan' => '2026-05-02',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 6,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Validasi Data',
                'deskripsi' => 'Memvalidasi data pendaftar',
                'bobotNilai' => 85,
                'tenggatPengumpulan' => '2026-05-03',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 7,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Input Excel',
                'deskripsi' => 'Memasukkan data ke excel',
                'bobotNilai' => 70,
                'tenggatPengumpulan' => '2026-05-04',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 7,
                'idUnit' => 1,
                'idLowongan' => 6,
                'namaTugas' => 'Update Database',
                'deskripsi' => 'Update data pada database',
                'bobotNilai' => 90,
                'tenggatPengumpulan' => '2026-05-05',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 8,
                'idUnit' => 2,
                'idLowongan' => 7,
                'namaTugas' => 'Riset Market Startup',
                'deskripsi' => 'Melakukan riset market untuk ide startup',
                'bobotNilai' => 85,
                'tenggatPengumpulan' => '2026-05-10',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 8,
                'idUnit' => 2,
                'idLowongan' => 7,
                'namaTugas' => 'Buat Pitch Deck',
                'deskripsi' => 'Menyusun pitch deck startup',
                'bobotNilai' => 90,
                'tenggatPengumpulan' => '2026-05-12',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 9,
                'idUnit' => 2,
                'idLowongan' => 7,
                'namaTugas' => 'Analisis Kompetitor',
                'deskripsi' => 'Menganalisis kompetitor startup',
                'bobotNilai' => 80,
                'tenggatPengumpulan' => '2026-05-14',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 9,
                'idUnit' => 2,
                'idLowongan' => 7,
                'namaTugas' => 'Validasi Ide',
                'deskripsi' => 'Melakukan validasi ide ke user',
                'bobotNilai' => 75,
                'tenggatPengumpulan' => '2026-05-16',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idStaffUnit' => 8,
                'idUnit' => 2,
                'idLowongan' => 7,
                'namaTugas' => 'Laporan Akhir Startup',
                'deskripsi' => 'Menyusun laporan akhir startup',
                'bobotNilai' => 95,
                'tenggatPengumpulan' => '2026-05-18',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
