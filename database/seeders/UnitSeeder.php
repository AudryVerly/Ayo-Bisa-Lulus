<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('unit')->insert([
             [
                'name' => 'PPKP',
                'deskripsi' => 'Pusat Pengembangan Karir dan Pelatihan yang bertanggung jawab dalam pembinaan karir mahasiswa serta penyelenggaraan pelatihan kerja.',
                'lokasi' => 'Gedung BA 1.1',
                'kontak' => '081111111111',
                'emailUnit' => 'ppkp@ubaya.ac.id',
                'status' => 1,
            ],
            [
                'name' => 'UBC',
                'deskripsi' => 'Ubaya Business Center yang berfokus pada pengembangan kewirausahaan, bisnis, dan inkubasi usaha bagi mahasiswa dan alumni.',
                'lokasi' => 'Gedung Bisnis Center Lt.1',
                'kontak' => '082222222222',
                'emailUnit' => 'ubc@ubaya.ac.id',
                'status' => 1,
            ],
            [
                'name' => 'PPKMI',
                'deskripsi' => 'Departemen Pengembangan Karakter Kebangsaan, Multikultur, dan Interprofesional merupakan salah satu unit strategis di Universitas Surabaya yang mempunyai peran untuk mempromosikan nilai-nilai multi culture dengan menyelenggarakan matakuliah umum seperti Agama, Pancasila, dan Kewarganegaraan. Dalam penyelenggaraan standard mutu, departemen ini terdaftar sebagai Centre for Humanity and Social Studies.',
                'lokasi' => 'TS 01.91',
                'kontak' => '083333333333',
                'emailUnit' => 'ppkmi@ubaya.ac.id',
                'status' => 1,
            ],
            [
                'name' => 'TU Teknik',
                'deskripsi' => 'Tata Usaha yang bertugas mengelola administrasi, surat menyurat, dan operasional kegiatan akademik maupun non-akademik.',
                'lokasi' => 'TA 01.01',
                'kontak' => '084444444444',
                'emailUnit' => 'teknik@ubaya.ac.id',
                'status' => 1,
            ],
            [
                'name' => 'DPK',
                'deskripsi' => 'DPK unit yang bertigas untuk mengurusi keperluan dari mahasiswa yang berada diubaya.',
                'lokasi' => 'Gedung Perpustakaan Lt. 1',
                'kontak' => '085555555555',
                'emailUnit' => 'ops@company.com',
                'status' => 1,
            ],
        ]);
    }
}
