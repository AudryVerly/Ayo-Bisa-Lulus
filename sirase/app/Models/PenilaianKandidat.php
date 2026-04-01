<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianKandidat extends Model
{
    protected $table = 'penilaian_kandidat';

    protected $fillable = [
        'idPendaftaran',
        'idWawanacaraPenilai',
        'nilaiFinal',
        'catatan',
        'tanggal_menilai',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(Pendaftaran::class, 'idPendaftaran');
    }

    public function wawancaraPenilai()
    {
        return $this->belongsTo(WawancaraPenilai::class, 'idWawancaraPenilai');
    }

    public function bobotKriteria()
    {
        return $this->belongsToMany(
            BobotKriteria::class,
            'penilaian_setiap_bobot',
            'idPenilaianKandidat',
            'idBobotKriteria'
        )
            ->using(PenilaianSetiapBobot::class)
            ->withPivot('nilaiAwal','nilaiAkhir');
    }
}
