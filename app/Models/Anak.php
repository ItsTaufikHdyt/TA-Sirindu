<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class Anak extends Model
{
    use HasFactory, Uuids;
    protected $table = 'anak';
    protected $guarded = [];

    public function kec()
    {
        return $this->hasMany(Kecamatan::class,'id','id_kec');
    }
    public function kel()
    {
        return $this->hasMany(Kelurahan::class,'id','id_kel');
    }
    public function dataAnak()
    {
        return $this->hasMany(DataAnak::class,'id_anak','id');
    }
}
