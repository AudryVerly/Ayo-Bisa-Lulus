<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalWawancaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jadwal_wawancara')->insert([
            [
                'idProgressTahapan' => 12,
                'idPendaftaran' => 1,
                'tanggal_wawancara' => '2025-02-04',
                'waktu_mulai' => '15:00:00',
                'waktu_selesai' => '16:00:00',
                'lokasi' => 'BA 06.01',
                'link_wawancara' => '',
                'keterangan' => 'Silahkan datang tepat waktu',
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idProgressTahapan' => 16,
                'idPendaftaran' => 2,
                'tanggal_wawancara' => '2026-03-06',
                'waktu_mulai' => '12:00:00',
                'waktu_selesai' => '13:00:00',
                'lokasi' => 'TS 01.01',
                'link_wawancara' => '',
                'keterangan' => 'Datang tepat waktu',
                'status' => 'selesai',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
