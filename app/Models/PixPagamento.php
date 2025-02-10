<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PixPagamento extends Model
{
    protected $fillable = [
        'nome',
        'telefone',
        'email',
        'id_pedido',
        'valor_total',
        'pix_key',
        'pix_code',
        'status',
    ];
}
