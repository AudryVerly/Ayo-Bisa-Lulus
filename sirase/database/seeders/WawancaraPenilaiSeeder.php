<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WawancaraPenilaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('wawancara_penilai')->insert([
            [
                'idJadwalWawancara' => 1,
                'idStaffUnit' => 7,
                'status' => 'sudah',
                'token' => '8s2oWFtfQeN255S6xEziSAROZLyfT8xyYtPw5AIg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idJadwalWawancara' => 1,
                'idStaffUnit' => 8,
                'status' => 'sudah',
                'token' => 'dVa7PtwbZJfn5saV38oGBdaBPSkinWk0l2Nx34BO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idJadwalWawancara' => 2,
                'idStaffUnit' => 9,
                'status' => 'sudah',
                'token' => 'Ox4bmdKGx44RSB5HejrXWCAmicrdF5Xl9oQTqi6d',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'idJadwalWawancara' => 2,
                'idStaffUnit' => 10,
                'status' => 'sudah',
                'token' => 'EaZ7don1omZ0ByrkjcHtBQwN2Pv7uti7zXBKuWxj',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
