<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\PengumumanKandidat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengumumanController extends Controller
{
    public function showLowongan(){
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit', $idUnit)
                    //ini biar gak ke publish duluan
                    ->where('status',0)
                    ->get();
        return view('pengumuman.listlowongan',compact('lowongan'));
    }

    public function showPengumuman($idLowongan){
        $pengumuman = DB::table('pengumuman as pg')
                      ->join('pendaftaran as p','p.id','=','pg.idPendaftaran')
                      ->join('lowongan as l','p.idLowongan','=','l.id')
                      ->join('mahasiswa as m','p.idMahasiswa','=','m.id')
                      ->join('users as u','m.idUser','=','u.id')
                      ->where('l.id',$idLowongan)
                      ->select(
                        'l.id as idLowongan',
                        'l.judulLowongan',
                        'u.name as namaKandidat',
                        'pg.status',
                        'pg.nomor_surat',
                        'pg.file_path',
                        'pg.is_publish'
                      )
                    ->get();
        return view('pengumuman.listpengumuman',compact('pengumuman'));
    }
    public function storePengumumanLolos(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
            'nomorSurat' => 'required|string',
            'surat' => 'nullable|file|mimes:pdf|max:20480',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'string' => 'Bagian :attribute harus berupa teks.',
            'surat.mimes' => 'Surat harus berformat PDF',
            'surat.max' => 'Ukuran surat maksimal 20 MB',
        ], [
            'idPendaftaran' => 'id pendaftaran',
            'nomorSurat' => 'nomor surat',
            'surat' => 'surat',
        ]);

        $pendaftaran = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.id', $request->idPendaftaran)
            ->select('l.judulLowongan')
            ->first();
        
        $namaLowongan = strtolower($pendaftaran->judulLowongan);
        $namaLowongan = preg_replace('/[^a-z0-9]+/', '_', $namaLowongan);
        $namaLowongan = trim($namaLowongan, '_');

        $pengumuman = PengumumanKandidat::updateOrCreate([
            'idPendaftaran' => $request->idPendaftaran,
        ],
        [
            'nomor_surat' => $request->nomorSurat,
            'status' => 'Terima',
            'file_path' => null,
            'tanggal_publish' => null,
            'is_publish' => 0,
        ]
        );

        if ($request->hasFile('surat')) {
            $file = $request->file('surat');
            $extension = $file->getClientOriginalExtension();
            $namaFile = 'pengumuman_'.$namaLowongan.'_'.$request->idPendaftaran.'_'.'.'.$extension;

            $suratPath = $file->storeAs('pengumuman/'.$request->idPendaftaran, $namaFile, 'public');

            $pengumuman->update(['file_path' => $suratPath]);
        }

        return back()->with('success', 'Pengumuman berhasil disimpan dan menunggu waktu publish');
    }

    public function storeTolak(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
        ]);

        PengumumanKandidat::updateOrCreate([
            'idPendaftaran' => $request->idPendaftaran,
        ],[
            'nomor_surat' => null,
            'status' => 'Tolak',
            'file_path' => null,
            'tanggal_publish' => null,
            'is_publish' => 0,
        ]);
        return back()->with('success', 'Kandidat berhasil ditolak menunggu dipublish');
    }
}