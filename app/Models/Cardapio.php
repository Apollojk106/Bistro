<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cardapio extends Model
{
    protected $fillable = [
        'id',
        'imagem',
        'nome',
        'descricao',
        'valor',
        'desconto',
        'disponibilidade',
        'status',
        'ingredientes',
        'id_categoria',
    ];

    public function itensPedidos()
    {
        return $this->hasMany(ItensPedido::class, 'id_cardapio');
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'id_categoria');
    }

    public $timestamps = true;
}
