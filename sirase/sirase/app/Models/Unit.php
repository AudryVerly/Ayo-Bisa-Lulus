<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = [
        'name',
        'deskripsi',
        'lokasi',
        'kontak',
        'emailUnit',
        'status'
    ];

    public function staffUnit(){
        return $this->hasMany(StaffUnit::class, 'idUnit');
    }

    public function lowongan(){
        return $this->hasMany(Lowongan::class, 'idUnit');
    }

    public function bobotKriteria(){
        return $this->hasMany(BobotKriteria::class, 'idUnit');
    }

    public function pairwise(){
        return $this->hasMany(PairwiseComparison::class, 'idUnit');
    }

    public function kualitasKerja(){
        return $this->hasMany(KualitasKerja::class, 'idUnit');
    }

    public function tugas(){
        return $this->hasMany(Tugas::class, 'idUnit');
    }

    public function kriteriakinerja(){
        return $this->hasMany(KriteriaKinerja::class, 'idUnit');
    }
}
