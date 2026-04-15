<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TotalPenilaianKinerja extends Model
{
    protected $table = 'total_penilian_kinerja';

    protected $fillable = [
        'idPendaftaran',
        'totalNilai',
        'kategori'
    ];

    public function pendaftaran(){
        return $this->belongsTo(Pendaftaran::class, 'idPendaftaran');
    }
}
