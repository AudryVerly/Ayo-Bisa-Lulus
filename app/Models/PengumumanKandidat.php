<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengumumanKandidat extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'idPendaftaran',
        'nomor_surat',
        'status',
        'file_path',
        'tanggal_publish',
        'is_publish'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class, 'idPendaftaran');
    }
}
