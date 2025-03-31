<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ItensPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PixController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use App\Models\Configuracao;
use App\Models\FormaPagamento;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function sessionData()
    {
        $sessionData = session()->all();
        dd($sessionData);
    }

    //Função de Login
    public function PostLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string|min:6', 
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->senha, $user->senha)) {
            Auth::login($user);

            return redirect()->route('User.Perfil')->with('success', 'Login realizado com sucesso!');
        } else {
            return back()->with('error', 'Credenciais inválidas. Tente novamente.');
        }
    }

    public function PostCadastro(Request $request)
    {
        // Validação dos dados
        $request->validate([
            'email' => 'required|email',
            'nome' => 'required|string|max:255',
            'telefone' => 'required|string|max:15',
            'cep' => 'required|string|max:10',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero_residencia' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:255',
            'senha' => 'required|string|min:6|confirmed',
        ]);

        $usuarioExistente = User::where('email', $request->email)->first();

        if ($usuarioExistente) {
            return redirect()->route('User.Login')->with('error', 'Já existe uma conta com esse e-mail. Faça login.');
        }

        $user = new User();
        $user->email = $request->email;
        $user->nome = $request->nome;
        $user->telefone = $request->telefone;
        $user->cep = $request->cep;
        $user->rua = $request->rua;
        $user->bairro = $request->bairro;
        $user->numero_residencia = $request->numero_residencia;
        $user->complemento = $request->complemento; // Campo complementar
        $user->senha = Hash::make($request->senha); // Criptografando a senha
        $user->salt = bin2hex(random_bytes(16)); // Gerando salt para maior segurança
        $user->save();

        Auth::login($user);

        // Redirecionar após o cadastro
        return redirect()->route('User.Perfil')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function Logout() 
    {
        Auth::logout();

        return redirect()->route('User.Login')->with('success', 'Você foi desconectado com sucesso!');
    }

    //Esse controler é somente para a rota view
    //Login
    public function Perfil()
    {
        if (!Auth::check()) {
            return redirect()->route("User.Login");
        }
        return view('user.Perfil');
    }

    public function Login()
    {
        if (Auth::check()) {
            return redirect()->route("User.Perfil");
        }
        return view('user.Login');
    }

    public function Cadastro()
    {
        if (Auth::check()) {
            return redirect()->route("User.Perfil");
        }
        return view('user.Cadastro');
    }

    //User
    public function UserCardapio()
    {
        $Cardapio = new CardapioController();
        $cardapioPorCategoria = $Cardapio->cardapioPorCategoria();

        //dd($cardapioPorCategoria);

        return view('user.Cardapio', compact('cardapioPorCategoria'));
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
        $Carrinho = new CarrinhoController();

        $Pedido = $Carrinho->calcularPedido();
        $Opcoes = session('opcoes', []);

        return view('user.Selecao', compact('Opcoes', 'Pedido'));
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
    ) {

        return view(
            'admin.Dashboard',
            compact(
                'pratosVendidos',
                'pedidosAgendados',
                'pedidosNormais',
                'valorTotalAgendados',
                'valorTotalNormais',
                'categoriasMaisPedidas',
                'itensMaisPedidos',
                'top3dias',
            )
        );
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

        return view('admin.Configuracao', compact('FormaPagamentos', 'Categorias', 'Configuracoes'));
    }

    public function Pedido()
    {
        return view('admin.Pedido',);
    }
}
