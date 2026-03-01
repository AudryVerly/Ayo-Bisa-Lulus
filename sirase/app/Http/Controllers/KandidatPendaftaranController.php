<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KandidatPendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowongan = DB::table('lowongan')
                    ->where('idUnit', $idUnit)
                    ->select(
                        'lowongan.*',
                        DB::raw('(SELECT COUNT(*) 
                                    FROM pendaftaran 
                                    WHERE pendaftaran.idLowongan = lowongan.id) as pendaftaran_count')
                    )
                    ->orderBy('status','desc')
                    ->get();
        return view('kandidatPendaftaran.listlowongan', compact('lowongan'));
    }

    public function kandidatList(string $idLowongan){
        $kandidat = DB::table('lowongan as l')
                    ->join('pendaftaran as p','l.id','=','p.idLowongan')
                    ->join('mahasiswa as m','m.id','=','p.idMahasiswa')
                    ->join('users as u','m.idUser','=','u.id')
                    ->where('p.idLowongan',$idLowongan)
                    ->select(
                        'u.name as namaKandidat',
                        'u.email as kandidatEmail',
                        'm.nrp as nrp',
                        'p.statusPendaftaran as statusPendaftaran',
                        'p.tanggal_daftar as tanggalDaftar',
                        'p.id as idPendaftaran'
                    )
                    ->get();
        $tahapan = DB::table('tahap_rekrutmen')
                   ->where('idLowongan', $idLowongan)
                   ->where('status',1)
                   ->orderBy('urutan','asc')
                   ->get();
        //kita loop supaya tahu tahapan saat ini
        //kita loop supaya bisa baca per kandidatnya
        //ini masih ada salah aku benerin nanti lagi
        foreach($kandidat as $item){
            $progressKandidat = DB::table('progress_tahapan_kandidat')
                                ->where('idPendaftaran', $item->idPendaftaran)
                                ->get();
        
            $tahapIni = 'Belum diMulai';

            //kita harus cek tahap per tahapan setiap mahasiswa
            foreach ($tahapan as $tahap){
                //kemudian kita cari tahapan yang sesuai sama kandidat saat ini
                $statusTahap = 'Menunggu';

                //ini kita loop untuk mencocokan tahapann sama progress kandidat saat ini
                foreach($progressKandidat as $progress){
                    if($progress->idTahapanRekrutmen == $tahap->id){
                        $statusTahap = $progress->status;
                        break;
                    }
                }

                if($statusTahap === 'Proses'){
                    $tahapIni = $tahap->name;
                    break;
                }
               
                if($tahap->status === 'Lulus' || $tahap->status === 'Gagal'){
                    $tahapIni = $tahap->name;
                }

            }
            $item->tahapIni = $tahapIni;
        }

        return view('kandidatPendaftaran.listkandidat',compact('kandidat'));
    }
}
