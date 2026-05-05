<?php

namespace App\Http\Controllers;

use App\Models\BerkasPendaftaran;
use App\Models\formulir;
use App\Models\JawabanFormulir;
use App\Models\Lowongan;
use App\Models\Pendaftaran;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PendaftaranController extends Controller
{
    public function formulirPendaftaran(string $idLowongan)
    {
        $idMahasiswa = auth()->user()->mahasiswa->id;

        $lowongan = DB::table('lowongan')
            ->where('id', $idLowongan)
            ->where('status', 1)
            ->first();
        if (! $lowongan) {
            abort(404, 'Lowongan tidak ditemukan atau tidak aktif');
        }

        $sudahDaftar = Pendaftaran::where('idMahasiswa', $idMahasiswa)
            ->where('idLowongan', $idLowongan)
            ->exists();
        if ($sudahDaftar) {
            return redirect()
                ->route('mahasiswa.dashboard')
                ->with('error', 'Kamu sudah mendaftar di lowongan ini.');
        }

        $existingAccepted = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.idMahasiswa', $idMahasiswa)
            ->where('p.statusPendaftaran', 'diterima')
            ->whereDate('l.akhirKerja', '>=', Carbon::today())
            ->exists();

        if ($existingAccepted) {
            return redirect()
                ->route('mahasiswa.dashboard')
                ->with('error', 'Anda masih terdaftar di lowongan lain.');
        }

        $fieldFormulir = DB::table('konten_formulir')
            ->where('idLowongan', $idLowongan)
            ->where('status', 1)
            ->orderBy('id')
            ->get();
        if ($fieldFormulir->count() === 0) {
            abort(404, 'Formulir belum tersedia');
        }

        return view('pendaftaran.formulir', compact('lowongan', 'fieldFormulir', 'sudahDaftar'));

    }

    public function inputPendaftaran(Request $request, string $idLowongan)
    {
        // kita pakai dbtransaction karena ada lebih dari 1 proses yang akan dilakukan
        // try{
        $idMahasiswa = auth()->user()->mahasiswa->id;

        $sudahDaftar = Pendaftaran::where('idMahasiswa', $idMahasiswa)
            ->where('idLowongan', $idLowongan)
            ->exists();
        if ($sudahDaftar) {
            return back()->with('error', 'Kamu sudah pernah mendaftar di lowongan ini.');
        }

        $existingAccepted = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->where('p.idMahasiswa', $idMahasiswa)
            ->where('p.statusPendaftaran', 'diterima')
            ->whereDate('l.akhirKerja', '>=', Carbon::today())
            ->exists();

        if ($existingAccepted) {
            return redirect()
                ->route('mahasiswa.dashboard')
                ->with('error', 'Anda masih terdaftar di lowongan lain.');
        }

        DB::transaction(function () use ($request, $idLowongan, $idMahasiswa) {
            // field formulir akan diambil semua, sesuai lowongan itu
            $fields = formulir::where('idLowongan', $idLowongan)->get();

            // cek required untuk semua field
            // di buat array karena banyak list
            $rules = [];
            $attributes = [];
            foreach ($fields as $field) {
                // ini pakai field. karena dia akan ubah dari [] -> .
                $inputFormulir = 'field.'.$field->id;
                // ditambah
                $attributes[$inputFormulir] = $field->namaField;

                if ($field->tipeField === 'file') {
                    // ini supaya tipe filenya bisa pdf,jpg,jpeg atau png dengan maksimal 20 MB
                    $rules[$inputFormulir] = ($field->required ? 'required|' : '').'file|mimes:pdf,jpg,jpeg|max:20480';
                } else {
                    $rules[$inputFormulir] = $field->required ? 'required' : 'nullable';
                }
            }

            // validasi semua input
            $request->validate($rules, [
                'required' => 'Bagian :attribute wajib diisi.',
                'file.max' => 'Ukuran file maksimal 20 MB.',
                'file.mimes' => 'File harus pdf, jpg, atau jpeg.',
            ], $attributes);

            // lalu input ke pendaftaran
            $pendaftaran = Pendaftaran::create([
                'idMahasiswa' => $idMahasiswa,
                'idLowongan' => $idLowongan,
                'tanggal_daftar' => now(),
                'statusPendaftaran' => 'terdaftar',
            ]);

            // karena isi field banyak akan di looping
            foreach ($fields as $field) {
                $idField = $field->id;
                $inputFormulir = "field.$idField";

                // ini khusus kalau tipe fieldnya == file
                if ($field->tipeField === 'file') {
                    if ($request->hasFile($inputFormulir)) {
                        $file = $request->file($inputFormulir);

                        // ini unntuk simpan filenya
                        $extension = $file->getClientOriginalExtension();
                        $namaField = str_replace(' ', '_', $field->namaField);
                        $namaPendaftar = str_replace(' ', '_', auth()->user()->name);

                        $namaFileBaru = $namaField.'_'.$namaPendaftar.'.'.$extension;

                        // simpan file ke storage/app/public/berkas_pendaftaran/{id}
                        $path = $file->storeAs(
                            'berkas_pendaftaran/'.$pendaftaran->id, $namaFileBaru, 'public'
                        );

                        BerkasPendaftaran::create([
                            'idPendaftaran' => $pendaftaran->id,
                            'idKontenFormulir' => $idField,
                            // ini
                            // 'namaFile' => $file->getClientOriginalName(),
                            'namaFile' => $namaFileBaru,
                            'filePath' => $path,
                        ]);
                    }
                } else {
                    $jawaban = $request->input($inputFormulir);

                    if (is_array($jawaban)) {
                        // ini buat kalau misalnya dia adalah checkbox jadinya kana disimpan
                        // dalam bentuk koma
                        $jawaban = implode(',', $jawaban);
                    }

                    if ($jawaban === null || $jawaban === '') {
                        continue;
                    }

                    JawabanFormulir::create([
                        'idPendaftaran' => $pendaftaran->id,
                        'idKontenFormulir' => $idField,
                        'jawaban' => $jawaban,
                    ]);
                }
            }
        });

        return redirect()->route('mahasiswa.dashboard')->with('successMendaftar', 'Pendaftaran berhasil dikirim!');
    }

    // ini buat show riwayat lowongan masing-masing mahasiswa
    public function showRiwayatPendaftaran()
    {
        $idMahasiswa = auth()->user()->mahasiswa->id;

        $riwayatPendaftaran = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('unit as u', 'l.idUnit', '=', 'u.id')
            ->leftJoin('pengumuman as pg', 'pg.idPendaftaran', '=', 'p.id')
            ->where('idMahasiswa', $idMahasiswa)
            ->select('p.*',
                'l.judulLowongan as judul',
                'l.posisiLowongan as posisi',
                'l.mulaiKerja as mulai',
                'l.akhirKerja as akhir',
                'u.name as unitname',
                'pg.file_path')
            ->get();

        return view('pendaftaran.riwayatpendaftaran', compact('riwayatPendaftaran'));
    }

    // ini buat show detail pendaftaran dari sisi mahasiswa
    public function showDetailPendaftaran(string $idPendaftaran)
    {
        $idMahasiswa = auth()->user()->mahasiswa->id;

        // ambil detail pendaftaran dan detail pendukung lainnya
        $pendaftaran = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('unit as u', 'l.idUnit', '=', 'u.id')
            ->where('p.id', $idPendaftaran)
            ->where('p.idMahasiswa', $idMahasiswa)
            ->select('p.*',
                'l.judulLowongan',
                'l.posisiLowongan',
                'l.mulaiKerja as mulai',
                'l.akhirKerja as akhir',
                'l.durasiKerja as durasi',
                'u.name as namaUnit'
            )
            ->first();
        if (! $pendaftaran) {
            abort(404, 'Data pendaftaran tidak ditemukan');
        }

        // ini ambil list tahapan dari lowongan yang di daftar mahasiswan ini
        $tahapan = DB::table('tahap_rekrutmen')
            ->where('idLowongan', $pendaftaran->idLowongan)
            ->where('status', 1)
            ->orderBy('urutan', 'asc')
            ->get();

        $progress = DB::table('progress_tahapan_kandidat')
            ->where('idPendaftaran', $idPendaftaran)
            ->get()
            ->keyBy('idTahapRekrutmen');

        // kita pakai ini karena kan di progress kandidat  itu perline
        $tahapIni = null;
        $tahapanBerprogress = false;

        foreach ($tahapan as $tahap) {
            // jadi ini kita bakal tempelin tahapan yabng ada di lowongan ini dengan progress
            // yang udah dilakukan sama semua
            if (isset($progress[$tahap->id])) {
                $tahap->status = $progress[$tahap->id]->status;
                $tahap->catatan = $progress[$tahap->id]->catatan;
            } else {
                $tahap->status = 'Menunggu';
            }

            if (isset($progress[$tahap->id])) {
                $tahapanBerprogress = true;
            }

            if ($tahap->status === 'Proses') {
                $tahapIni = $tahap->name;
                break;
            } elseif ($tahap->status === 'Lulus' || $tahap->status === 'Gagal') {
                $tahapIni = $tahap->name;
            }
        }

        //ini buat kandidat yang ketolak dari awal, karena memang udah keterima dilowongan lain
        //atau yang belum sama sekali masuk lowongan
        if (! $tahapanBerprogress) {
            if ($pendaftaran->statusPendaftaran == 'ditolak') {
                $tahapIni = 'Tidak Lolos / Sudah Diterima di Lowongan Lain';
            } else {
                $tahapIni = null;
            }
        }

        return view('pendaftaran.detailPendaftaran', compact('pendaftaran', 'tahapan', 'tahapIni'));
    }
}
