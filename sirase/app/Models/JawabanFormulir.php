<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanFormulir extends Model
{
    protected $tbale = 'jawaban_formulir';

    protected $fillable = [
        'idPendaftaran',
        'idKontenFormulir',
        'jawaban'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class,'idPendaftaran');
    }

    public function kontenFormulir(){
        return $this->belongsTo(formulir::class,'idKontenFormulir');
    }
}
