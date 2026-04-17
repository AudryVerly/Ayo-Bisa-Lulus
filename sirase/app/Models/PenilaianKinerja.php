<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKinerja extends Model
{
    protected $table = "penilaian_kinerja";

    protected $fillable = [
        'idTugas',
        'idMahasiswa',
        'nilaiAwal',
        'penalti',
        'nilaiAkhir',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'idMahasiswa');
    }

    public function tugas(){
        return $this->belongsTo(Tugas::class, 'idTugas');
    }
}
