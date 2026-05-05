<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKinerjaForm extends Model
{
    protected $table = 'penilaian_kinerja_form';

    protected $fillable = [
        'idMahasiswa',
        'idKriteriaKinerja',
        'idLowongan',
        'idStaffUnit',
        'nilai',
    ];

    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'idMahasiswa');
    }

    public function kriteriakinerja(){
        return $this->belongsTo(KriteriaKinerja::class, 'idKriteriaKinerja');
    }

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }

    public function staffunit(){
        return $this->belongsTo(StaffUnit::class, 'idStaffUnit');
    }
}
