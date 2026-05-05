<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LowonganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lowongan')->insert([
            // ================= AKTIF =================
            [
                'idUnit' => 1,
                'judulLowongan' => 'Asisten Pelatihan Karir',
                'deskripsi' => 'Membantu kegiatan pelatihan karir mahasiswa.',
                'kualifikasi' => 'Mahasiswa aktif, komunikatif',
                'posisiLowongan' => 'Asisten Pelatihan',
                'durasiKerja' => 3,
                'awalPendaftaran' => '2026-04-01',
                'batasPendaftaran' => '2026-05-30',
                'mulaiKerja' => '2026-06-01',
                'akhirKerja' => '2026-09-01',
                'kuota_diterima' => 3,
                'status' => 1,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
            [
                'idUnit' => 2,
                'judulLowongan' => 'Asisten Inkubasi Bisnis',
                'deskripsi' => 'Pendampingan startup mahasiswa.',
                'kualifikasi' => 'Minat bisnis, kreatif',
                'posisiLowongan' => 'Asisten Bisnis',
                'durasiKerja' => 4,
                'awalPendaftaran' => '2026-04-01',
                'batasPendaftaran' => '2026-06-01',
                'mulaiKerja' => '2026-06-10',
                'akhirKerja' => '2026-10-10',
                'kuota_diterima' => 2,
                'status' => 1,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
            [
                'idUnit' => 3,
                'judulLowongan' => 'Asisten MKU',
                'deskripsi' => 'Membantu kegiatan mata kuliah umum.',
                'kualifikasi' => 'Disiplin, rapi',
                'posisiLowongan' => 'Asisten MKU',
                'durasiKerja' => 6,
                'awalPendaftaran' => '2026-04-10',
                'batasPendaftaran' => '2026-06-10',
                'mulaiKerja' => '2026-06-15',
                'akhirKerja' => '2026-12-15',
                'kuota_diterima' => 4,
                'status' => 1,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
            [
                'idUnit' => 4,
                'judulLowongan' => 'Staf TU Teknik',
                'deskripsi' => 'Administrasi fakultas teknik.',
                'kualifikasi' => 'Teliti, MS Office',
                'posisiLowongan' => 'Admin TU',
                'durasiKerja' => 5,
                'awalPendaftaran' => '2026-04-05',
                'batasPendaftaran' => '2026-06-05',
                'mulaiKerja' => '2026-06-10',
                'akhirKerja' => '2026-11-10',
                'kuota_diterima' => 2,
                'status' => 1,
                'poster' =>'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
            [
                'idUnit' => 5,
                'judulLowongan' => 'Asisten Layanan Mahasiswa',
                'deskripsi' => 'Pelayanan administrasi mahasiswa.',
                'kualifikasi' => 'Ramah, komunikatif',
                'posisiLowongan' => 'Asisten Layanan',
                'durasiKerja' => 4,
                'awalPendaftaran' => '2026-04-15',
                'batasPendaftaran' => '2026-06-15',
                'mulaiKerja' => '2026-06-20',
                'akhirKerja' => '2026-10-20',
                'kuota_diterima' => 3,
                'status' => 1,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],

            // ================= SUDAH TUTUP =================
            [
                'idUnit' => 1,
                'judulLowongan' => 'Asisten Event Lama PPKP',
                'deskripsi' => 'Kegiatan event pelatihan sebelumnya.',
                'kualifikasi' => 'Pengalaman organisasi',
                'posisiLowongan' => 'Asisten Event',
                'durasiKerja' => 2,
                'awalPendaftaran' => '2025-01-01',
                'batasPendaftaran' => '2025-02-01',
                'mulaiKerja' => '2025-02-10',
                'akhirKerja' => '2025-04-10',
                'kuota_diterima' => 2,
                'status' => 0,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
            [
                'idUnit' => 2,
                'judulLowongan' => 'Asisten Startup Batch 1',
                'deskripsi' => 'Program inkubasi lama UBC.',
                'kualifikasi' => 'Minat startup',
                'posisiLowongan' => 'Asisten Startup',
                'durasiKerja' => 3,
                'awalPendaftaran' => '2025-02-01',
                'batasPendaftaran' => '2025-03-01',
                'mulaiKerja' => '2025-03-10',
                'akhirKerja' => '2025-06-10',
                'kuota_diterima' => 2,
                'status' => 0,
                'poster' => 'poster_lowongan/default.png',
                'is_ready' => 1,
            ],
        ]);
    }
}
