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
    public $timestamps = false;
}
