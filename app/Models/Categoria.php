<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'nivel'
    ];

    public $timestamps = true;
}
