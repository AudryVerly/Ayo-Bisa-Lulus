<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formulir extends Model
{
    protected $table = "konten_formulir";

    protected $fillable = ['idLowongan','namaField','tipeField','opsi_field','help_text','required','status'];

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }

    public function berkasPendaftaran(){
        return $this->hasMany(BerkasPendaftaran::class, 'idKontenFormulir');
    }

    public function jawabanFormulir(){
        return $this->hasMany(JawabanFormulir::class, 'idKontenFormulir');
    }
}
