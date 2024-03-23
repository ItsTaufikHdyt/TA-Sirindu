<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZScore extends Model
{
    use HasFactory;
    protected $table = 'z_score';
    protected $guarded = [];
}
