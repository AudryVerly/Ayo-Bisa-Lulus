<?php

namespace App\Http\Controllers;

use App\Models\BerkasPendaftaran;
use App\Models\formulir;
use App\Models\JawabanFormulir;
use App\Models\Lowongan;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class pendaftaranController extends Controller
{
    public function formulirPendaftaran(string $idLowongan){
        $lowongan = DB::table('lowongan')
                    ->where('id', $idLowongan)
                    ->where('status', 1)
                    ->first();
        if(!$lowongan){
            abort(404, 'Lowongan tidak ditemukan atau tidak aktif');
        }

        $idMahasiswa = auth()->user()->mahasiswa->id;

        $sudahDaftar = Pendaftaran::where('idMahasiswa', $idMahasiswa)
                           ->where('idLowongan', $idLowongan)
                           ->exists();
        if($sudahDaftar){
           return redirect()
            ->route('mahasiswa.dashboard')
            ->with('error', 'Kamu sudah mendaftar di lowongan ini.');
        }

        $fieldFormulir = DB::table('konten_formulir')
                         ->where('idLowongan', $idLowongan)
                         ->where('status', 1)
                         ->orderBy('id')
                         ->get();
        if($fieldFormulir->count() === 0){
            abort(404, 'Formulir belum tersedia');
        }

        return view('pendaftaran.formulir', compact('lowongan', 'fieldFormulir','sudahDaftar'));

    }

    public function inputPendaftaran(Request $request, string $idLowongan){
        //kita pakai dbtransaction karena ada lebih dari 1 proses yang akan dilakukan
        // try{
            $idMahasiswa = auth()->user()->mahasiswa->id;

            $sudahDaftar = Pendaftaran::where('idMahasiswa', $idMahasiswa)
                           ->where('idLowongan', $idLowongan)
                           ->exists();
            if($sudahDaftar){
                return back()->with('error', 'Kamu sudah pernah mendaftara di lowongan ini.');
            }

            DB::transaction(function() use ($request, $idLowongan, $idMahasiswa){
               //field formulir akan diambil semua, sesuai lowongan itu
               $fields = formulir::where('idLowongan', $idLowongan)->get(); 

               //cek required untuk semua field
               //di buat array karena banyak list
               $rules= [];
               $attributes = [];
               foreach($fields as $field){
                    //ini pakai field. karena dia akan ubah dari [] -> .
                    $inputFormulir = "field." . $field->id;
                    //ditambah 
                    $attributes[$inputFormulir] = $field->namaField;

                    if($field->tipeField === 'file'){
                        //ini supaya tipe filenya bisa pdf,jpg,jpeg atau png dengan maksimal 10 MB
                        $rules[$inputFormulir] = ($field->required ? 'required|' : '') . 'file|mimes:pdf,jpg,jpeg|max:10240';
                    }else{
                        $rules[$inputFormulir] = $field->required ? 'required' : 'nullable';
                    }
                }

                //validasi semua input
                $request->validate($rules,[
                    'required' => ':attribute wajib diisi.',
                    'file.max' => 'Ukuran file maksimal 10 MB.',
                    'file.mimes' => 'File harus pdf, jpg, atau jpeg.'
                ], $attributes);
                
                //lalu input ke pendaftaran
                $pendaftaran = Pendaftaran::create([
                    'idMahasiswa' => $idMahasiswa,
                    'idLowongan' => $idLowongan,
                    'tanggal_daftar' => now(),
                    'statusPendaftaran' => 'terdaftar',
                ]);

                //karena isi field banyak akan di looping
                foreach($fields as $field){
                    $idField = $field->id;
                    $inputFormulir = "field.$idField";

                    //ini khusus kalau tipe fieldnya == file
                    if($field->tipeField === 'file'){
                        if($request->hasFile($inputFormulir)){
                            $file = $request->file($inputFormulir);

                            //ini unntuk simpan filenya
                            $extension = $file->getClientOriginalExtension();
                            $namaField = str_replace(' ','_', $field->namaField);
                            $namaPendaftar = str_replace(' ','_', auth()->user()->name);

                            $namaFileBaru = $namaField . '_' . $namaPendaftar . '.' .$extension; 

                            // simpan file ke storage/app/public/berkas_pendaftaran/{id}
                            $path = $file->storeAs(
                                'berkas_pendaftaran/'. $pendaftaran->id, $namaFileBaru, 'public'
                            );

                            BerkasPendaftaran::create([
                                'idPendaftaran' => $pendaftaran->id,
                                'idKontenFormulir' => $idField,
                                //ini 
                                // 'namaFile' => $file->getClientOriginalName(),
                                'namaFile' => $namaFileBaru,
                                'filePath' => $path,
                            ]);
                        }
                    }else{
                        $jawaban = $request->input($inputFormulir);

                        if(is_array($jawaban)){
                            //ini buat kalau misalnya dia adalah checkbox jadinya kana disimpan
                            //dalam bentuk koma
                            $jawaban = implode(',', $jawaban);
                        }

                        if($jawaban === null || $jawaban === ''){
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
        // }catch(\Exception $e){
        //     return back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        // }
    }

}
