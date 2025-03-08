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

    // Relacionamento 
    public function cardapio()
    {
        return $this->belongsTo(Cardapio::class, 'id_cardapio');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public $timestamps = true;
}
