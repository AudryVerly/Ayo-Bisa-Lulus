<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotKriteria extends Model
{
    protected $table = 'bobot_kriteria';

    protected $fillable = ['idUnit', 'idKriteria', 'nilaiBobot', 'is_active'];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'idUnit');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'idKriteria');
    }

    public function penilaianKandidat()
    {
        return $this->belongsToMany(
            PenilaianKandidat::class,
            'penilaian_setiap_bobot',
            'idBobotKriteria',
            'idPenilaianKandidat'
        )
            ->using(PenilaianSetiapBobot::class)
            ->withPivot('nilaiAwal','nilaiAkhir');
    }
}
