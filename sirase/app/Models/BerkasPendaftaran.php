<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BerkasPendaftaran extends Model
{
    protected $table = 'berkas_pendaftaran';

    protected $fillable = [
        'idPendaftaran',
        'idKontenFormulir',
        'namaFile',
        'filePath',
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class,'idPendaftaran');
    }

    public function kontenFormulir(){
        return $this->belongsTo(formulir::class,'idKontenFormulir');
    }
}
