<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KriteriaKinerja extends Model
{
    protected $table = 'kriteria_kinerja';

    protected $fillable =[
        'idKriteria',
        'idUnit',
        'nama',
        'status'
    ];

    public function kriteria(){
        return $this->belongsTo(Kriteria::class,'idKriteria');
    }

    public function Unit(){
        return $this->belongsTo(Unit::class,'idUnit');
    }

    public function penilaianform(){
       return $this->hasMany(PenilaianKinerjaForm::class, 'idKriteriaKinerja');
    }
}
