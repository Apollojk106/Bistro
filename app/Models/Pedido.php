<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'email',
        'telefone',
        'rua',
        'bairro',
        'numero_residencia',
        'complemento',
        'categoria_pedido',
        'status_pedido',
        'opcao_entrega',
        'horario',
        'id_forma_pagamento',
        'descricao',
        'frete',
        'valor_total',
        'valor_taxa',
        'updated_at'
    ];

    public $timestamps = true;
}
