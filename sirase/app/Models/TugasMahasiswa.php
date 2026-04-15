<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasMahasiswa extends Model
{
    protected $table = 'tugas_mahasiswa';

    protected $fillable = [
        'idMahasiswa',
        'idTugas',
        'tanggalPengumpulan',
        'statusPengumpulan',
        'file_path',
        'catatan'
    ];

    public function tugasMahasiswa(){
        return $this->belongsToMany(
           Tugas::class,
           'tugas_mahasiswa',
           'idTugas',
           'idMahasiswa'
        )
        ->using(TugasMahasiswa::class)
        ->withPivot('statusPengumpulan','file_path','catatan');
    }
}
