<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffUnit extends Model
{
    protected $table = 'staffUnit';

    protected $fillable = ['idUser', 'idUnit', 'jabatan','status'];

    public function user(){
        return $this->belongsTo(User::class, 'idUser');
    }

    public function unit(){
        return $this->belongsTo(Unit::class, 'idUnit');
    }

    public function jadwalWawancara(){
        return $this->belongsToMany(PenjadwalanWawancara::class, 'wawancara_penilai','idStaffUnit','idJdawalWawancara')->withPivot('status');
    }
}
