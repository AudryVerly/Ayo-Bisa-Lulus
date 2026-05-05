<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PairwiseComparison extends Model
{
    protected $table = 'pairwise_comparison';

    protected $fillable = [
        'idUnit',
        'kriteriaAwal',
        'kriteriaPembanding',
        'nilai'
    ];

    public function unit (){
        return $this->belongsTo(Unit::class, 'idUnit');
    }

    public function kriteriaAwal(){
        return $this->belongsTo(Kriteria::class, 'kriteriaAwal');
    }

    public function kriteriaPembanding(){
        return $this->belongsTo(Kriteria::class, 'kriteriaPembanding');
    }
}
