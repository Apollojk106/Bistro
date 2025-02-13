<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'Configuracoes';

    protected $fillable = [
        'nome',
        'status',
        'valores',
    ];

    public $timestamps = true;
}
