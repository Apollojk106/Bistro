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

    // Relacionamento com ItensPedido
    public function itensPedido()
    {
        return $this->hasMany(ItensPedido::class, 'id_pedido');
    }

    // Accessor para o campo 'itens'
    public function getItensAttribute()
    {
        return $this->itensPedido->map(function ($item) {
            return [
                'nome' => $item->cardapio->nome,
                'quantidade' => $item->quantidade,
                'valor_unitario' => $item->valor_unitario,
                'subtotal' => $item->subtotal,
            ];
        });
    }


    public $timestamps = true;
}
