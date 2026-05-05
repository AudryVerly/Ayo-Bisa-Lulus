<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // superadmin
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'SuperAdmin',
                'status' => 1,
            ],
            [
                'name' => 'Rina Wulandari',
                'email' => 'rina.hr@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Dedi Saputra',
                'email' => 'dedi.it@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Novi Anggraini',
                'email' => 'novi.finance@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Bayu Pratama',
                'email' => 'bayu.marketing@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Siska Maharani',
                'email' => 'siska.operasional@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'AdminUnit',
                'status' => 1,
            ],
            [
                'name' => 'Yusuf Pratama',
                'email' => 'yusuf@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Nabila Sari',
                'email' => 'nabila@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Aldi Ramadhan',
                'email' => 'aldi@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Maya Lestari',
                'email' => 'maya@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Rizky Kurniawan',
                'email' => 'rizky@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Tiara Putri',
                'email' => 'tiara@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Farhan Akbar',
                'email' => 'farhan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Lina Oktavia',
                'email' => 'lina@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Andika Sapto',
                'email' => 'andika@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Wulan Pertiwi',
                'email' => 'wulan@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Rendy Maulana',
                'email' => 'rendy@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Nisa Amelia',
                'email' => 'nisa@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Bintang Aji',
                'email' => 'bintang@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Dian Kartika',
                'email' => 'dian@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Fajar Nugroho',
                'email' => 'fajar@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'StaffUnit',
                'status' => 1,
            ],
            [
                'name' => 'Ahmad Fauzan',
                'email' => 's160422127@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Siti Rahma',
                'email' => 's13023115@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Bima Prakoso',
                'email' => 's15023167@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Cindy Oktavia',
                'email' => 's110422156@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Yoga Saputra',
                'email' => 's170322145@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 's140122187@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Raka Putra',
                'email' => 's180522114@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Nadya Safira',
                'email' => 's120322199@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Ilham Maulana',
                'email' => 's160122121@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
            [
                'name' => 'Putri Ayunda',
                'email' => 's190422135@student.ubaya.ac.id',
                'password' => Hash::make('password'),
                'role' => 'Mahasiswa',
                'status' => 1,
            ],
        ]);
    }
}
