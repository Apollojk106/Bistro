<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anotacao extends Model
{
    use HasFactory;

    protected $table = 'anotacoes';

    protected $fillable = [
        'cliente_id',
        'conteudo',
    ];

    // Relação inversa com Cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'cliente_id');
    }
}
