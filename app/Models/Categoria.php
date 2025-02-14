<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'imagem', 'nome', 'descricao', 'valor', 'desconto', 'disponibilidade', 
        'ingredientes', 'id_categoria'
    ];

    public $timestamps = true;
}
