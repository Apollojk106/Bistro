<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ItensPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PixController;



use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use App\Models\Configuracao;
use App\Models\FormaPagamento;
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
    public function Dashboard(
        $pratosVendidos, 
        $pedidosAgendados,
        $pedidosNormais,
        $valorTotalAgendados,
        $valorTotalNormais,
        $categoriasMaisPedidas,
        $itensMaisPedidos,
        $top3dias,
        )
    {
        /*dd(
            $pratosVendidos, 
            $pedidosAgendados,
            $pedidosNormais,
            $valorTotalAgendados,
            $valorTotalNormais,
            $categoriasMaisPedidas,
            $itensMaisPedidos,
            $top3dias,
            );*/

        return view('admin.Dashboard', 
            compact(
                'pratosVendidos',
                'pedidosAgendados',
                'pedidosNormais',
                'valorTotalAgendados',
                'valorTotalNormais',
                'categoriasMaisPedidas',
                'itensMaisPedidos',
                'top3dias',
            ));
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

    public function EditItemCardapio(Request $request)
    {
        $Item = Cardapio::where('id', $request->Id)
            ->first();

        $Categorias = Categoria::pluck('nome', 'id');

        $Item->categoria = Categoria::where('id', $Item->id_categoria)
            ->first()
            ->nome ?? null;

        return view('admin.ItemCardapio', compact('Categorias', 'Item'));
    }

    public function SaveItem(CardapioRequest $request)
    {
        $Cardapio = new CardapioController();

        $Cardapio->SaveItem($request);

        return  $Cardapio->IndexCardapio();
    }

    public function Configuracao()
    {
        $FormaPagamentos = new FormaPagamentoController();
        $Categorias = new CategoriaController();
        $Configuracoes = new ConfiguracaoController();

        $FormaPagamentos = $FormaPagamentos->GetPagamento();
        $Categorias = $Categorias->GetCategorias();
        $Configuracoes =  $Configuracoes->GetConfiguracao();

        return view('admin.Configuracao', compact('FormaPagamentos','Categorias','Configuracoes'));
    }

    public function Pedido()
    {
        return view('admin.Pedido',);
    }
}
