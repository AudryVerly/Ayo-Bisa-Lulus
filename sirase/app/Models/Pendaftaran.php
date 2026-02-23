<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendaftaran extends Model
{
    protected $table = 'pendaftaran';

    protected $fillable = [
        'idMahasiswa',
        'idLowongan',
        'tanggal_daftar',
        'statusPendaftaran',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'idMahasiswa');
    }

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }

    public function berkasPendaftaran(){
        return $this->hasMany(BerkasPendaftaran::class, 'idPendaftaran');
    }

    public function jawabanFormulir(){
        return $this->hasMany(JawabanFormulir::class, 'idPendaftaran');
    }

    public function progressTahapanRekrutmen(){
        return $this->hasMany(ProgressTahapanKandidat::class, 'idPendaftaran');
    }
}
