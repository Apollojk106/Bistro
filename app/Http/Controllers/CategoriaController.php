<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function GetCategorias()
    {   
        $Categorias = [
            'Primeira' => $this->GetPrimeira(),
            'Segunda' => $this->GetSegunda(),
            'Terceira' => $this->GetTerceira()
        ];

        return $Categorias;
    }

    public function GetPrimeira()
    {
        return Categoria::where('nivel','Primaria')
        ->get();
    }

    public function GetSegunda()
    {
        return Categoria::where('nivel','Secundaria')
        ->get();
    }

    public function GetTerceira()
    {
        return Categoria::where('nivel','Terciaria')
        ->get();
    }

}
