<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = "kriteria";

    protected $fillable = [
        'namaKriteria',
        'status'
    ];

    public function bobotKriteria(){
        return $this->hasMany(BobotKriteria::class, 'idKriteria');
    }

    public function pairwise(){
        return $this->hasMany(PairwiseComparison::class, 'kriteriaAwal')
               ->orWhere('kriteriaPembanding', $this->id);
    }

    public function kriteriakinerja(){
        return $this->hasMany(KriteriaKinerja::class, 'idKriteria');
    }
}
