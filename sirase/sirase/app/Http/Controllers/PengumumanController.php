<?php

namespace App\Http\Controllers;

use App\Mail\PengumumanMail;
use App\Models\Lowongan;
use App\Models\PengumumanKandidat;
use App\Models\ProgressTahapanKandidat;
use App\Models\TahapRekrutmen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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
        try {
            DB::transaction(function () use ($request) {

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
                if (! $pendaftaran) {
                    throw new \Exception('Data pendaftaran tidak ditemukan');
                }

                $pendaftaranLain = DB::table('pendaftaran')
                    ->where('idMahasiswa', $pendaftaran->idMahasiswa)
                    ->where('id', '!=', $pendaftaran->id)
                    ->pluck('id');

                PengumumanKandidat::updateOrInsert(
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

                if ($pendaftaranLain->isNotEmpty()) {
                    DB::table('pengumuman')
                        ->whereIn('idPendaftaran', $pendaftaranLain)
                        ->update([
                            'status' => 'Tolak',
                            'is_publish' => 0,
                        ]);

                    DB::table('progress_tahapan_kandidat')
                        ->whereIn('idPendaftaran', $pendaftaranLain)
                        ->update([
                            'status' => 'Gagal',
                            'catatan' => 'Dibatalkan karena sudah diterima di lowongan lain',
                        ]);
                    DB::table('pendaftaran')
                        ->whereIn('id', $pendaftaranLain)
                        ->update([
                            'statusPendaftaran' => 'ditolak',
                        ]);
                }

            });

            return back()->with('success', 'Pengumuman berhasil disimpan dan menunggu waktu publish');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    public function storeTolak(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
        ]);

        PengumumanKandidat::updateOrInsert([
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

    public function publish(Request $request, $idLowongan)
    {
        $request->validate([
            'nomorSurat' => 'required|string',
            'surat' => 'nullable|file|mimes:pdf|max:20480',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'surat.mimes' => 'Surat harus berformat PDF.',
            'surat.max' => 'Besar file surat maksimal 20MB',
        ], [
            'nomorSurat' => 'nomor surat',
            'surat' => 'surat',
        ]);
        try {
            DB::transaction(function () use ($request, $idLowongan) {
                $pengumuman = DB::table('pengumuman as pg')
                    ->join('pendaftaran as p', 'pg.idPendaftaran', '=', 'p.id')
                    ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
                    ->join('users as u', 'm.idUser', '=', 'u.id')
                    ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
                    ->where('p.idLowongan', $idLowongan)
                    ->whereNotNull('pg.status')
                    ->where('pg.is_publish', 0)
                    ->select(
                        'pg.*',
                        'u.email',
                        'u.name as nama',
                        'l.judulLowongan'
                    )
                    ->get();
                if ($pengumuman->isEmpty()) {
                    throw new \Exception('Tidak ada data untuk dipublish');
                }

                $tahapFinal = TahapRekrutmen::where('idLowongan', $idLowongan)
                    ->where('tipe_tahap', 'final')
                    ->first();
                foreach ($pengumuman as $pg) {
                    $filePath = null;

                    // cek tahap sebelum final
                    if ($tahapFinal) {
                        $belumSelesai = DB::table('progress_tahapan_kandidat as pt')
                            ->join('tahap_rekrutmen as tr', 'pt.idTahapRekrutmen', '=', 'tr.id')
                            ->where('pt.idPendaftaran', $pg->idPendaftaran)
                            ->where('tr.idLowongan', $idLowongan)
                            ->where('tr.urutan', '<', $tahapFinal->urutan)
                            ->where('pt.status', 'Proses')
                            ->exists();

                        if ($belumSelesai) {
                            throw new \Exception('Masih ada tahap sebelumnya yang belum selesai');
                        }
                    }

                    if ($pg->status == 'Terima') {
                        if (! $request->nomorSurat || ! $request->hasFile('surat')) {
                            throw new \Exception('File surat wajib untuk kandidat diterima');
                        }

                        $file = $request->file('surat');

                        $namaLowongan = strtolower($pg->judulLowongan);
                        $namaLowongan = preg_replace('/[^a-z0-9]+/', '_', $namaLowongan);

                        $namaFile = 'pengumuman_'.$namaLowongan.'_'.$pg->idPendaftaran.'.'.$file->getClientOriginalExtension();

                        $filePath = $file->storeAs(
                            'pengumuman/'.$pg->idPendaftaran,
                            $namaFile,
                            'public'
                        );
                    }

                    DB::table('pengumuman')
                        ->where('idPendaftaran', $pg->idPendaftaran)
                        ->update([
                            'nomor_surat' => $pg->status == 'Terima' ? $request->nomorSurat : null,
                            'file_path' => $pg->status == 'Terima' ? $filePath : null,
                            'is_publish' => 1,
                            'tanggal_publish' => now(),
                        ]);

                    DB::table('pendaftaran')
                        ->where('id', $pg->idPendaftaran)
                        ->update([
                            'statusPendaftaran' => $pg->status == 'Terima' ? 'diterima' : 'ditolak',
                        ]);

                    if ($tahapFinal) {
                        ProgressTahapanKandidat::updateOrCreate(
                            [
                                'idTahapRekrutmen' => $tahapFinal->id,
                                'idPendaftaran' => $pg->idPendaftaran,
                            ],
                            [
                                'status' => $pg->status == 'Terima' ? 'Lulus' : 'Gagal',
                                'catatan' => 'Hasil akhir rekrutmen',
                            ]
                        );
                    }

                    Mail::to($pg->email)->send(new PengumumanMail(
                        $pg->nama,
                        $pg->status,
                        $pg->judulLowongan,
                    ));
                }
            });

            return back()->with('success', 'Berhasil publish + update tahapan + email');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
