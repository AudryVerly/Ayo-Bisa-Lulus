<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Lowongan;
use App\Models\TahapRekrutmen;
use Illuminate\Support\Facades\DB;

class TahapRekrutmenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idUnit = Auth::user()->staffUnit()->pluck('idunit')->first();
        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit',$idUnit)
                    ->orderBy('status','desc')
                    ->get();
        return view('tahapanRekrutmen.utama', compact('lowongan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $lowongan = Lowongan::findOrFail($request->idLowongan);

        if($this->batasPendaftaran($lowongan)){
            return back()->with('error','Tidak Bisa menambah Tahapan karena Proses Masing Masing Kandidat akan dimulai');
        }
        $request ->validate([
            'name' => 'required|string',
            'tipe_tahap' => 'required|string',
            //ini ada supaya dapat idlowongannya dan bisa tau urutan terakhir drimana
            'idLowongan' => 'required|exists:lowongan,id'
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'idLowongan.exists' =>  'idLowongan wajib ada.',
            'string' => 'Bagian :attribute harus dalam bentuk string.'
        ],[
            'name' => 'nama Tahapan',
            'tipe_tahap' => 'Tipe tahapan',
            'idLowongan' => 'idLowongan'
        ]);

        $idLowongan = $request->idLowongan;

        $urutanterkahir = TahapRekrutmen::where('idLowongan', $idLowongan)
                          ->where('status', 1)
                          ->max('urutan') ?? 0; // dikasik 0 karena siapa tau memang inputan pertama kali
        
        TahapRekrutmen::create([
            'idLowongan' => $idLowongan,
            'name' => $request->name,
            'status' => 1,
            'urutan' => $urutanterkahir + 1,
            'tipe_tahap' => $request->tipe_tahap
        ]);

        $this->checkReady($idLowongan);

        return redirect()->back()->with('success','Field berhasil diTambah');

    }

    //ini priview kanan
    public function previewlist(string $id){
       
        $tahapan = TahapRekrutmen::where('idLowongan', $id )
            ->where('status', 1)
            ->orderBy('urutan', 'asc')
            ->get();

        return response()->json($tahapan);
    }

    //Ini priview kiri
    public function listTahapan(string $id){
       
        $tahapan = TahapRekrutmen::where('idLowongan', $id )
            ->where('status',1)
            ->orderBy('urutan')
            ->get();
        return response()->json($tahapan);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $tahapan = TahapRekrutmen::where('idLowongan', $id)
          ->orderBy('urutan','asc')
          ->get();
        $checkFormulir = DB::table('konten_formulir')
                         ->where('idLowongan', $id)
                         ->where('status',1)
                         ->count();
        $isLocked = $this->batasPendaftaran($id);

        return view('tahapanRekrutmen.tahapanform', compact('lowongan','tahapan','checkFormulir','isLocked'));
    }

    //ini nuat soft delete tahapan tersebut
    public function toggle(string $id,Request $request){
        $tahapan = TahapRekrutmen::findorFail($id);
        $idLowongan = $tahapan->idLowongan;

        if($this->batasPendaftaran($idLowongan)){
            return response()->json([
                'message' => 'Progress Rekrutmen telah dimulai,tidak bisa diproses'
            ],403);
        }

        if($this->tahapanSudahterpakai($id)){
            return response()->json([
                'message'=>'Tahap sudah dipakai, tidak bisa dinonaktifkan'
            ],403);
        }

        //disini pakai db transaction lagi karena banyak yang harus di lakukan
        // $tahapan->update(['status' => $request->status ? 1 : 0]);
        DB::transaction(function() use ($tahapan, $request,$idLowongan){
            //Nonaktifkan
            if($request->status == 0 && $tahapan->status == 1){
                TahapRekrutmen::where('idLowongan', $idLowongan)
                ->where('status',1)
                //jadi kalau misalnya dia di nonaktifkan maka urutan yang dibawahnya akan naik
                ->where('urutan', '>', $tahapan->urutan)
                ->decrement('urutan');

                $tahapan->update([
                    'status' => 0,
                    //ini null karena kan dia dimatikan nanti tahap lain udah di decrement
                    'urutan' => 0,
                ]);
            }

            //aktifkan
            if($request->status == 1 && $tahapan->status == 0){
                //kita hitung dulu jumlah urutan atau max dimana
                $urutanTerakhir = TahapRekrutmen::where('idLowongan', $idLowongan)
                ->where('status', 1)->max('urutan') ?? 0;
                $tahapan->update([
                    'status' =>1,
                    //jadinya nanti dia di urutan terakhir
                    'urutan' =>$urutanTerakhir + 1
                ]);

            }
        });

        //ini aku kirim pakai json aja supaya enak gantinya
        return response()->json([
            'message' => $request->status == 1  ?
            'Tahap berhasil diaktifkan' :
            'Tahap ini berhasil dinonaktifkan'
        ]);
    }

    //ini buat update di modal nanti gak usah pakai edit kirim by data-id aja
    public function update(Request $request, string $id)
    {
        //kita harus hitung jumlah tahapan yang aktif supaya nanti gak ada yang bolong
        // $totalAktif = TahapRekrutmen::where('status', 1)->count();
        $tahapan = TahapRekrutmen::findOrfail($id);
        $idLowongan = $tahapan->idLowongan;

        if($this->batasPendaftaran($idLowongan)){
            return response()->json([
                'message' => 'Progress Masing-Masing kandidat sudah dimulai, Proses edit tidak bisa'
            ], 422);
        }

        $sudahDipakai = $this->tahapanSudahterpakai($id);

        if($sudahDipakai){
            $request->validate([
                'name' => 'required|string',
                'tipe_tahap' => 'required|string'
            ],[
                'required' => 'Bagian :attribute wajib diisi.',
                'string' => 'Bagian :attribute harus dalam bentuk string.',
            ],[
                'name' => 'nama Tahapan',
                'tipe_tahap' => 'Tipe tahapan',
            ]);

            $tahapan->update([
                'name' => $request->name,
                'tipe_tahap' => $request->tipe_tahap
            ]);
            
            return response()->json([
                'message' => 'Tahapan sudah dipakai, urutan tidak bisa diubah'
            ]);
        }

        $totalAktif = TahapRekrutmen::where('idLowongan', $idLowongan)
                    ->where('status', 1)
                    ->count();
        // $totalAktif = max(1,$totalAktif);

        $request->validate([
            'name' => 'required|string',
            //cuman bisa update sampai batas jumlahnya jadi gak ada yang input misalny jumlahnya 11 ubah sampai 12
            'urutan' => 'required|integer|min:1|max: '. $totalAktif,
            'tipe_tahap' => 'required|string'
        ],[
            'required' => 'Bagian :attribute wajib diisi.',
            'idLowongan.exists' =>  'idLowongan wajib ada.',
            'string' => 'Bagian :attribute harus dalam bentuk string.',
            'urutan.max' => 'Urutan sudah melebihi.',
            'urutan.min' => 'Urutan harus minimal 1',
            'integer' => 'Bagian :attribute harus dalam bentuk angka'
        ],[
            'name' => 'nama Tahapan',
            'tipe_tahap' => 'Tipe tahapan',
            'urutan' => 'urutan tahapan'
        ]);
        
        $urutanlama = $tahapan-> urutan;
        $urutanBaru = $request->urutan;
        
        //ini buat ngecek ada perubahan pas input
        if($urutanBaru != $urutanlama){
            $tahapanDipakai = TahapRekrutmen::where('idLowongan', $idLowongan)
                        ->where('status',1)
                        ->whereHas('progressTahapanRekrutmen')
                        ->pluck('urutan');

            foreach($tahapanDipakai as $urutanDipakai){
                    if (($urutanBaru < $urutanlama && $urutanDipakai >= $urutanBaru && $urutanDipakai < $urutanlama)
                    || ($urutanBaru > $urutanlama && $urutanDipakai <= $urutanBaru && $urutanDipakai > $urutanlama)){
                        return response()->json([
                            'errors' => [
                                'urutan' => ['Tidak bisa ubah urutan, karena tahapan pada urutan tersebut sudah dipakai']
                            ]
                    ],422);
                }
            }
        }
        //pakai db transaction karena banyak upadate dan lainnya kalau pakai ini lebih safety
        //jadi perubahannya gak setengah setengah
        DB::transaction(function () use ($tahapan, $request, $idLowongan) {

            $urutanlama = $tahapan-> urutan;
            $urutanBaru = $request->urutan;

            $tahapLain = TahapRekrutmen::where('idLowongan', $idLowongan)
                ->where('status', 1)
                ->get();
            //logikanya adalah kita bakal set id itu dengan urutan baru
            //jadi urutan baru misalnya 1 yang lama kan 3-1 -> 1 dan 2
            //maka yang ada di urutan itu bakal naik jumlah urutannya
            if($urutanBaru < $urutanlama){
                foreach($tahapLain as $t){
                    if($t->urutan >= $urutanBaru && $t->urutan < $urutanlama){
                        $t->increment('urutan');
                    }
                }
                // TahapRekrutmen::where('idLowongan', $idLowongan)
                // ->where('status', 1)
                // ->whereBetween('urutan',[$urutanBaru, $urutanlama-1])
                // ->increment('urutan');
            }elseif($urutanBaru > $urutanlama){
                foreach($tahapLain as $t){
                    if($t->urutan <= $urutanBaru && $t->urutan > $urutanlama){
                        $t->decrement('urutan');
                    }
                }
            }

            // //ini kalau misalnya 1 -> 3
            // //jadi kan urutan lama misalnya 1 makan 1+1 = 2 
            //  //maka antara 2 dan 3 urutannya bakal nambah
            // if($urutanBaru > $urutanlama){
            //     TahapRekrutmen::where('idLowongan', $idLowongan)
            //     ->where('status', 1)
            //     ->whereBetween('urutan',[$urutanlama + 1, $urutanBaru])
            //     ->decrement('urutan');
            // }

            $tahapan->update([
                'name' => $request->name,
                'urutan' => $urutanBaru,
                'tipe_tahap' =>$request->tipe_tahap
            ]);
        });
        return response()->json(['message' => 'Field berhasil di ubah']);
    }

    private function checkReady($idLowongan){
        $formulir = DB::table('konten_formulir')
                    ->where('idLowongan', $idLowongan)
                    ->where('status', 1)
                    ->count();
        $tahapan = DB::table('tahap_rekrutmen')
                   ->where('idLowongan',$idLowongan)
                   ->where('status',1)
                   ->count();
        if($formulir > 0 && $tahapan > 0){
            DB::table('lowongan')
                ->where('id', $idLowongan)
                ->update([
                    'is_ready' => 1
                ]);
        }else{
            DB::table('lowongan')
                ->where('id', $idLowongan)
                ->update([
                    'is_ready' => 0
                ]);
        }

    }
    
    //kita dapatkan bataspendaftarannya
    private function batasPendaftaran($idLowongan){
        $lowongan = Lowongan::find($idLowongan);
        //gt -> greater than
        return now()->gt($lowongan->batasPendaftaran);
    }

    private function tahapanSudahterpakai($idTahap){
        return DB::table('progress_tahapan_kandidat')
                ->where('idTahapRekrutmen',$idTahap)
                ->exists();
    }
}
