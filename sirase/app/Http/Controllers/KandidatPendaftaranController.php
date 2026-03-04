<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\ProgressTahapanKandidat;
use App\Models\TahapRekrutmen;
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
        
            $tahapIni = 'Menunggu';

            //kita harus cek tahap per tahapan setiap mahasiswa
            foreach ($tahapan as $tahap){
                //kemudian kita cari tahapan yang sesuai sama kandidat saat ini
                $statusTahap = 'Menunggu';

                //ini kita loop untuk mencocokan tahapann sama progress kandidat saat ini
                foreach($progressKandidat as $progress){
                    if($progress->idTahapRekrutmen == $tahap->id){
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

    public function showDetailKandidat(string $idPendaftaran){ 
        $detailKandidat = DB::table('pendaftaran as p')
                          ->join('mahasiswa as m', 'm.id','=', 'p.idMahasiswa')
                          ->join('lowongan as l','l.id',"=",'p.idLowongan')
                          ->join('users as u','u.id','=','m.idUser')
                          ->select(
                            'p.id as idPendaftaran',
                            'p.tanggal_daftar as tanggalDaftar',
                            'p.statusPendaftaran as statusPendaftaran',
                            'u.name as namaMahasiswa',
                            'm.nrp as nrp',
                            'm.fakultas as fakultas',
                            'l.judulLowongan as judulLowongan',
                            'l.id as idLowongan'
                        )
                        ->where('p.id', $idPendaftaran)
                        ->first();

        $jawabanFormulir = DB::table('jawaban_formulir as jf')
                           ->join('konten_formulir as k','k.id','=','jf.idKontenFormulir')
                           ->join('pendaftaran as p', 'p.id','=','jf.idPendaftaran')
                           ->where('jf.idPendaftaran', $idPendaftaran)
                           ->whereColumn('k.idLowongan','p.idLowongan')
                           ->select('k.namaField','jf.jawaban')
                           ->orderBy('k.id')
                           ->get();

        $berkasPendaftaran = DB::table('berkas_pendaftaran as b')
                            ->join('konten_formulir as kf', 'kf.id','=', 'b.id')
                            ->where('b.idPendaftaran', $idPendaftaran)
                            ->select('kf.namaField','b.namaFile','b.filePath')
                            ->get();

        $tahapan = DB::table('tahap_rekrutmen')
                   ->where('idLowongan',$detailKandidat->idLowongan)
                   ->where('status',1)
                   ->orderBy('urutan','asc')
                   ->get();

        $progress = DB::table('progress_tahapan_kandidat')
                    ->where('idPendaftaran', $idPendaftaran)
                    ->get()
                    ->keyBy('idTahapRekrutmen');
        //kita akan menempelkan status dari tahapan untuk pendaftaran ini
        foreach($tahapan as $tahap){
            if(isset($progress[$tahap->id])){
                $tahap->status = $progress[$tahap->id]->status;
                $tahap->catatan = $progress[$tahap->id]->catatan;
                $tahap->updated_at = $progress[$tahap->id]->updated_at;
            }else{
                $tahap->status = 'Menunggu';
                $tahap->catatan = null;
                $tahap->updated_at = null;
            }
        }

        return view('kandidatPendaftaran.detailProgressKandidat',compact('detailKandidat','jawabanFormulir','berkasPendaftaran','tahapan'));
    }

    //jadi ini bakal update status dari pendaftaran
    //juga bakal insert progress kandidat
    public function updateStatusDaftar(string $idPendaftaran){
        //ini harus pakai transaction karena dia ada 2 kasus sekaligus
        DB::transaction(function() use ($idPendaftaran){

            $pendaftaran = Pendaftaran::findOrFail($idPendaftaran);

            $pendaftaran->update([
                'statusPendaftaran' => 'diproses'
            ]);

            //kita harus ambil tahapan di urutan pertama
            $tahapPertama = TahapRekrutmen::where('idLowongan', $pendaftaran->idLowongan)
                            ->orderBy('urutan', 'asc')
                            ->first();

            if($tahapPertama){
                ProgressTahapanKandidat::create([
                    'idTahapRekrutmen' => $tahapPertama->id,
                    'idPendaftaran' => $idPendaftaran,
                    'status' => 'Proses',
                    'catatan' => '',
                ]);
            }
            
        });

        return back()->with('successProses', 'Proses Kandidat dimulai');

    }
}
