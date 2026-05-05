<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgressTahapanKandidat extends Model
{
    protected $table = 'progress_tahapan_kandidat';

    protected $fillable = [
        'idTahapRekrutmen',
        'idPendaftaran',
        'status',
        'catatan', 
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class,'idPendaftaran');
    }

    public function tahapRekrutmen(){
        return $this->belongsTo(TahapRekrutmen::class,'idTahapRekrutmen');
    }

    public function jadwalWawancara(){
        return $this->hasMany(PenjadwalanWawancara::class, 'idProgressTahapan');
    }
}
