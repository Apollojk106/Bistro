<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    protected $table = 'Formas_de_pagamento';

    protected $fillable = [
        'nome',
        'taxa',
    ];

    protected $casts = [
        'taxa' => 'decimal:2',
    ];

    public $timestamps = true;
}
