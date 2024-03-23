<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataAnak extends Model
{
    use HasFactory;
    protected $table = 'data_anak';
    protected $guarded = [];

    public function anak()
    {
        return $this->belongsTo(Anak::class);
    }
}
