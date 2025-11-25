<?php

namespace App\Http\Controllers;

use App\Models\Lowongan;
use App\Models\StaffUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class lowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Ini untuk mencari idUnit dari user yang login 
        //ini pakai pluck soalnya relasinya one to many 
        $idUnit = Auth::user()->staffUnit()->pluck('idUnit')->first();
        $lowonganbuka = Lowongan::where('idUnit', $idUnit)->get();

        $lowongan = Lowongan::with(['unit'])
                    ->where('idUnit', $idUnit)
                    ->orderBy('status','desc')
                   ->get();
        return view('lowongan.utama', compact('lowongan'));
    }

    public function autoUpdate(){
        $lowongans = Lowongan::all();
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        foreach($lowongans as $lowongan){
            $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
            $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

            if($today >= $awalPendaftaran && $today <= $batasPendaftaran){
                if($lowongan->status == 0){
                    $lowongan->update(['status' =>1]);
                }
            }elseif($today > $batasPendaftaran || $awalPendaftaran > $today){
                if($lowongan->status == 1){
                    $lowongan->update(['status' =>0]);
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
                'judulLowongan'   => 'required|string|max:255',
                'deskripsi'       => 'required|string',
                'kualifikasi'     => 'required|string',
                'posisiLowongan'  => 'required|string|max:255',
                'durasiKerja'     => 'required|integer|min:1',
                'awalPendaftaran' => 'required|date',
                'batasPendaftaran'=> 'required|date|after_or_equal:awalPendaftaran',
                'mulaiKerja'      => 'required|date|after_or_equal:batasPendaftaran',
                'akhirKerja'      => 'required|date|after_or_equal:mulaiKerja',
            ]);

            $request['kualifikasi'] = trim(preg_replace('/\r\n|\r|\n/', "\n", $request['kualifikasi']));

            Lowongan::create([
                'idUnit' => $idUnit,
                'judulLowongan'   => $request->judulLowongan,
                'deskripsi'       => $request->deskripsi,
                'kualifikasi'     => $request->kualifikasi,
                'posisiLowongan'  => $request->posisiLowongan,
                'durasiKerja'     => $request->durasiKerja,
                'awalPendaftaran' => $request->awalPendaftaran,
                'batasPendaftaran'=> $request->batasPendaftaran,
                'mulaiKerja'      => $request->mulaiKerja,
                'akhirKerja'      => $request->akhirKerja,
            ]);
            return redirect()->route('lowongans.index')->with('success', 'Lowongan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        return view('lowongan.edit',compact('lowongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $lowongan = Lowongan::findOrFail($id);
        $request->validate([
            'judulLowongan'   => 'required|string|max:255',
            'deskripsi'       => 'required|string',
            'kualifikasi'     => 'required|string',
            'posisiLowongan'  => 'required|string|max:255',
            'durasiKerja'     => 'required|integer|min:1',
            'awalPendaftaran' => 'required|date',
            'batasPendaftaran'=> 'required|date|after_or_equal:awalPendaftaran',
            'mulaiKerja'      => 'required|date|after_or_equal:batasPendaftaran',
            'akhirKerja'      => 'required|date|after_or_equal:mulaiKerja',
        ]);

            //ini supaya dia bisa memsiahkan spasi, whitespace dan koma
        $request['kualifikasi'] = trim(preg_replace('/\r\n|\r|\n/', "\n", $request['kualifikasi']));

        $lowongan->update([
            'judulLowongan'   => $request->judulLowongan,
            'deskripsi'       => $request->deskripsi,
            'kualifikasi'     => $request->kualifikasi,
            'posisiLowongan'  => $request->posisiLowongan,
            'durasiKerja'     => $request->durasiKerja,
            'awalPendaftaran' => $request->awalPendaftaran,
            'batasPendaftaran'=> $request->batasPendaftaran,
            'mulaiKerja'      => $request->mulaiKerja,
            'akhirKerja'      => $request->akhirKerja,
        ]);
        return redirect()->route('lowongans.index')->with('success', 'Informasi Lowongan berhasil diperbarui');

    }

    public function publish(string $id){
    
        $lowongan = Lowongan::findOrfail($id);
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
        $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

        if($today < $awalPendaftaran){
            return back()->with('error', 'Lowongan tidak bisa di publish karena belum waktunya.');
        }

        if($today > $batasPendaftaran){
            return back()->with('error', 'Lowongan tidak bisa di publish karena sudah melewati batas pendaftaran .');
        }
        
        if($today >= $awalPendaftaran && $today <= $batasPendaftaran){
            if($lowongan->status == 0){
                    $lowongan->update(['status' =>1]);
            }
            return back()->with('success', 'Lowongan berhasil di publish');
        }


    }

    public function unpublish(string $id){
        $lowongan = Lowongan::findOrfail($id);
        $today = Carbon::today('Asia/Jakarta')->toDateString();

        $awalPendaftaran = Carbon::parse($lowongan->awalPendaftaran)->toDateString();
        $batasPendaftaran = Carbon::parse($lowongan->batasPendaftaran)->toDateString();

        //ini kalau belum waktunya
        if($today < $awalPendaftaran){
            return back()->with('error', 'Lowongan belum bisa di unpublish karena belum waktunya');
        }

        //ini kalau masih kebuka jadinya bisa di unpublish
        if($today > $batasPendaftaran){
            if($lowongan->status == 1){
                    $lowongan->update(['status' =>0]);
            }
            return back()->with('success', 'Lowongan berhasil di unpublish (masa pendaftaran sudah lewat).');
        }

        // ini dalam keadaan misalnya admin mau unpublish
        if($today >= $awalPendaftaran && $today <= $batasPendaftaran){
            if($lowongan->status == 1){
                    $lowongan->update(['status' =>0]);
            }
            return back()->with('success', 'Lowongan berhasil di unpublish');
        }

        return back()->with('error', 'Lowongan tidak berhasil di unpublish');
    }
}
