<?php

namespace App\Http\Controllers;

use App\Models\KualitasKerja;
use App\Models\Tugas;
use App\Models\TugasMahasiswa;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenilaianKinerjaController extends Controller
{
    public function showNilaiKinerja()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $unit = Unit::findOrFail($idUnit);
        $nilaiKinerja = KualitasKerja::with(['unit'])
            ->where('idUnit', $idUnit)
            ->orderBy('status', 'desc')
            ->get();

        return view('penilaiankinerja.indexnilai', compact('nilaiKinerja', 'unit'));
    }

    public function storeNilai(Request $request)
    {
        $request->validate([
            'idUnit' => 'required',
            'nilaiMin' => 'required|numeric|min:0|max:100',
            'nilaiMax' => 'required|numeric|gt:nilaiMin|max:100',
            'kategori' => 'nullable|string|max:100',
            'kategori_select' => 'nullable|string',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'numeric' => 'Bagian :attribute wajib berupa angka.',
            'min' => 'Bagian :attribute minimal sesuai yang ditentukan',
            'max' => 'Bagian :attribute max sesuai yang ditentukan',
            'nilaiMax.gt' => 'nilai Max harus lebih besar dari nilai min',
        ], [
            'idUnit' => 'id Unit',
            'nilaiMin' => 'nilai minimal',
            'nilaiMax' => 'nilai maksimal',
            'kategori' => 'kategori',
            'kategori_select' => 'kategori lainnya',
        ]);

        if ($request->kategori_select === 'lainnya') {
            $kategori = $request->kategori;
        } else {
            $kategori = $request->kategori_select;
        }

        if (! $kategori) {
            return back()->withErrors(['kategori' => 'Kategori wajib diisi'])->withInput();
        }

        KualitasKerja::create([
            'idUnit' => $request->idUnit,
            'nilaiMin' => $request->nilaiMin,
            'nilaiMax' => $request->nilaiMax,
            'kategori' => $kategori,
            'status' => 1,
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function updateNilaiKinerja(Request $request, $id)
    {
        $request->validate([
            'nilaiMin' => 'required|numeric|min:0|max:100',
            'nilaiMax' => 'required|numeric|gt:nilaiMin|max:100',
            'kategori' => 'nullable|string|max:100',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'numeric' => 'Bagian :attribute wajib berupa angka.',
            'min' => 'Bagian :attribute minimal sesuai yang ditentukan',
            'max' => 'Bagian :attribute max sesuai yang ditentukan',
            'nilaiMax.gt' => 'nilai Max harus lebih besar dari nilai min',
        ], [
            'nilaiMin' => 'nilai minimal',
            'nilaiMax' => 'nilai maksimal',
            'kategori' => 'kategori',
        ]);

        $data = KualitasKerja::findOrFail($id);

        $kategori = $request->kategori_select === 'lainnya'
            ? $request->kategori
            : $request->kategori_select;

        if (! $kategori) {
            return back()->withErrors(['kategori' => 'Kategori wajib diisi'])->withInput();
        }

        $data->update([
            'nilaiMin' => $request->nilaiMin,
            'nilaiMax' => $request->nilaiMax,
            'kategori' => $kategori,
        ]);

        return back()->with('success', 'Data berhasil diupdate');

    }

    public function toggleStatus($id)
    {
        $data = KualitasKerja::findOrFail($id);

        $newStatus = $data->status == 1 ? 0 : 1;

        KualitasKerja::where('id', $id)->update([
            'status' => $newStatus,
        ]);

        return response()->json([
            'success' => true,
            'status' => $newStatus,
            'id' => $id,
        ]);
    }

    // ini untuk bagian tugas yess
    public function listUnitTugas()
    {
        $unitId = Auth::user()->staffUnit()->pluck('idUnit');

        $unit = Unit::whereIn('id', $unitId)->get();

        return view('penilaiankinerja.listunit', compact('unit'));
    }

    public function listTugasStaff($idUnit)
    {
        $idStaffUnits = DB::table('staffunit')
            ->where('idUser', auth()->id())
            ->pluck('id'); // ini idStaffUnit
        $data = DB::table('tugas as t')
            ->join('tugas_mahasiswa as tm', 'tm.idTugas', '=', 't.id')
            ->join('mahasiswa as m', 'm.id', '=', 'tm.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->where('t.idUnit', $idUnit)
            ->whereIn('t.idStaffUnit', $idStaffUnits)
            ->select(
                't.id',
                'm.id as idMahasiswa',
                'u.name as namaMahasiswa',
                't.namaTugas',
                't.deskripsi',
                't.bobotNilai',
                't.tenggatPengumpulan',
                'tm.progressTugas',
                'tm.file_path',
                'tm.statusPengumpulan',
                'tm.tanggalPengumpulan'
            )
            ->get();

        return view('penilaiankinerja.listtugasstaff', compact('data', 'idUnit'));
    }

    public function createTugas($idUnit)
    {
        $mahasiswa = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'p.idLowongan', '=', 'l.id')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->where('p.statusPendaftaran', 'diterima')
            ->where('l.idUnit', $idUnit)
            ->where('l.akhirKerja', '>=', now())
            ->select(
                'm.id as idMahasiswa',
                'u.name as namaMahasiswa',
                'l.judulLowongan as namaLowongan',
                'l.id as idLowongan'
            )
            ->get();

        return view('penilaiankinerja.createTugas', compact('mahasiswa', 'idUnit'));
    }

    public function storeTugas(Request $request)
    {
        $request->validate([
            'idUnit' => 'required',
            'idMahasiswa' => 'required|array|min:1',
            'idLowongan' => 'required',
            'namaTugas' => 'required',
            'deskripsi' => 'required',
            'bobotNilai' => 'required|numeric',
            'tenggatPengumpulan' => 'required|date',
        ], [
            'required' => 'Bagian :attribute wajib untuk diisi.',
            'numeric' => 'Bagian :attribute wajib dalam bentuk angka',
            'date' => 'Bagian :attribute wajib dalam bentuk tanggal',
            'idMahasiswa.min' => 'Mahasiswa harus dipilih minimal 1',
        ], [
            'idUnit' => 'isUnit',
            'idMahasiswa' => 'idMahasiswa',
            'idLowongan' => 'idLowongan',
            'namaTugas' => 'nama Tugas',
            'deskripsi' => 'deskripsi',
            'bobotNilai' => 'bobot nilai',
            'tenggatPengumpulan' => 'tenggat pengumpulan',
        ]);

        DB::transaction(function () use ($request) {
            $idStaffUnit = DB::table('staffunit')
                ->where('idUser', Auth::id())
                ->where('idUnit', $request->idUnit)
                ->value('id');

            $idTugas = DB::table('tugas')->insertGetId([
                'idStaffUnit' => $idStaffUnit,
                'idUnit' => $request->idUnit,
                'idLowongan' => $request->idLowongan,
                'namaTugas' => $request->namaTugas,
                'deskripsi' => $request->deskripsi,
                'bobotNilai' => $request->bobotNilai,
                'tenggatPengumpulan' => $request->tenggatPengumpulan,
            ]);

            $dataInsert = [];

            foreach ($request->idMahasiswa as $idMhs) {
                $dataInsert[] = [
                    'idMahasiswa' => $idMhs,
                    'idTugas' => $idTugas,
                    'statusPengumpulan' => null,
                    'tanggalPengumpulan' => null,
                    'progressTugas' => 'assigned',
                    'file_path' => null,
                ];
            }

            DB::table('tugas_mahasiswa')->insert($dataInsert);

        });

        return redirect()
            ->route('tugas.listtugas', $request->idUnit)
            ->with('success', 'Tugas berhasil ditambahkan');
    }

    // list lowongan mahasiswa
    public function listLowonganAktif()
    {
        $idMahasiswa = Auth::user()->mahasiswa->id;

        $lowongan = DB::table('pendaftaran as p')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('unit as u', 'u.id', '=', 'l.idUnit')
            ->where('p.idMahasiswa', $idMahasiswa)
            ->where('p.statusPendaftaran', 'diterima')
            ->select(
                'l.id',
                'l.judulLowongan',
                'u.name',
                'l.mulaiKerja',
                'l.akhirKerja'

            )
            ->orderByRaw(
                'CASE 
                    WHEN NOW() BETWEEN l.mulaiKerja AND l.akhirKerja THEN 1
                    ELSE 2
                END
            ')
            ->get();

        return view('mahasiswaPage.listlowongan', compact('lowongan'));
    }

    // ini list tugas untuk mahasiswa
    public function listTugas($idLowongan)
    {
        $idMahasiswa = Auth::user()->mahasiswa->id;

        $tugas = DB::table('tugas as t')
            ->join('staffUnit as st', 'st.id', '=', 't.idStaffUnit')
            ->join('users as u', 'u.id', '=', 'st.idUser')
            ->join('tugas_mahasiswa as tm', 'tm.idTugas', '=', 't.id')
            ->where('tm.idMahasiswa', $idMahasiswa)
            ->where('t.idLowongan', $idLowongan)
            ->select(
                't.id as idTugas',
                't.namaTugas',
                't.deskripsi',
                't.tenggatPengumpulan',
                'tm.progressTugas',
                'tm.statusPengumpulan',
                'tm.tanggalPengumpulan',
                'tm.file_path',
                'tm.tenggatRevisi',
                'tm.catatanRevisi',
                'u.name as namaUser'
            )
            ->get();

        return view('mahasiswaPage.listtugasmahasiswa', compact('tugas'));
    }

    public function updateProgress($idTugas)
    {
        $idMahasiswa = Auth::user()->mahasiswa->id;
        DB::table('tugas_mahasiswa')
            ->where('idMahasiswa', $idMahasiswa)
            ->where('idTugas', $idTugas)
            ->update([
                'progressTugas' => 'inProgress',
            ]);

        return back()->with('success', 'status tugas diubah menjadi proses');
    }

    public function showMahasiswa()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $mahasiswa = DB::table('pendaftaran as p')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as us', 'us.id', '=', 'm.idUser')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('unit as u', 'u.id', '=', 'l.idUnit')
            ->where('l.idUnit', $idUnit)
            ->where('p.statusPendaftaran', 'diterima')
            ->select(
                'm.id as idMahasiswa',
                'l.id as idLowongan',
                'p.id',
                'us.name as namaMahasiswa',
                'l.judulLowongan',
                'u.name as namaUnit',
                'p.statusPendaftaran'
            )
            ->get();

        return view('adminUnitPage.listmahasiswatugas', compact('mahasiswa'));

    }

    public function showTugasMahasiswaAdmin($idMahasiswa, $idLowongan)
    {
        $mahasiswa = DB::table('mahasiswa as m')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->where('m.id', $idMahasiswa)
            ->select('m.id', 'u.name as namaMahasiswa')
            ->first();
        $tugas = DB::table('tugas_mahasiswa as tm')
            ->join('tugas as t', 't.id', '=', 'tm.idTugas')
            ->leftJoin('penilaian_kinerja as pk', function ($join) use ($idMahasiswa) {
                $join->on('pk.idTugas', '=', 't.id')
                    ->where('pk.idMahasiswa', '=', $idMahasiswa);
            })
            ->where('tm.idMahasiswa', $idMahasiswa)
            ->where('t.idLowongan', $idLowongan)
            ->select(
                't.namaTugas',
                't.deskripsi',
                't.bobotNilai',
                't.tenggatPengumpulan',
                'tm.statusPengumpulan',
                'tm.tanggalPengumpulan',
                'tm.file_path',
                'pk.catatan',
                'pk.penalti',
                'pk.nilaiAkhir'
            )
            ->get();

        return view('adminUnitPage.listtugasmahasiswa', compact('mahasiswa', 'tugas'));

    }

    public function submitTugas($idTugas, Request $request)
    {
        $request->validate([
            'tugas' => 'required|file|mimes:jpg,jpeg,png,pdf,xlsx,xls,doc,docx,ppt,pptx|max:2048',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'file' => 'Bagian :attribute harus bertipe file',
            'mimes' => 'Bagian :attribute harus berjenis jpg/jpeg/png/pdf/excel/doc/ppt',
            'max' => 'Bagian :attribute maksimal 20MB',
        ], [
            'tugas' => 'file tugas',
        ]);

        $file = $request->file('tugas');
        $idMahasiswa = Auth::user()->mahasiswa->id;

        $tugas = Tugas::findOrFail($idTugas);

        $tugasMhs = TugasMahasiswa::where('idMahasiswa', $idMahasiswa)
            ->where('idTugas', $idTugas)
            ->first();
        $namaTugas = Str::slug($tugas->namaTugas, '_');

        $namaFile = $namaTugas.'_'.$idMahasiswa.'.'.$file->getClientOriginalExtension();

        $filePath = $file->storeAs(
            'tugas/'.$idTugas,
            $namaFile,
            'public'
        );

        $deadline = $tugasMhs->tenggatRevisi ?? $tugas->tenggatPengumpulan;

        $status = now()->lte($deadline)
                  ? 'tepatwaktu'
                  : 'terlambat';

        TugasMahasiswa::updateOrInsert(
            [
                'idMahasiswa' => $idMahasiswa,
                'idTugas' => $idTugas,
            ],
            [
                'tanggalPengumpulan' => now(),
                'statusPengumpulan' => $status,
                'file_path' => $filePath,
                'progressTugas' => 'submitted',
            ]
        );

        return back()->with('success', 'Tugas berhasil dikumpulkan');
    }

    // ini untuk penilaian kinerja
    public function simpanPenilaian(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'idTugas' => 'required',
            'idMahasiswa' => 'required',
            'nilaiAwal' => 'required|numeric|min:0',
            'penalti' => 'nullable|numeric|min:0',
            'catatan' => 'required',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'numeric' => 'Bagian :attribute wajib dalam bentuk angka.',
            'min' => 'Bagian :attribute harus minimal 0',
        ], [
            'idTugas' => 'idTugas',
            'idMahasiswa' => 'idMahasiswa',
            'nilaiAwal' => 'nilai awal',
            'catatan' => 'catatan',
        ]);

        $tugas = DB::table('tugas')
            ->where('id', $request->idTugas)
            ->first();

        // dd($tugas->idLowongan, $tugas->idUnit);

        if (! $tugas) {
            return back()->with('error', 'Tugas tidak ditemukan');
        }

        // 2. ambil tugas_mahasiswa
        $tugasMhs = DB::table('tugas_mahasiswa')
            ->where('idTugas', $request->idTugas)
            ->where('idMahasiswa', $request->idMahasiswa)
            ->first();

        if (! $tugasMhs) {
            return back()->with('error', 'Data tugas mahasiswa tidak ditemukan');
        }

        // 3. hitung nilai
        $nilaiAwal = (float) $request->nilaiAwal;
        $penalti = min((float) ($request->penalti ?? 0), $nilaiAwal);
        $nilaiAkhir = $nilaiAwal - $penalti;

        // 4. simpan penilaian
        DB::table('penilaian_kinerja')->updateOrInsert(
            [
                'idTugas' => $request->idTugas,
                'idMahasiswa' => $request->idMahasiswa,
            ],
            [
                'nilaiAwal' => $nilaiAwal,
                'penalti' => $penalti,
                'nilaiAkhir' => $nilaiAkhir,
                'catatan' => $request->catatan,
            ]
        );

        // 5. update progress tugas
        DB::table('tugas_mahasiswa')
            ->where('idTugas', $request->idTugas)
            ->where('idMahasiswa', $request->idMahasiswa)
            ->update([
                'progressTugas' => 'done',
            ]);

        // 6. ambil pendaftaran (BERDASARKAN LOWONGAN DARI TUGAS)
        $pendaftaran = DB::table('pendaftaran')
            ->where('idMahasiswa', $request->idMahasiswa)
            ->where('idLowongan', $tugas->idLowongan)
            ->first();
        // dd($pendaftaran);

        if (! $pendaftaran) {
            return back()->with('error', 'Pendaftaran tidak ditemukan');
        }

        // 7. hitung total nilai
        $total = DB::table('penilaian_kinerja as pk')
            ->join('tugas as t', 't.id', '=', 'pk.idTugas')
            ->where('pk.idMahasiswa', $request->idMahasiswa)
            ->where('t.idLowongan', $tugas->idLowongan)
            ->avg('pk.nilaiAkhir') ?? 0;
        // dd($total);

        // 8. kategori
        $kategori = DB::table('kualitas_kinerja')
            ->where('idUnit', $tugas->idUnit)
            ->where('status', 1)
            ->where('nilaiMin', '<=', $total)
            ->where('nilaiMax', '>=', $total)
            ->value('kategori');

        // 9. simpan total penilaian
        DB::table('total_penilaian_kinerja')->updateOrInsert(
            ['idPendaftaran' => $pendaftaran->id],
            [
                'totalNilai' => $total,
                'kategori' => $kategori,
            ]
        );

        return back()->with('success', 'Penilaian berhasil disimpan');
    }

    public function kirimRevisi(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'idTugas' => 'required',
            'idMahasiswa' => 'required',
            'tenggatRevisi' => 'required|date',
            'catatanRevisi' => 'required',
        ], [
            'required' => 'Bagian :attribute wajib diisi.',
            'date' => 'Bagian :atrribute harus dalam bentuk tanggal',
        ], [
            'idTugas' => 'idTugas',
            'idMahasiswa' => 'idMahasiswa',
            'tenggatRevisi' => 'tenggatRevisi',
            'catatanRevisi' => 'catatanRevisi',
        ]);

        TugasMahasiswa::where('idTugas', $request->idTugas)
            ->where('idMahasiswa', $request->idMahasiswa)
            ->update([
                'tenggatRevisi' => $request->tenggatRevisi,
                'catatanRevisi' => $request->catatanRevisi,
                'progressTugas' => 'revisi',
                'statusPengumpulan' => null,
            ]);

        // if (! $tugas) {
        //     return back()->with('error', 'Data tidak ditemukan');
        // }

        // $tugas->update([
        //     'tenggatRevisi' => $request->tenggatRevisi,
        //     'catatanRevisi' => $request->catatanRevisi,
        //     'progressTugas' => 'revisi',
        //     'statusPengumpulan' => null,
        // ]);

        return back()->with('success', 'Revisi berhasil dikirim');

    }

    public function listpenilaiankinerja()
    {
        $data = DB::table('total_penilaian_kinerja as tp')
            ->join('pendaftaran as p', 'p.id', '=', 'tp.idPendaftaran')
            ->join('mahasiswa as m', 'm.id', '=', 'p.idMahasiswa')
            ->join('users as u', 'u.id', '=', 'm.idUser')
            ->join('lowongan as l', 'l.id', '=', 'p.idLowongan')
            ->join('unit as un', 'un.id', '=', 'l.idUnit')
            ->select(
                'm.id as idMahasiswa',
                'u.name as namaMahasiswa',
                'l.id as idLowongan',
                'l.judulLowongan',
                'tp.totalNilai',
                'tp.kategori',
                'un.name'
            )
            ->get();
        foreach ($data as $d) {
            $d->detail = DB::table('tugas_mahasiswa as tm')
                ->join('tugas as t', 't.id', '=', 'tm.idTugas')
                ->leftJoin('penilaian_kinerja as pk', function ($join) use ($d) {
                    $join->on('pk.idTugas', '=', 't.id')
                        ->where('pk.idMahasiswa', '=', $d->idMahasiswa);
                })
                ->where('tm.idMahasiswa', $d->idMahasiswa)
                ->where('t.idLowongan', $d->idLowongan)
                ->select(
                    't.namaTugas',
                    'pk.nilaiAwal',
                    'pk.penalti',
                    'pk.nilaiAkhir',
                    'pk.catatan'
                )
                ->get();
        }

        return view('penilaiankinerja.halamantotalpenilaian', compact('data'));
    }
}
