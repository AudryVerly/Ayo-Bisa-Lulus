<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';

    protected $fillable = [
        'name',
        'deskripsi',
        'lokasi',
        'kontak',
        'emailUnit',
        'status'
    ];

    public function staffUnit(){
        return $this->hasMany(StaffUnit::class, 'idUnit');
    }
}
