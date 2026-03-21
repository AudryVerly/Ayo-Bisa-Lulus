<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WawancaraPenilai extends Model
{
    protected $table = 'wawancara_penilai';

    protected $fillable =[
        'idJadwalWawancara',
        'idStaffUnit',
        'status',
        'token'
    ];

    public function jadwalWawancara(){
        return $this->belongsTo(PenilaiWawancara::class, 'idJadwalWawancara');
    }

    public function staffUnit(){
        return $this->belongsTo(StaffUnit::class,'idStaffUnit');
    }
}
