<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Home()
    {
        return view('admin.Dashboard');    
    }

    //User



    //Admin
    public function Dashboard()
    {
        $pratosVendidos = [
            'Segunda' => 120,
            'Terça'   => 150,
            'Quarta'  => 130,
            'Quinta'  => 170,
            'Sexta'   => 200,
            'Sábado'  => 250,
            'Domingo' => 180,
        ];
    
        return view('admin.Dashboard', compact('pratosVendidos')); 
    }

    public function Cardapio()
    {
        return view('admin.Cardapio');    
    }

    public function GetItemCardapio()
    {
        return view('admin.ItemCardapio');    
    }

    public function PostItemCardapio(Request $request)
    {
        return view('admin.ItemCardapio');    
    }

    public function Configuracao()
    {
        return view('admin.Configuracao');    
    }

    public function Historico()
    {
        return view('admin.Historico');    
    }

    public function Pedido()
    {
        return view('admin.Pedido');    
    }


}
