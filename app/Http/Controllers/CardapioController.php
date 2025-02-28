<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;

use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function Cardapio()
    {
        $Items = Cardapio::take(10)
        ->get();
        
        return $this->GetCardapio($Items);
    }

    public function CardapioFiltro()
    {
        $Items = null;

        return $this->GetCardapio($Items);
    }

    public function GetCardapio($Items) 
    {
        $Categorias = $this->TodasCategorias();

        return view('admin.Cardapio', compact('Categorias', 'Items'));
    }

    public function TodasCategorias()
    {
        return Categoria::pluck('nome');
    }
}
