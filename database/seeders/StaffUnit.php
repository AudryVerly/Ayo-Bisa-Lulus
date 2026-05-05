<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('staffunit')->insert([
            [
                'idUser' => 2, // Rina - AdminUnit
                'idUnit' => 1, // PPKP
                'jabatan' => 'Admin Unit',
                'status' => 1,
            ],
            [
                'idUser' => 3, // Dedi
                'idUnit' => 4, // TU Teknik
                'jabatan' => 'Admin Unit',
                'status' => 1,
            ],
            [
                'idUser' => 4, // Novi
                'idUnit' => 2, // UBC
                'jabatan' => 'Admin Unit',
                'status' => 1,
            ],
            [
                'idUser' => 5, // Bayu
                'idUnit' => 5, // DPK
                'jabatan' => 'Admin Unit',
                'status' => 1,
            ],
            [
                'idUser' => 6, // Siska
                'idUnit' => 3, // PPKMI
                'jabatan' => 'Admin Unit',
                'status' => 1,
            ],
            [
                'idUser' => 7, // Yusuf
                'idUnit' => 1,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 8, // Nabila
                'idUnit' => 1,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 9, // Aldi
                'idUnit' => 2,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 10, // Maya
                'idUnit' => 2,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 11, // Rizky
                'idUnit' => 3,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 12, // Tiara
                'idUnit' => 3,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 13, // Farhan
                'idUnit' => 4,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 14, // Lina
                'idUnit' => 4,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 15, // Andika
                'idUnit' => 5,
                'jabatan' => 'Staff',
                'status' => 1,
            ],
            [
                'idUser' => 16, // Wulan
                'idUnit' => 5,
                'jabatan' => 'Staff',
                'status' => 1,
            ],

        ]);
    }
}
