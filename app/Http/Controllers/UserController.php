<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ItensPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PixController;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Esse controler é somente para a rota GET

    //Login
    public function Perfil()
    {
        return view('user.Perfil');    
    }

    public function Login()
    {
        return view('user.Login');    
    }

    public function Cadastro()
    {
        return view('user.Cadastro');    
    }

    //User
    public function UserCardapio()
    {
        return view('user.Cardapio');    
    }

    public function Carrinho()
    {
        return view('user.Carrinho');    
    }

    public function PagamentoPix()
    {
        return view('user.PagamentoPix');    
    }

    public function OpcaoPedido()
    {
        return view('user.OpcaoPedido');    
    }

    public function FormaPagamento()
    {
        return view('user.FormaDePagamento');    
    }

    public function Localizacao()
    {
        return view('user.Localizacao');    
    }

    public function MeuPedido()
    {
        return view('user.MeuPedido');    
    }

    public function Selecao()
    {
        return view('user.Selecao');    
    }

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

    public function SaveItem()
    {
        return view('admin.Cardapio');    
    }


    public function PostItemCardapio(Request $request)
    {
        return view('admin.ItemCardapio');    
    }

    public function Configuracao()
    {
        return view('admin.Configuracao');    
    }

    

    public function Pedido()
    {
        return view('admin.Pedido', );    
    }


}
