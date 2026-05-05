<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class timPenilai extends Model
{
    protected $table = 'tim_penilai';

    protected $fillable = [
        'idLowongan',
        'idStaffUnit',
        'statusPenilaian',
        'isActive'

    ];

    public function lowongan(){
        return $this->belongsTo(Lowongan::class, 'idLowongan');
    }

    public function staffUnit(){
        return $this->belongsTo(StaffUnit::class, 'idStaffUnit');
    }

    public function jadwalWawancara(){
        return $this->belongsToMany(PenjadwalanWawancara::class,'tim_penilai_wawancara','idJadwalWawancara','idTimPenilai');
    }
}
