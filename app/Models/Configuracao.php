<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'Configuracoes';

    protected $fillable = [
        'nome',
        'status',
        'valores1',
        'valores2',
        'conector',
        'type',
    ];

    public $timestamps = true;
}
