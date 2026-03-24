<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotKriteria extends Model
{
    protected $table = "bobot_kriteria";

    protected $fillable= ['idUnit','idKriteria','nilaiBobot'];

    public function unit(){
        return $this->belongsTo(Unit::class, 'idUnit');
    }

    public function kriteria(){
        return $this->belongsTo(Kriteria::class, 'idKriteria');
    }
}
