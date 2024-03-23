<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTabel extends Model
{
    use HasFactory;
    protected $table = 'jenis_tabel';
    protected $guarded = [];
}
