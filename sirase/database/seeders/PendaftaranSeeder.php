<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pendaftaran')->insert([
            [
                'idMahasiswa' => 1,
                'idLowongan' => 6,
                'tanggal_daftar' => Carbon::now()->subDays(rand(5, 25)),
                'statusPendaftaran' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idMahasiswa' => 7,
                'idLowongan' => 7,
                'tanggal_daftar' => Carbon::now()->subDays(rand(3, 20)),
                'statusPendaftaran' => 'diterima',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'idMahasiswa' => 2,
                'idLowongan' => 1,
                'tanggal_daftar' => Carbon::now()->subDays(rand(10, 30)),
                'statusPendaftaran' => 'terdaftar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idMahasiswa' => 3,
                'idLowongan' => 3,
                'tanggal_daftar' => Carbon::now()->subDays(rand(2, 15)),
                'statusPendaftaran' => 'terdaftar',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ================= DIPROSES =================
            [
                'idMahasiswa' => 4,
                'idLowongan' => 2,
                'tanggal_daftar' => Carbon::now()->subDays(rand(1, 10)),
                'statusPendaftaran' => 'diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idMahasiswa' => 5,
                'idLowongan' => 3,
                'tanggal_daftar' => Carbon::now()->subDays(rand(1, 12)),
                'statusPendaftaran' => 'diproses',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // ================= TERDAFTAR =================
            [
                'idMahasiswa' => 6,
                'idLowongan' => 1,
                'tanggal_daftar' => Carbon::now()->subDays(rand(0, 7)),
                'statusPendaftaran' => 'terdaftar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idMahasiswa' => 8,
                'idLowongan' => 2,
                'tanggal_daftar' => Carbon::now()->subDays(rand(0, 5)),
                'statusPendaftaran' => 'terdaftar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
