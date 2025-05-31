<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes'; 

    protected $fillable = [
        'nome',
        'numero',
        'email',
    ];

    // Relação 1 para muitos com Anotacoes
    public function anotacoes()
    {
        return $this->hasMany(Anotacao::class, 'cliente_id');
    }
}
