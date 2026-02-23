<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahapRekrutmen extends Model
{
    protected $table = 'tahap_rekrutmen';

    protected $fillable = [
        'idLowongan',
        'name',
        'urutan',
        'status'
    ];

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }

    public function progressTahapanRekrutmen(){
        return $this->hasMany(ProgressTahapanKandidat::class, 'idTahapRekrutmen');
    }
}
