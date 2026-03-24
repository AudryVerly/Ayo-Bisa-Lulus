<?php

namespace App\Http\Controllers;

use App\Mail\InterviewCandidateMail;
use App\Mail\InterviewerCancelMail;
use App\Mail\InterviewInterviewerMail;
use App\Mail\InterviewUpdateCandidateMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class WawancaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // kita perlu ambil data lowongan & kandidat
        $idProgressTahapan = $request->idProgressTahapan;
        $idPendaftaran = $request->idPendaftaran;
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $idJadwal = DB::table('jadwal_wawancara')
            ->where('idPendaftaran', $idPendaftaran)
            ->pluck('id')
            ->toArray();
        $staffSudahMenulai = DB::table('wawancara_penilai')
            ->whereIn('idJadwalWawancara', $idJadwal)
            ->whereIn('status', ['belum', 'terjadwal', 'sudah'])
            ->pluck('idStaffUnit')
            ->toArray();
        $pendaftaran = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->select(
                'p.id as idPendaftaran',
                'p.idLowongan as idLowongan',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan'
            )
            ->where('p.id', $idPendaftaran)
            ->first();
        $penilai = DB::table('staffunit as s')
            ->join('users as u', 's.idUser', '=', 'u.id')
            ->select(
                's.id as idStaffUnit',
                'u.name as namaPenilai'
            )
            ->where('s.idUnit', $idUnit)
            ->where('s.status', 1)
            ->where('u.role', '!=', 'AdminUnit')
            ->whereNotIn('s.id', $staffSudahMenulai)
            ->get();

        return view('setwawancara.invtwawancara', compact('pendaftaran', 'penilai', 'idProgressTahapan'));
    }

    public function storeData(Request $request)
    {
        $request->validate([
            'idPendaftaran' => 'required',
            'idProgressTahapan' => 'required',
            'tanggal_wawancara' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'tim_penilai' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'link_wawancara' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal yang valid',
            'max' => ':attribute maksimal :max karakter.',
        ], [
            'idPendaftaran' => 'idPendaftaran',
            'idProgressTahapan' => 'idProgressTahapan',
            'tanggal_wawancara' => 'tanggal Wawancara',
            'waktu_mulai' => 'Waktu Mulai',
            'waktu_selesai' => 'Waktu Selesai',
            'tim_penilai' => 'Penilai',
            'lokasi' => 'Lokasi',
            'link_wawancara' => 'Link Wawancara',
            'keterangan' => 'Keterangan',
        ]);

        DB::transaction(function () use ($request) {

            $pendaftaran = DB::table('pendaftaran as p')
                ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
                ->join('users as u', 'm.idUser', '=', 'u.id')
                ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
                ->join('unit as un', 'l.idUnit', '=', 'un.id')
                ->select('u.email',
                    'u.name as namaMahasiswa',
                    'l.judulLowongan as namaLowongan',
                    'un.name as namaUnit',
                    'un.kontak as kontakUnit',
                    'un.emailUnit as emailUnit')
                ->where('p.id', $request->idPendaftaran)
                ->first();

            // jadinya ini ambil id jadwal
            $idJadwal = DB::table('jadwal_wawancara')->insertGetId([
                'idProgressTahapan' => $request->idProgressTahapan,
                'idPendaftaran' => $request->idPendaftaran,
                'tanggal_wawancara' => $request->tanggal_wawancara,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'lokasi' => $request->lokasi,
                'link_wawancara' => $request->link_wawancara,
                'keterangan' => $request->keterangan,
                'status' => 'terjadwal',
            ]);

            $timPenilai = $request->tim_penilai;

            if (! is_array($timPenilai)) {
                $timPenilai = [$timPenilai];
            }

            foreach ($timPenilai as $penilai) {
                // kita kasik token supaya dia gak main tembak aja
                $token = Str::random(40);

                $idpewawancara = DB::table('wawancara_penilai')->insertGetId([
                    'idJadwalWawancara' => $idJadwal,
                    'idStaffUnit' => $penilai,
                    'status' => 'belum',
                    'token' => $token,
                ]);

                // ini url buat terima tolak
                $urlTerima = url('/interview/confirm/'.$idpewawancara.'/terima?token='.$token);
                $urlTolak = url('/interview/confirm/'.$idpewawancara.'/tolak?token='.$token);

                $dataEmailInterviewer = [
                    'namaMahasiswa' => $pendaftaran->namaMahasiswa,
                    'namaLowongan' => $pendaftaran->namaLowongan,
                    'tanggal' => $request->tanggal_wawancara,
                    'mulai' => $request->waktu_mulai,
                    'selesai' => $request->waktu_selesai,
                    'lokasi' => $request->lokasi,
                    'link' => $request->link_wawancara,
                    'urlTerima' => $urlTerima,
                    'urlTolak' => $urlTolak,
                ];
                // ini email pewawancara
                $staffPenilai = DB::table('staffunit as s')
                    ->join('users as u', 's.idUser', '=', 'u.id')
                    ->where('s.id', $penilai)
                    ->select('u.email', 'u.name')
                    ->first();
                Mail::to($staffPenilai->email)->send(new InterviewInterviewerMail($dataEmailInterviewer, $staffPenilai->name));
            }
            $dataEmailKandidat = [
                'namaMahasiswa' => $pendaftaran->namaMahasiswa,
                'namaLowongan' => $pendaftaran->namaLowongan,
                'namaUnit' => $pendaftaran->namaUnit,
                'emailUnit' => $pendaftaran->emailUnit,
                'kontakUnit' => $pendaftaran->kontakUnit,
                'tanggal' => $request->tanggal_wawancara,
                'mulai' => $request->waktu_mulai,
                'selesai' => $request->waktu_selesai,
                'lokasi' => $request->lokasi,
                'link' => $request->link_wawancara,
            ];
            Mail::to($pendaftaran->email)->send(new InterviewCandidateMail($dataEmailKandidat));
        });

        return redirect()->back()->with('success', 'Field berhasil ditambahkan');
    }

    public function confirmJadwal($idpewawancara, $aksi, Request $request)
    {
        // jadi ini kita perlu tau idanya supaya nemu gak
        $pivot = DB::table('wawancara_penilai')->where('id', $idpewawancara)->first();
        if (! $pivot) {
            abort(404, 'Data penilai tidak ditemukan');
        }

        if ($request->token != $pivot->token) {
            abort(403, 'Token tidak valid');
        }

        $jadwal = DB::table('jadwal_wawancara')
            ->where('id', $pivot->idJadwalWawancara)
            ->first();

        if ($jadwal->status == 'batal') {
            return view('mail.interviewconfirm', [
                'aksi' => 'jadwal_batal',
            ]);
        }

        if ($pivot->status != 'belum') {
            return view('mail.interviewconfirm', [
                'aksi' => 'expired',
            ]);
        }

        if ($aksi == 'terima') {
            DB::table('wawancara_penilai')->where('id', $idpewawancara)
                ->update(['status' => 'terjadwal']);
            DB::table('jadwal_wawancara')->where('id', $pivot->idJadwalWawancara)
                ->update(['status' => 'terjadwal']);
        } elseif ($aksi == 'tolak') {
            DB::table('wawancara_penilai')->where('id', $idpewawancara)
                ->update(['status' => 'gagal']);
            // kita cek apabila lebih dari 1 interviwer
            $terima = DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $pivot->idJadwalWawancara)
                ->where('status', 'terjadwal')
                ->count();
            $pending = DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $pivot->idJadwalWawancara)
                ->where('status', 'belum')
                ->count();

            if ($terima == 0 && $pending == 0) {
                // semua nolak → jadwal batal
                DB::table('jadwal_wawancara')->where('id', $pivot->idJadwalWawancara)
                    ->update(['status' => 'batal']);
                $jadwal = DB::table('jadwal_wawancara')
                    ->select(
                        'idPendaftaran',
                        'tanggal_wawancara as tanggal',
                        'waktu_mulai as mulai',
                        'waktu_selesai as selesai')
                    ->where('id', $pivot->idJadwalWawancara)
                    ->first();
                $pendaftaran = DB::table('pendaftaran as p')
                    ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
                    ->join('users as u', 'm.idUser', '=', 'u.id')
                    ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
                    ->join('jadwal_wawancara as j', 'j.idPendaftaran', '=', 'p.id')
                    ->select('u.email',
                        '.name as namaMahasiswa',
                        'l.judulLowongan as namaLowongan')
                    ->where('p.id', $jadwal->idPendaftaran)
                    ->first();
                $dataEmailGagal = [
                    'namaMahasiswa' => $pendaftaran->namaMahasiswa,
                    'namaLowongan' => $pendaftaran->namaLowongan,
                    'tanggal' => $jadwal->tanggal,
                    'mulai' => $jadwal->mulai,
                    'selesai' => $jadwal->selesai,
                ];
                Mail::to($pendaftaran->email)->send(new InterviewUpdateCandidateMail($dataEmailGagal));
            }
        }

        return view('mail.interviewconfirm', ['aksi' => $aksi]);
    }

    // ini buat show jadwal di calendar
    public function showAllJadwal()
    {
        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'p.id', '=', 'j.idPendaftaran')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'm.idUser', '=', 'u.id')
            ->select(
                'j.id',
                'j.tanggal_wawancara as tanggalWawancara',
                'j.waktu_mulai as waktuMulai',
                'j.waktu_selesai as waktuSelesai',
                'j.lokasi as lokasi',
                'j.link_wawancara as link',
                'j.keterangan as keterangan',
                'j.status as status',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan'
            )
            ->get();
        foreach ($jadwal as $item) {
            $penilai = DB::table('wawancara_penilai as w')
                ->join('staffUnit as s', 'w.idStaffUnit', '=', 's.id')
                ->join('users as u', 's.idUser', '=', 'u.id')
                ->where('w.idJadwalWawancara', $item->id)
                ->pluck('u.name')
                ->toArray();
            $item->penilaiStr = implode(', ', $penilai);
        }

        return response()->json($jadwal);
    }

    public function cancelJadwal($id)
    {
        DB::transaction(function () use ($id) {
            $jadwal = DB::table('jadwal_wawancara as j')
                ->select(
                    'j.id',
                    'j.idPendaftaran',
                    'j.tanggal_wawancara as tanggal',
                    'j.waktu_mulai as mulai',
                    'j.waktu_selesai as selesai'
                )
                ->where('id', $id)
                ->first();

            DB::table('jadwal_wawancara')
                ->where('id', $id)
                ->update(['status' => 'batal']);
            DB::table('wawancara_penilai')
                ->where('idJadwalWawancara', $id)
                ->update(['status' => 'gagal']);

            $kandidat = DB::table('pendaftaran as p')
                ->join('mahasiswa as m', 'p.idMahasiswa', '=', 'm.id')
                ->join('users as u', 'm.idUser', '=', 'u.id')
                ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
                ->select(
                    'u.email',
                    'u.name as namaMahasiswa',
                    'l.judulLowongan as namaLowongan'
                )
                ->where('p.id', $jadwal->idPendaftaran)
                ->first();
            $penilai = DB::table('wawancara_penilai as w')
                ->join('staffunit as s', 'w.idStaffUnit', '=', 's.id')
                ->join('users as u', 's.idUser', '=', 'u.id')
                ->select('u.email', 'u.name')
                ->where('w.idJadwalWawancara', $id)
                ->get();

            $datacancelKandidat = [
                'namaMahasiswa' => $kandidat->namaMahasiswa,
                'namaLowongan' => $kandidat->namaLowongan,
                'tanggal' => $jadwal->tanggal,
                'mulai' => $jadwal->mulai,
                'selesai' => $jadwal->selesai,
            ];
            Mail::to($kandidat->email)->send(new InterviewUpdateCandidateMail($datacancelKandidat));

            foreach ($penilai as $p) {
                $dataEmail = [
                    'namaMahasiswa' => $kandidat->namaMahasiswa,
                    'namaLowongan' => $kandidat->namaLowongan,
                    'tanggal' => $jadwal->tanggal,
                    'mulai' => $jadwal->mulai,
                    'selesai' => $jadwal->selesai,
                ];
                Mail::to($p->email)->send(new InterviewerCancelMail($p->name, $dataEmail));
            }
        });

        return response()->json([
            'message' => 'Jadwal berhasil dibatalkan',
        ]);
    }

    public function showCalendarMahasiswa()
    {
        $idMahasiswa = Auth::user()->mahasiswa->id;
        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'j.idPendaftaran', '=', 'p.id')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->select(
                'j.id',
                'j.tanggal_wawancara as tanggalWawancara',
                'j.waktu_mulai as waktuMulai',
                'j.waktu_selesai as waktuSelesai',
                'j.lokasi as lokasi',
                'j.link_wawancara as link',
                'j.keterangan as keterangan',
                'j.status as status',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan'
            )
            ->where('p.idMahasiswa', $idMahasiswa)
            ->where('j.status', '!=', 'batal')
            ->get();
        foreach ($jadwal as $item) {
            $penilai = DB::table('wawancara_penilai as w')
                ->join('staffUnit as s', 'w.idStaffUnit', '=', 's.id')
                ->join('users as u', 's.idUser', '=', 'u.id')
                ->where('w.idJadwalWawancara', $item->id)
                ->pluck('u.name')
                ->toArray();
            $item->penilaiStr = implode(', ', $penilai);
        }

        return view('mahasiswaPage.listwawancara', compact('jadwal'));
    }

    public function showCalendarStaffUnit()
    {
        $idStaffUnit = Auth::user()->staffUnit->first()->id;
        $jadwal = DB::table('jadwal_wawancara as j')
            ->join('pendaftaran as p', 'j.idPendaftaran', '=', 'p.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('wawancara_penilai as w', 'w.idJadwalWawancara', '=', 'j.id')
            ->select(
                'j.id',
                'j.tanggal_wawancara as tanggalWawancara',
                'j.waktu_mulai as waktuMulai',
                'j.waktu_selesai as waktuSelesai',
                'j.lokasi as lokasi',
                'j.link_wawancara as link',
                'w.status as statusPenilai',
                'u.name as namaMahasiswa'
            )
            ->where('w.idStaffUnit', $idStaffUnit)
            ->where('w.status','!=','gagal')
            ->get();

        return view('staffUnitPage.listwawancarastaff',compact('jadwal'));
    }
}
