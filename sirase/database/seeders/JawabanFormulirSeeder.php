<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JawabanFormulirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jawaban_formulir')->insert([
            //pendaftaran 1 -> lowongan 6
            [
                'idPendaftaran' => 1,
                'idKontenFormulir' => 34,
                'jawaban' => 'Ahmad Fauzan'
            ],
            [
                'idPendaftaran' => 1,
                'idKontenFormulir' => 35,
                'jawaban' => '160422127'
            ],
            [
                'idPendaftaran' => 1,
                'idKontenFormulir' => 36,
                'jawaban' => 'Sudah banyak mengikuti event event di kampus'
            ],
            [
                'idPendaftaran' => 1,
                'idKontentFormulir' => 37,
                'jawaban' => 'Ingin mencoba pengalaman baru yang lebih asik'
            ],
            [
                'idPendaftaran' => 1,
                'idKontenFormulir' => 38,
                'jawaban' => 'Organisasi,Leadership'
            ],

            //pendaftaran 2 -> idLowongan 7
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 40,
                'jawaban' => 'Raka Putra'
            ],
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 41,
                'jawaban' => 's180522114@student.ubaya.ac.id'
            ],
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 42,
                'jawaban' => 'Ingin mencoba hal baru yang belum pernah di coba'
            ],
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 43,
                'jawaban' => 'pernah mencoba di start up lokal'
            ],
            [
                'idPendaftaran' => 2,
                'idKontenFormulir' => 44,
                'jawaban' => 'Marketing, IT, Research'
            ],

            //Pendaftaran 3 -> lowongan 1
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 1,
                'jawaban' => 'Siti Rahma',
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 2,
                'jawaban' => '13023115',
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 3,
                'jawaban' => 's13023115@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 4,
                'jawaban' => 'Bisnis & Ekonomika',
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 5,
                'jawaban' => 'Perempuan',
            ],
            [
                'idPendaftaran' => 3,
                'idKontenFormulir' => 6,
                'jawaban' => 'Ingin Mencoba Hal baru',
            ],

            //pendaftaran 4 -> Lowongan 3
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 16,
                'jawaban' => 'Bima Prakoso',
            ],
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 17,
                'jawaban' => 's15023167@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 18,
                'jawaban' => '3.5',
            ],
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 19,
                'jawaban' => 'Tinggi',
            ],
            [
                'idPendaftaran' => 4,
                'idKontenFormulir' => 20,
                'jawaban' => 'Pernah mengikuti beberapa panit di kampus',
            ],

            //pendafataran 5 -> lowongan 2
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 9,
                'jawaban' => 'Cindy Oktavia',
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 10,
                'jawaban' => 's110422156@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 11,
                'jawaban' => 'Bisnis dalam hal makanan dan minuman',
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 12,
                'jawaban' => 'Marketing, IT',
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 13,
                'jawaban' => '3.60',
            ],
            [
                'idPendaftaran' => 5,
                'idKontenFormulir' => 14,
                'jawaban' => 'Ingin banyak mengetahu hal mengenai bisnis',
            ],

            //pendafatran 6 -> lowongan 3
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 16,
                'jawaban' => 'Yoga Syahputra',
            ],
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 17,
                'jawaban' => 's170322145@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 18,
                'jawaban' => '3.5',
            ],
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 19,
                'jawaban' => 'Tinggi',
            ],
            [
                'idPendaftaran' => 6,
                'idKontenFormulir' => 20,
                'jawaban' => 'Pernah mengikuti beberapa panit di kampus',
            ],

            //pendaftaran 7 -> lowongan 1
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 1,
                'jawaban' => 'Dewi Lestari',
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 2,
                'jawaban' => '140122187',
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 3,
                'jawaban' => 's140122187@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 4,
                'jawaban' => 'Farmasi',
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 5,
                'jawaban' => 'Perempuan',
            ],
            [
                'idPendaftaran' => 7,
                'idKontenFormulir' => 6,
                'jawaban' => 'Ingin Mencoba Hal baru',
            ],

            //pendaftaran 8 -> lowongan 2
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 9,
                'jawaban' => 'Nadya Safira',
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 10,
                'jawaban' => 's110422156@student.ubaya.ac.id',
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 11,
                'jawaban' => 'Bisnis dalam hal makanan dan minuman',
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 12,
                'jawaban' => 'Marketing, IT',
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 13,
                'jawaban' => '3.60',
            ],
            [
                'idPendaftaran' => 8,
                'idKontenFormulir' => 14,
                'jawaban' => 'Ingin banyak mengetahu hal mengenai bisnis',
            ],

        ]);
    }
}
