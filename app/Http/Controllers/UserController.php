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
        return view('admin.Dashboard');    
    }

    public function Cardapio()
    {
        return view('admin.Cardapio');    
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
