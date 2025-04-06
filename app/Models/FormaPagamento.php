<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'Formas_de_pagamento';

    protected $fillable = [
        'id',
        'nome',
        'taxa',
        'created_at',
        'deleted_at',
    ];

    public function getOpcoesCartao()
    {
        return self::whereNull('deleted_at')
                  ->whereNotIn('nome', ['Pix', 'Dinheiro', 'Cartão'])
                  ->get();
    }

    public function itensPedidos()
    {
        return $this->hasMany(ItensPedido::class, 'id_forma_pagamento'); // Adjust the foreign key as needed
    }

    public function pedidos()
    {
        return $this->hasMany(Pedido::class, 'id_forma_pagamento');
    }

    protected $casts = [
        'taxa' => 'decimal:2',
    ];

    public $timestamps = true;
}