<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuzzy extends Model
{
    use HasFactory;

    protected $table = 'fuzzy';
    protected $guarded = [];
    public $timestamps = false;
}
