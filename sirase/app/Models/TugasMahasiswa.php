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
        'tenggatRevisi',
        'catatanRevisi',
        'statusPengumpulan',
        'file_path',
        'progressTugas'
    ];
}
