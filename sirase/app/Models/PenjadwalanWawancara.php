<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenjadwalanWawancara extends Model
{
    protected $table = 'jadwal_wawancara';

    protected $fillable = [
        'idProgressTahapan',
        'idPendaftaran',
        'tanggal_wawancara',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'link_wawancara',
        'keterangan',
        'status'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class,'idPendaftaran');
    }

    public function progressTahapan(){
        return $this->belongsTo(ProgressTahapanKandidat::class,'idProgressTahapan');
    }

    public function timPenilai(){
        return $this->belongsToMany(timPenilai::class,'tim_penilai_wawancara','idJadwalWawancara','idTimPenilai');
    }
}
