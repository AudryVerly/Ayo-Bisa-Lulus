<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WawancaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //kita perlu ambil data lowongan & kandidat
        $idProgressTahapan = $request->idProgressTahapan;
        $idPendaftaran = $request->idPendaftaran;
        $pendaftaran = DB::table('pendaftaran as p')
                       ->join('lowongan as l','p.idLowongan','=','l.id')
                       ->join('mahasiswa as m','p.idMahasiswa','=','m.id')
                       ->join('users as u','m.idUser','=','u.id')
                       ->select(
                        'p.id as idPendaftaran',
                        'p.idLowongan as idLowongan',
                        'u.name as namaMahasiswa',
                        'l.judulLowongan as namaLowongan'
                       )
                    ->where('p.id',$idPendaftaran)
                    ->first();
        $penilai = DB::table('tim_penilai as tp')
                   ->join('staffUnit as s','tp.idStaffUnit','=','s.id')
                   ->join('users as u','s.idUser','=','u.id')
                   ->select('tp.id as idTimPenilai',
                            'u.name as namaPenilai')
                    ->where('tp.idLowongan', $pendaftaran->idLowongan)
                    ->where('tp.isActive',1)
                    ->get();
        return view('setwawancara.invtwawancara', compact('pendaftaran','penilai','idProgressTahapan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //susunanya adalah rules, message, atrributes
        $request->validate([
            'idPendaftaran' => 'required',
            'idProgressTahapan' => 'required',
            'tanggal_wawancara' => 'required|date', 
            'waktu_mulai'=>'required',
            'waktu_selesai' =>'required',
            'tim_penilai' => 'required',
            'lokasi' => 'nullable|string|max:255',
            'link_wawancara' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'date' => ':attribute harus berupa tanggal yang valid',
            'max' => ':attribute maksimal :max karakter.'
        ],[
            'idPendaftaran' => 'idPendaftaran',
            'idProgressTahapan' => 'idProgressTahapan',
            'tanggal_wawancara' => 'tanggal Wawancara', 
            'waktu_mulai'=>'Waktu Mulai',
            'waktu_selesai' =>'Waktu Selesai',
            'tim_penilai' => 'Penilai',
            'lokasi' => 'Lokasi',
            'link_wawancara' => 'Link Wawancara',
            'keterangan' => 'Keterangan',
        ]);

        DB::transaction(function () use ($request){
            //jadinya ini ambil id jadwal
            $idJadwal = DB::table('jadwal_wawancara')->insertGetId([
                'idProgressTahapan' => $request->idProgressTahapan,
                'idPendaftaran' => $request->idPendaftaran,
                'tanggal_wawancara' => $request->tanggal_wawancara,
                'waktu_mulai' => $request->waktu_mulai,
                'waktu_selesai' => $request->waktu_selesai,
                'lokasi' => $request->lokasi,
                'link_wawancara' => $request->lokasi,
                'keterangan' => $request->keterangan,
                'status'=>'terjadwal',
            ]);

            $timPenilai =  $request->tim_penilai;

            if(!is_array($timPenilai)){
                $timPenilai = [$timPenilai];
            }

            foreach ($timPenilai as $penilai){
                DB::table('tim_penilai_wawancara')->insert([
                    'idJadwalWawancara' => $idJadwal,
                    'idTimPenilai' => $penilai
                ]);
            }
        });

        return response()->json([
            'success' => true,'message' => 'Jadwal Wawancara berhasil disimpan'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
