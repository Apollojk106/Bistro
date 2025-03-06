<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ItensPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PixController;
use App\Models\Cardapio;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //Esse controler é somente para a rota view

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

    public function Item()
    {
        return view('user.Item');    
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

    public function Sacola()
    {
        return view('user.Sacola');    
    }

    public function VerPedido()
    {
        return view('user.VerPedido');
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
        $Categorias = Categoria::pluck('nome', 'id');

        return view('admin.ItemCardapio', compact('Categorias'));    
    }

    public function SaveItem(Request $request)
    {
        $request->validate([
            'Nome' => 'required|string|max:255',
            'Imagem' => 'required|string|max:255',
            'Descricao' => 'required|string',
            'Valor' => 'required|numeric',
            'categoria' => 'required|string', // Categoria pode ser nova ou existente
            'Igredientes' => 'required|string',
            'Desconto' => 'nullable|numeric',
            'Disponibilidade' => 'required|string',
        ]);

        $Cardapio = new CardapioController();

        $Cardapio->SaveItem($request);

        return  $Cardapio->IndexCardapio();    
    }


    public function PostItemCardapio(Request $request)
    {
        dd($request);
        
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
