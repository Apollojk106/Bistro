<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'nivel'
    ];

    public function cardapios()
    {
        return $this->hasMany(Cardapio::class, 'id_categoria');
    }

    public $timestamps = true;
}
