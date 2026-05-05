<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idMahasiswa = Auth::user()->mahasiswa->id;
        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'j.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.idMahasiswa', $idMahasiswa)
            ->where('j.status', 'terjadwal')
            ->whereDate('j.tanggal_wawancara', '>=', now())
            ->select(
                'j.tanggal_wawancara as tanggal',
                'j.waktu_mulai as mulai',
                'j.waktu_selesai as selesai',
                'l.judulLowongan as judulLowongan'
            )
            ->orderBy('j.tanggal_wawancara')
            ->first();
        // $lowongan = Lowongan::where('status', 1)->get();
        $lowongan = DB::table('lowongan as l')
            ->join('unit as u', 'l.idUnit', '=', 'u.id')
            ->where('l.status', 1)
            ->select('l.*', 'u.name as unitName')
            ->get();
        $units = DB::table('unit')
            ->orderBy('name')
            ->where('status', 1)
            ->get();
        $tugasAktif = DB::table('tugas_mahasiswa as tm')
            ->join('tugas as t', 't.id', '=', 'tm.idTugas')
            ->where('tm.idMahasiswa', $idMahasiswa)
            ->whereIn('tm.progressTugas', ['assigned', 'inProgress', 'revisi'])
            ->orderBy('t.tenggatPengumpulan')
            ->select(
                't.namaTugas',
                't.tenggatPengumpulan',
                'tm.progressTugas'
            )
            ->get();

        return view('mahasiswaPage.dashboard', compact('lowongan', 'units', 'jadwal','tugasAktif'));
    }

    public function detailLowongan(string $id)
    {
        $detailLowongan = DB::table('lowongan as l')
            ->join('unit as u', 'l.idUnit', '=', 'u.id')
            ->where('l.id', $id)
            ->select('l.*', 'u.name as unitName')
            ->first();

        return response()->json([
            'judulLowongan' => $detailLowongan->judulLowongan,
            'posisiLowongan' => $detailLowongan->posisiLowongan,
            'unitName' => $detailLowongan->unitName,
            'durasiKerja' => $detailLowongan->durasiKerja,
            'deskripsi' => $detailLowongan->deskripsi,
            'kualifikasi' => $detailLowongan->kualifikasi,
            'batasPendaftaran' => $detailLowongan->batasPendaftaran
                ? Carbon::parse($detailLowongan->batasPendaftaran)->translatedFormat('d F Y')
                : '-',

            'mulaiKerja' => $detailLowongan->mulaiKerja
                ? Carbon::parse($detailLowongan->mulaiKerja)->translatedFormat('d F Y')
                : '-',

            'akhirKerja' => $detailLowongan->akhirKerja
                ? Carbon::parse($detailLowongan->akhirKerja)->translatedFormat('d F Y')
                : '-',
            'poster' => $detailLowongan->poster,
        ]);
    }
}
