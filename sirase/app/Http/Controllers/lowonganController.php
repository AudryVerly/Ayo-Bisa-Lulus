<?php

namespace App\Http\Controllers;

use App\Models\formulir;
use App\Models\Lowongan;
use App\Models\TahapRekrutmen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ini untuk mencari idUnit dari user yang login
        // ini pakai pluck soalnya relasinya one to many
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowonganbuka = Lowongan::where('idUnit', $idUnit)->get();

        // with itu adalah relasi atau join
        $lowongan = Lowongan::with(['unit'])
            ->where('idUnit', $idUnit)
            ->orderBy('status', 'desc')
            ->get();

        return view('lowongan.utama', compact('lowongan'));
    }

    public function autoUpdate()
    {
        $lowongans = Lowongan::all();
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        foreach ($lowongans as $lowongan) {
            $adaFormulir = formulir::where('idLowongan', $lowongan->id)->exists();
            $adaTahapan = TahapRekrutmen::where('idLowongan', $lowongan->id)->exists();

            $isReady = ($adaFormulir && $adaTahapan) ? 1 : 0;

            if ($lowongan->is_ready != $isReady) {
                $lowongan->update(['is_ready' => $isReady]);
            }

            if (! $isReady) {
                if ($lowongan->status == 1) {
                    $lowongan->update(['status' => 0]);
                }

                continue;
            }

            $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
            $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

            if ($today >= $awalPendaftaran && $today <= $batasPendaftaran) {
                if ($lowongan->status == 0) {
                    $lowongan->update(['status' => 1]);
                }
            } elseif ($today > $batasPendaftaran || $awalPendaftaran > $today) {
                if ($lowongan->status == 1) {
                    $lowongan->update(['status' => 0]);
                }
            }
        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lowongan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $request->validate([
            'judulLowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'posisiLowongan' => 'required|string|max:255',
            'durasiKerja' => 'required|numeric|min:1',
            'awalPendaftaran' => 'required|date',
            'batasPendaftaran' => 'required|date|after_or_equal:awalPendaftaran',
            // ini karena supaya semua proses administrasi bisa berjalan lancar
            'mulaiKerja' => 'required|date|after_or_equal:'.Carbon::parse($request->batasPendaftaran)->addDays(14)->format('Y-m-d'),
            // pastinya gak mungkin kerja cuman 1 hari 2 hari kan
            'akhirKerja' => 'required|date|after_or_equal: '.Carbon::parse($request->mulaiKerja)->addMonth()->format('Y-m-d'),
            'kuota_diterima' => 'required|integer|min:1',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png|max:20480',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'string' => 'Bagian :attribute harus berupa teks.',
            'numeric' => 'Bagian :attribute harus berupa angka.',
            'date' => 'Bagian :attribute harus berupa tanggal yang valid.',
            'min' => 'Bagian :attribute minimal bernilai :min bulan.',
            'max' => 'Bagian :attribute maksimal :max karakter.',
            'kuota_diterima.min' => 'Bagian kuota_diterima min 1 orang',
            'after_or_equal' => 'Tanggal :attribute tidak sesuai dengan ketentuan periode lowongan.',
            'mulaiKerja.after_or_equal' => 'Tanggal mulai kerja setidaknya harus 14 hari setelah batas pendaftaran',
            'akhirkerja.after_or_equal' => 'Tanggal akhir kerja setidaknya harus 1 bulan setelah mulai bekerja',
            'poster.mimes' => 'Poster harus berformat JPG, JPEG, atau PNG.',
            'poster.max' => 'Ukuran poster maksimal 20MB.',
        ], [
            'judulLowongan' => 'judul lowongan',
            'deskripsi' => 'deskripsi lowongan',
            'kualifikasi' => 'kualifikasi',
            'posisiLowongan' => 'posisi lowongan',
            'durasiKerja' => 'durasi kerja',
            'awalPendaftaran' => 'tanggal awal pendaftaran',
            'batasPendaftaran' => 'tanggal batas pendaftaran',
            'mulaiKerja' => 'tanggal mulai kerja',
            'akhirKerja' => 'tanggal akhir kerja',
            'poster' => 'poster lowongan',
            'kuota_diterima' => 'kuota diterima',
        ]);

        $request['kualifikasi'] = trim(preg_replace('/\r\n|\r|\n/', "\n", $request['kualifikasi']));

        $lowongan = Lowongan::create([
            'idUnit' => $idUnit,
            'judulLowongan' => $request->judulLowongan,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'posisiLowongan' => $request->posisiLowongan,
            'durasiKerja' => $request->durasiKerja,
            'awalPendaftaran' => $request->awalPendaftaran,
            'batasPendaftaran' => $request->batasPendaftaran,
            'mulaiKerja' => $request->mulaiKerja,
            'akhirKerja' => $request->akhirKerja,
            'kuota_diterima' => $request->kuota_diterima,
            'poster' => ' ',
            'status' => 0,
            'is_ready' => 0,
        ]);

        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $namaLowongan = str_replace(' ', '_', $request->judulLowongan);
            $extension = $file->getClientOriginalExtension();
            $namaFile = $namaLowongan.'_'.time().'.'.$extension;

            $posterPath = $file->storeAs('poster_lowongan/'.$lowongan->id, $namaFile, 'public');

            $lowongan->update(['poster' => $posterPath]);
        }
        return redirect()->route('formulir.manage', $lowongan->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $today = Carbon::today();
        $batas = Carbon::parse($lowongan->batasPendaftaran);

        if ($today > $batas) {
            return redirect()->route('lowongans.index')
                ->with('error', 'Lowongan sudah ditutup, tidak bisa diedit');
        }

        return view('lowongan.edit', compact('lowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $today = Carbon::today();
        $batas = Carbon::parse($lowongan->batasPendaftaran);

        if ($today > $batas) {
            return redirect()->route('lowongans.index')
                ->with('error', 'Lowongan sudah ditutup, tidak bisa diedit');
        }

        $request->validate([
            'judulLowongan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kualifikasi' => 'required|string',
            'posisiLowongan' => 'required|string|max:255',
            'durasiKerja' => 'required|numeric|min:1',
            'awalPendaftaran' => 'required|date',
            'batasPendaftaran' => 'required|date|after_or_equal:awalPendaftaran',
            // ini karena supaya semua proses administrasi bisa berjalan lancar
            'mulaiKerja' => 'required|date|after_or_equal:'.Carbon::parse($request->batasPendaftaran)->addDays(14)->format('Y-m-d'),
            // pastinya gak mungkin kerja cuman 1 hari 2 hari kan
            'akhirKerja' => 'required|date|after_or_equal: '.Carbon::parse($request->mulaiKerja)->addMonth()->format('Y-m-d'),
            'kuota_diterima' => 'required|integer|min:1',
            'poster' => 'nullable|file|mimes:jpg,jpeg,png|max:20480',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'string' => 'Bagian :attribute harus berupa teks.',
            'numeric' => 'Bagian :attribute harus berupa angka.',
            'date' => 'Bagian :attribute harus berupa tanggal yang valid.',
            'min' => 'Bagian :attribute minimal bernilai :min.',
            'max' => 'Bagian :attribute maksimal :max karakter.',
            'kuota_diterima.min' => 'Bagian kuota_diterima min 1 orang',
            'after_or_equal' => 'Tanggal :attribute tidak sesuai dengan ketentuan periode lowongan.',
            'mulaiKerja.after_or_equal' => 'Tanggal mulai kerja setidaknya harus 14 hari setelah batas pendaftaran',
            'mulaiKerja.after_or_equal' => 'Tanggal akhir kerja setidaknya harus 1 bulan setelah mulai bekerja',
            'poster.mimes' => 'Poster harus berformat JPG, JPEG, atau PNG.',
            'poster.max' => 'Ukuran poster maksimal 20MB.',
        ], [
            'judulLowongan' => 'judul lowongan',
            'deskripsi' => 'deskripsi lowongan',
            'kualifikasi' => 'kualifikasi',
            'posisiLowongan' => 'posisi lowongan',
            'durasiKerja' => 'durasi kerja',
            'awalPendaftaran' => 'tanggal awal pendaftaran',
            'batasPendaftaran' => 'tanggal batas pendaftaran',
            'mulaiKerja' => 'tanggal mulai kerja',
            'akhirKerja' => 'tanggal akhir kerja',
            'poster' => 'poster lowongan',
            'kuota_diterima' => 'kuota diterima',
        ]);

        // ini supaya dia bisa memsiahkan spasi, whitespace dan koma
        $request['kualifikasi'] = trim(preg_replace('/\r\n|\r|\n/', "\n", $request['kualifikasi']));

        // $mulai = Carbon::parse($request->mulaiKerja);
        // $akhir = Carbon::parse($request->akhirKerja);

        // $bulan = ($akhir->year - $mulai->year) * 12 + ($akhir->month - $mulai->month);

        // // hitung sisa hari
        // $hari = $akhir->day - $mulai->day;

        // // jika sisa hari negatif, kurangi 1 bulan dan hitung ulang sisa hari
        // if ($hari < 0) {
        //     $bulan -= 1;
        //     // jumlah hari di bulan akhir setelah dikurangi bulan
        //     $hari = $akhir->copy()->subMonths(1)->daysInMonth + $akhir->day - $mulai->day;
        // }

        // // durasi akhir sama seperti JS
        // $durasiKerja = round($bulan + ($hari / 30), 1);

        // ini path poster lama
        $posterPath = $lowongan->poster;

        // ini kalau mau tambah poster baru
        if ($request->hasFile('poster')) {
            if ($lowongan->poster && Storage::disk('public')->exists($lowongan->poster)) {
                Storage::disk('public')->delete($lowongan->poster);
            }

            $file = $request->file('poster');
            $namaLowongan = str_replace(' ', '_', $request->judulLowongan);
            $extension = $file->getClientOriginalExtension();
            $namaFile = $namaLowongan.'_'.time().'.'.$extension;

            $posterPath = $file->storeAs('poster_lowongan/'.$lowongan->id, $namaFile, 'public');
        }

        $lowongan->update([
            'judulLowongan' => $request->judulLowongan,
            'deskripsi' => $request->deskripsi,
            'kualifikasi' => $request->kualifikasi,
            'posisiLowongan' => $request->posisiLowongan,
            'durasiKerja' => $request->durasiKerja,
            'awalPendaftaran' => $request->awalPendaftaran,
            'batasPendaftaran' => $request->batasPendaftaran,
            'mulaiKerja' => $request->mulaiKerja,
            'akhirKerja' => $request->akhirKerja,
            'kuota_diterima' => $request->kuota_diterima,
            'poster' => $posterPath,
        ]);

        $today = Carbon::today('Asia/Jakarta')->toDateString();
        if ($today >= $lowongan->awalPendaftaran && $today <= $lowongan->batasPendaftaran) {
            $lowongan->update(['status' => 1]);
        } else {
            $lowongan->update(['status' => 0]);
        }

        return redirect()->route('lowongans.index')->with('success', 'Informasi Lowongan berhasil diperbarui');

    }

    public function publish(string $id)
    {

        $lowongan = Lowongan::findOrfail($id);

        $adaFormulir = formulir::where('idLowongan', $id)->exists();
        $adaTahapan = TahapRekrutmen::where('idLowongan', $id)->exists();

        if (! $adaFormulir && ! $adaTahapan) {
            return back()->with('error', 'Formulir dan tahapan belum dibuat');
        }

        if (! $adaFormulir) {
            return redirect()->route('formulir.add', $id)
                ->with('error', 'Silakan buat formulir terlebih dahulu');
        }

        if (! $adaTahapan) {
            return redirect()->route('tahapan.manage', $id)
                ->with('error', 'Silakan buat tahapan seleksi terlebih dahulu');
        }

        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
        $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

        if ($today < $awalPendaftaran) {
            return back()->with('error', 'Lowongan tidak bisa di publish karena belum waktunya.');
        }

        if ($today > $batasPendaftaran) {
            return back()->with('error', 'Lowongan tidak bisa di publish karena sudah melewati batas pendaftaran .');
        }

        if ($today >= $awalPendaftaran && $today <= $batasPendaftaran) {
            if ($lowongan->status == 0) {
                $lowongan->update(['status' => 1]);
            }

            return back()->with('success', 'Lowongan berhasil di publish');
        }

    }

    public function unpublish(string $id)
    {
        $lowongan = Lowongan::findOrfail($id);
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
        $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

        // ini kalau belum waktunya
        if ($today < $awalPendaftaran) {
            return back()->with('error', 'Lowongan belum bisa di unpublish karena belum waktunya');
        }

        // ini kalau masih kebuka jadinya bisa di unpublish
        if ($today > $batasPendaftaran) {
            if ($lowongan->status == 1) {
                $lowongan->update(['status' => 0]);
            }

            return back()->with('success', 'Lowongan berhasil di unpublish (masa pendaftaran sudah lewat).');
        }

        // ini dalam keadaan misalnya admin mau unpublish
        if ($today >= $awalPendaftaran && $today <= $batasPendaftaran) {
            if ($lowongan->status == 1) {
                $lowongan->update(['status' => 0]);
            }

            return back()->with('success', 'Lowongan berhasil di unpublish');
        }

        return back()->with('error', 'Lowongan tidak berhasil di unpublish');
    }
}
