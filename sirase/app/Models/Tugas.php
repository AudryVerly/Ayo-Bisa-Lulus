<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'idStaffUnit',
        'idUnit',
        'namaTugas',
        'deskripsi',
        'bobotNilai',
        'tenggatPengumpulan',
        'progressTugas'
    ];

    public function staffunit(){
        return $this->belongsTo(StaffUnit::class, 'idStaffUnit');
    }

    public function unit(){
        return $this->belongsTo(Unit::class,'idUnit');
    }
}
