<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class formulir extends Model
{
    protected $table = "konten_formulir";

    protected $fillable = ['idLowongan','namaField','tipeField','opsi_Field','required','status'];

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }
}
