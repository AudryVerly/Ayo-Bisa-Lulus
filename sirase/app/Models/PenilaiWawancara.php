<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaiWawancara extends Model
{
    protected $table = "tim_penilai_wawancara";

    protected $fillable = [
        'idJadwalWawancara',
        'idTimPenilai'
    ];

    public function jadwalWawancara(){
        return $this->belongsTo(PenjadwalanWawancara::class,'idJadwalWawancara',);
    }

    public function timPenilai(){
        return $this->belongsTo(timPenilai::class,'idTimPenilai',);
    }
}
