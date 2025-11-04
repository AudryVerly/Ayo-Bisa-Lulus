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
}
