<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuracao extends Model
{
    protected $table = 'Configuracoes';

    protected $fillable = [
        'id',
        'nome',
        'status',
        'valores1',
        'valores2',
        'conector',
        'type',
    ];

    protected $casts = [
        'status' => 'boolean', // Converte automaticamente entre boolean e integer
    ];
}
