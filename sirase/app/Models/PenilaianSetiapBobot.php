<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianSetiapBobot extends Model
{
    protected $table = 'penilaian_setiap_bobot';

    protected $fillable = [
        'idPenilaianKandidat',
        'idBobotKriteria',
        'nilaiAwal',
        'nilaiAkhir'
    ];
}
