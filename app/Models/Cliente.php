<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; // Nome da tabela no banco de dados

    protected $fillable = [
        'nome',
        'numero',
        'email',
        'anotacoes',
    ];
}
