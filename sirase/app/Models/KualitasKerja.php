<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KualitasKerja extends Model
{
    protected $table = 'kualitas_kerja';

    protected $fillable = [
        'idUnit',
        'nilaiMin',
        'nilaiMax',
        'kategori',
    ];

    public function Unit(){
        return $this->belongsTo(Unit::class, 'idUnit');
    }
}
