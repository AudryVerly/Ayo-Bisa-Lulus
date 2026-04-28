<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PengumumanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pengumuman')->insert([
            [
                'idPendaftaran' => 1,
                'nomor_surat' => '57/II-2025/ST-TA/FT/III/2026',
                'status' => 'Terima',
                'file_path' => 'pengumuman/1/pengumuman_asisten_event_lama_ppkp_1.pdf',
                'tanggal_publish' => Carbon::parse('2025-02-25'),
                'is_publish' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'idPendaftaran' => 2,
                'nomor_surat' => '0171/FT/IX/2025',
                'status' => 'Terima',
                'file_path' => 'pengumuman/2/pengumuman_asisten_startup_batch_1_2.pdf',
                'tanggal_publish' => Carbon::parse('2026-03-15'),
                'is_publish' => 1,
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
