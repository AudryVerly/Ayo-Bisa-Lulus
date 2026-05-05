<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenilaianKandidatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('penilaian_kandidat')->insert([
            [
                'id' => 2,
                'idPendaftaran' => 1,
                'idWawancaraPenilai' => 1,
                'nilaiFinal' => 0.94790040876997,
                'catatan' => 'Sangat aman untuk diterima menjadi kandidat',
                'tanggal_menilai' => '2026-04-28',
            ],
            [
                'id' => 3,
                'idPendaftaran' => 1,
                'idWawancaraPenilai' => 2,
                'nilaiFinal' => 0.92666914406045,
                'catatan' => 'Cocok untuk menjadi student employee',
                'tanggal_menilai' => '2026-04-28',
            ],
            [
                'id' => 4,
                'idPendaftaran' => 2,
                'idWawancaraPenilai' => 4,
                'nilaiFinal' => 0.95647180691654,
                'catatan' => 'Cocok untuk menjadi kandidat',
                'tanggal_menilai' => '2026-04-28',
            ],
            [
                'id' => 5,
                'idPendaftaran' => 2,
                'idWawancaraPenilai' => 3,
                'nilaiFinal' => 0.91322370858664,
                'catatan' => 'Bisa diterima menjadi kandidat ini',
                'tanggal_menilai' => '2026-04-28',
            ],
        ]);
    }
}
