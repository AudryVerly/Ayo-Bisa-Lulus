<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KualitasKerja extends Model
{
    protected $table = 'kualitas_kinerja';

    protected $fillable = [
        'idUnit',
        'nilaiMin',
        'nilaiMax',
        'kategori',
        'status'
    ];

    public function Unit(){
        return $this->belongsTo(Unit::class, 'idUnit');
    }
}
