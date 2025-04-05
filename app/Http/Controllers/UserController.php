<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ItensPedidoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\PixController;

use App\Http\Requests\UpdatePerfilRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use Illuminate\Support\Facades\View;
use App\Models\Categoria;
use App\Models\Configuracao;
use App\Models\FormaPagamento;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;

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

        return redirect()->back()->with('success', 'Você foi desconectado com sucesso!');
    }

    //Esse controler é somente para a rota view
    //Login
    public function Perfil()
    {
        if (!Auth::check()) {
            return redirect()->route("User.Login");
        }
        $usuario = Auth::user();

        $PedidosUser = Pedido::with('itensPedido.cardapio')
            //->where('status', 'Concluido')
            ->where('email', $usuario->email)
            ->take(10)
            ->get();

        return view('user.Perfil', compact('usuario', 'PedidosUser'));
    }

    public function SavePerfil(UpdatePerfilRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route("User.Login");
        }

        $usuario = User::find(Auth::id());

        $usuario->update([
            'nome' => $request->nome,
            'telefone' => $request->telefone,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'numero_residencia' => $request->numero_residencia,
            'complemento' => $request->complemento
        ]);

        return redirect()->route('User.Perfil')->with('success', 'Perfil atualizado com sucesso!');
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
        if (Auth::check()) {
            $Carrinho = new CarrinhoController();
            return $Carrinho->OpcaoPedidoLogin();
        }
        $Pedido = $this->GetCarrinho();

        return view('user.OpcaoPedido', compact('Pedido'));
    }

    public function FormaPagamento()
    {
        $Pedido = $this->GetCarrinho();

        return view('user.FormaDePagamento', compact('Pedido'));
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
        try {
            $dadosPedido = session()->all();
            $pedidoIncompleto = false;
            $mensagemIncompleto = '';

            // Verificar campos obrigatórios
            if (empty($dadosPedido['User']['nome'])) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Nome do cliente não informado';
            } elseif (empty($dadosPedido['carrinho'])) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Carrinho vazio';
            } elseif (empty($dadosPedido['pagamento']['metodo'])) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Forma de pagamento não selecionada';
            } elseif ($dadosPedido['opcoes']['categoria'] === 'delivery' && empty($dadosPedido['endereco'])) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Endereço não informado para delivery';
            }

            $produtoIds = array_keys($dadosPedido['carrinho'] ?? []);
            $produtos = Cardapio::whereIn('id', $produtoIds)->get()->keyBy('id');

            $valorTotal = 0;
            foreach ($dadosPedido['carrinho'] as $id => $item) {
                $valorTotal += $item['quantidade'] * $item['valor'];
            }
        } catch (Exception $X) {
            $dadosPedido = [];
            $produtoIds = [];
            $produtos = [];
            $valorTotal = 0;
            $pedidoIncompleto = true;
            $mensagemIncompleto = 'Erro ao processar pedido';
        }

        return view('user.VerPedido', compact('dadosPedido', 'produtos', 'valorTotal', 'pedidoIncompleto', 'mensagemIncompleto'));
    }

    public function PedidoSolicitado()
    {
        $id = session('pedido_id');

        if (!$id) {
            return redirect()->route('User.Login')->with('error', 
            'Sua sessão expirou ou o pedido não foi iniciado.
            Por favor, registre-se ou faça login para continuar.');
        }

        $pedido = Pedido::with('itensPedido.cardapio')
            ->where('id', $id)
            ->first();

        return $this->IndexPedido($pedido);
    }

    public function UltimoPedido()
    {
        if (!Auth::check()) {
            return $this->PedidoSolicitado();
        }

        $email = Auth::user()->email;

        $pedido = Pedido::with('itensPedido.cardapio')
            ->where('email', $email)
            ->orderBy('created_at', 'desc') 
            ->first();

        return $this->IndexPedido($pedido);
    }

    public function IndexPedido($Pedido)
    {
        return view('user.PedidoAntigo', ['pedido' => $Pedido]);
    }

    public function Selecao()
    {
        $Pedido = $this->GetCarrinho();
        $Opcoes = session('opcoes', []);

        return view('user.Selecao', compact('Opcoes', 'Pedido'));
    }

    public function PessoasDashboard()
    {
        return view('admin.Pessoas');
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

    public function GetCarrinho()
    {
        $Carrinho = new CarrinhoController();
        return $Carrinho->calcularPedido();
    }
}
