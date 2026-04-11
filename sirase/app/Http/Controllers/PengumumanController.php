<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\PengumumanKandidat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function showLowongan()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = Lowongan::with(['unit'])
            ->where('idUnit', $idUnit)
                    // ini biar gak ke publish duluan
            ->where('status', 0)
            ->get();

        return view('pengumuman.listlowongan', compact('lowongan'));
    }

    public function showPengumuman($idLowongan)
    {
        $pengumuman = DB::table('pengumuman as pg')
            ->join('pendaftaran as p', 'p.id', '=', 'pg.idPendaftaran')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->where('l.id', $idLowongan)
            ->select(
                'pg.idPendaftaran',
                'l.id as idLowongan',
                'l.judulLowongan',
                'p.id as idPendaftaran',
                'u.name as namaKandidat',
                'pg.status',
                'pg.nomor_surat',
                'pg.tanggal_publish',
                'pg.file_path',
                'pg.is_publish'
            )
            ->get();
        $judulLowongan = DB::table('lowongan')
            ->where('id', $idLowongan)
            ->value('judulLowongan');

        return view('pengumuman.listpengumuman', compact('pengumuman', 'judulLowongan'));
    }

    public function storePengumumanLolos(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
        ], [
            'idPendaftaran' => 'id pendaftaran',
        ]);

        $pendaftaran = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.id', $request->idPendaftaran)
            ->select(
                'p.id',
                'p.idMahasiswa',
                'l.judulLowongan',
                'l.mulaiKerja',
                'l.akhirKerja'
            )
            ->first();

        $sudahDiterima = DB::table('pengumuman as pg')
            ->join('pendaftaran as p', 'pg.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.idMahasiswa', $pendaftaran->idMahasiswa)
            ->where('pg.status', 'Terima')
            ->whereDate('l.akhirKerja', '>=', now())
            ->exists();
        if ($sudahDiterima) {
            return response()->json([
                'status' => false,
                'message' => 'Wawancara maksimal H-3 sebelum mulai kerja',
            ], 422);
        }

        // $namaLowongan = strtolower($pendaftaran->judulLowongan);
        // $namaLowongan = preg_replace('/[^a-z0-9]+/', '_', $namaLowongan);
        // $namaLowongan = trim($namaLowongan, '_');

        PengumumanKandidat::updateOrCreate(
        [
            'idPendaftaran' => $request->idPendaftaran,
        ],
        [
            'nomor_surat' => null,
            'status' => 'Terima',
            'file_path' => null,
            'tanggal_publish' => null,
            'is_publish' => 0,
        ]
        );

        // if ($request->hasFile('surat')) {
        //     $file = $request->file('surat');
        //     $extension = $file->getClientOriginalExtension();
        //     $namaFile = 'pengumuman_'.$namaLowongan.'_'.$request->idPendaftaran.'_'.'.'.$extension;

        //     $suratPath = $file->storeAs('pengumuman/'.$request->idPendaftaran, $namaFile, 'public');

        //     $pengumuman->update(['file_path' => $suratPath]);
        // }

        return back()->with('success', 'Pengumuman berhasil disimpan dan menunggu waktu publish');
    }

    public function storeTolak(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
        ]);

        PengumumanKandidat::updateOrCreate([
            'idPendaftaran' => $request->idPendaftaran,
        ], 
        [
            'nomor_surat' => null,
            'status' => 'Tolak',
            'file_path' => null,
            'tanggal_publish' => null,
            'is_publish' => 0,
        ]);

        return back()->with('success', 'Kandidat berhasil ditolak menunggu dipublish');
    }
}
