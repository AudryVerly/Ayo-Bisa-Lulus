<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mahasiswa')->insert([
            [
                'idUser' => 22,
                'nrp' => '160422127',
                'fakultas' => 'Teknik',
                'jurusan' => 'Teknik Informatika',
                'tahunMasuk' => 2022,
                'noTelepon' => '081234567802',
                'status' => 1,
            ],
            [
                'idUser' => 23,
                'nrp' => '13023115',
                'fakultas' => 'Bisnis dan Ekonomika',
                'jurusan' => 'Manajemen',
                'tahunMasuk' => 2023,
                'noTelepon' => '081234567802',
                'status' => 1,
            ],
            [
                'idUser' => 24,
                'nrp' => '15023167',
                'fakultas' => 'Hukum', 
                'jurusan' => 'Ilmu Hukum',
                'tahunMasuk' => 2023,
                'noTelepon' => '081234567803',
                'status' => 1,
            ],
            [
                'idUser' => 25,
                'nrp' => '110422156',
                'fakultas' => 'Farmasi', 
                'jurusan' => 'Farmasi',
                'tahunMasuk' => 2022,
                'noTelepon' => '081234567804',
                'status' => 1,
            ],
            [
                'idUser' => 26,
                'nrp' => '170322145',
                'fakultas' => 'Teknik',
                'jurusan' => 'Teknik Industri',
                'tahunMasuk' => 2023,
                'noTelepon' => '081234567805',
                'status' => 1,
            ],
            [
                'idUser' => 27,
                'nrp' => '140122187',
                'fakultas' => 'Farmasi',
                'jurusan' => 'Farmasi',
                'tahunMasuk' => 2021,
                'noTelepon' => '081234567806',
                'status' => 1,
            ],
            [
                'idUser' => 28,
                'nrp' => '180522114',
                'fakultas' => 'Industri Kreatif', 
                'jurusan' => 'Desain Komunikasi Visual',
                'tahunMasuk' => 2022,
                'noTelepon' => '081234567807',
                'status' => 1,
            ],
            [
                'idUser' => 29,
                'nrp' => '120322199',
                'fakultas' => 'Bisnis dan Ekonomika',
                'jurusan' => 'Akuntansi',
                'tahunMasuk' => 2023,
                'noTelepon' => '081234567808',
                'status' => 1,
            ],
            [
                'idUser' => 30,
                'nrp' => '160122121',
                'fakultas' => 'Teknik',
                'jurusan' => 'Elektro',
                'tahunMasuk' => 2021,
                'noTelepon' => '081234567809',
                'status' => 1,
            ],
            [
                'idUser' => 31,
                'nrp' => '190422135',
                'fakultas' => 'Hukum',
                'jurusan' => 'Ilmu Hukum',
                'tahunMasuk' => 2022,
                'noTelepon' => '081234567810',
                'status' => 1,
            ],
        ]);
    }
}
