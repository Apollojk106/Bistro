<?php

namespace App\Http\Controllers;
use App\Models\Categoria;

use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function GetCategorias()
    {
        return Categoria::pluck('nome');
    }
}
