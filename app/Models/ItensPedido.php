<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItensPedido extends Model
{
    protected $fillable = [
        'id_pedido',
        'id_cardapio',
        'quantidade',
        'valor_unitario',
        'subtotal',
    ];

    protected $casts = [
        'valor_unitario' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // Relacionamento com Cardapio
    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class, 'id_cardapio');
    }

    public $timestamps = true;
}
