<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TugasMahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tugas_mahasiswa')->insert([
            [
                'idMahasiswa' => 1,
                'idTugas' => 1,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-04-28',
                'tenggatRevisi' => '2026-05-02',
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/1/file1.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 1,
                'idTugas' => 2,
                'statusPengumpulan' => 'terlambat',
                'tanggalPengumpulan' => '2026-05-03',
                'tenggatRevisi' => '2026-05-05',
                'catatanRevisi' => 'Perbaiki format',
                'progressTugas' => 'done',
                'file_path' => 'tugas/2/file2.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 1,
                'idTugas' => 3,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-05-01',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/3/file3.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 1,
                'idTugas' => 4,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-05-02',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/4/file4.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 1,
                'idTugas' => 5,
                'statusPengumpulan' => 'terlambat',
                'tanggalPengumpulan' => '2026-05-07',
                'tenggatRevisi' => '2026-05-09',
                'catatanRevisi' => 'Kurang lengkap',
                'progressTugas' => 'done',
                'file_path' => 'tugas/5/file5.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idTugas' => 6,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-04-09',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/6/file6.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idTugas' => 7,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-05-11',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/7/file7.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idTugas' => 8,
                'statusPengumpulan' => 'terlambat',
                'tanggalPengumpulan' => '2026-05-15',
                'tenggatRevisi' => '2026-05-17',
                'catatanRevisi' => 'Kurang detail',
                'progressTugas' => 'done',
                'file_path' => 'tugas/8/file8.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idTugas' => 9,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-05-15',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/9/file9.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idMahasiswa' => 7,
                'idTugas' => 10,
                'statusPengumpulan' => 'tepatwaktu',
                'tanggalPengumpulan' => '2026-05-18',
                'tenggatRevisi' => null,
                'catatanRevisi' => null,
                'progressTugas' => 'done',
                'file_path' => 'tugas/10/file10.pdf',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
