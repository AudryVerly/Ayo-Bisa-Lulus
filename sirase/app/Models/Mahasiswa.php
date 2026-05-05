<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';

    protected $fillable = ['idUser','nrp','fakultas','jurusan','tahunMasuk','noTelepon','status'];

    public function user(){
        return $this->belongsTo(User::class, 'idUser');
    }

    public function pendaftaran(){
        return $this->hasMany(Pendaftaran::class, 'idMahasiswa');
    }

    public function tugasMahasiswa(){
        return $this->belongsToMany(
           Tugas::class,
           'tugas_mahasiswa',
           'idMahasiswa',
           'idTugas' 
        )
        ->using(TugasMahasiswa::class)
        ->withPivot('statusPengumpulan','file_path','catatan');
    }

    public function penilaianKinerja(){
        return $this->hasMany(PenilaianKinerja::class, 'idMahasiswa');
    }

    public function penilaianform(){
       return $this->hasMany(PenilaianKinerjaForm::class, 'idMahasiswa');
    }
}
