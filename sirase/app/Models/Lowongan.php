<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lowongan extends Model
{
    protected $table= "lowongan";

    protected $fillable = ['idUnit',
                            'judulLowongan',
                            'deskripsi',
                            'kualifikasi',
                            'posisiLowongan',
                            'durasiKerja',
                            'awalPendaftaran',
                            'batasPendaftaran',
                            'mulaiKerja',
                            'akhirKerja',
                            'status'];
    
    public function unit(){
        return $this->belongsTo(Unit::class, 'idUnit');
    }

    public function tahapRekrutmen(){
        return $this->hasMany(tahapRekrutmen::class,'idLowongan');
    }

    public function kontenFormulir(){
        return $this->hasMany(formulir::class, 'idLowongan');
    }

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class, 'idLowongan');
    }
}
