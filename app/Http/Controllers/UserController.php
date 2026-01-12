<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CardapioController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\FormaPagamentoController;

use App\Http\Requests\UpdatePerfilRequest;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CardapioRequest;
use App\Models\Cardapio;
use App\Models\Categoria;
use App\Models\Configuracao;
use App\Models\FormaPagamento;
use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\User;
use Exception;
use Termwind\Components\Dd;

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

        if ($user) {
            // Combina a senha fornecida com o salt armazenado
            $senhaComSalt = $request->senha . '.' . $user->salt;

            // Verifica se a senha (com salt) corresponde ao hash salvo no banco
            if (Hash::check($senhaComSalt, $user->senha)) {
                Auth::login($user);

                if ($user->role === 'admin') {
                    return redirect()->route('Index.Admin')->with('success', 'Login realizado com sucesso!');
                }

                return redirect()->route('User.Perfil')->with('success', 'Login realizado com sucesso!');
            }
        }

        return back()->with('error', 'Credenciais inválidas. Tente novamente.');
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
            return redirect()->route('login')->with('error', 'Já existe uma conta com esse e-mail. Faça login.');
        }

        $user = new User();
        $user->email = $request->email;
        $user->nome = $request->nome;
        $user->telefone = $request->telefone;
        $user->cep = $request->cep;
        $user->rua = $request->rua;
        $user->bairro = $request->bairro;
        $user->numero_residencia = $request->numero_residencia;
        $user->complemento = $request->complemento;
        $user->salt = bin2hex(random_bytes(16));
        $user->senha = bcrypt($request->senha . '.' . $user->salt); // Armazena a senha com o salt
        $user->save();

        Auth::login($user);

        // Redirecionar após o cadastro
        return redirect()->route('User.Perfil')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function Logout()
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Você foi desconectado com sucesso!');
    }

    //Esse controler é somente para a rota view
    //Login
    public function Perfil()
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }
        $usuario = Auth::user();

        $PedidosUser = Pedido::with('itensPedidos.cardapio')
            //->where('status', 'Concluido')
            ->where('email', $usuario->email)
            ->take(10)
            ->get();

        return view('user.Perfil', compact('usuario', 'PedidosUser'));
    }

    public function SavePerfil(UpdatePerfilRequest $request)
    {
        if (!Auth::check()) {
            return redirect()->route("login");
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
        $opcoesCartao = (new FormaPagamento())->getOpcoesCartao();

        return view('user.FormaDePagamento', [
            'Pedido' => $Pedido,
            'opcoesCartao' => $opcoesCartao
        ]);
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
            $valorFrete = 0; // Inicializa com valor padrão

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
            } elseif ($dadosPedido['opcoes']['categoria'] === 'entrega' && empty($dadosPedido['User']['cep'])) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Endereço não informado para delivery';
            } elseif ($dadosPedido['opcoes']['categoria'] === 'Entrega') {
                $Frete = new FreteController();
                $cepOrigem = '06754-140';
                $cepDestino = $dadosPedido['User']['cep'];

                $valorFrete = $Frete->calcularFretePorDistancia($cepOrigem, $cepDestino) ?? 5.00;
                session(['Frete' => $valorFrete]);
            }

            // Verificação dos itens com status = 'ligado'
            $carrinho = $dadosPedido['carrinho'] ?? [];
            $produtoIds = array_keys($carrinho);

            $produtos = \App\Models\Cardapio::whereIn('id', $produtoIds)->get()->keyBy('id');
            $carrinhoAtualizado = [];
            $removidos = false;

            foreach ($carrinho as $id => $item) {
                if (isset($produtos[$id]) && $produtos[$id]->status === 'ligado') {
                    $carrinhoAtualizado[$id] = $item;
                } else {
                    $removidos = true;
                }
            }

            if ($removidos) {
                $pedidoIncompleto = true;
                $mensagemIncompleto = 'Alguns itens foram removidos do pedido por estarem indisponíveis.';
            }

            // Atualiza a sessão com o novo carrinho
            session(['carrinho' => $carrinhoAtualizado]);
            $dadosPedido['carrinho'] = $carrinhoAtualizado;

            // Recalcular valor total
            $valorTotal = 0;
            foreach ($carrinhoAtualizado as $id => $item) {
                $valorTotal += $item['quantidade'] * $item['valor'];
            }

            // Adiciona o frete apenas se for delivery
            if (isset($dadosPedido['opcoes']['categoria']) && $dadosPedido['opcoes']['categoria'] === 'Entrega') {
                $valorTotal += $valorFrete;
            }

        } catch (Exception $X) {
            dd($X->getMessage());
            $dadosPedido = [];
            $produtoIds = [];
            $produtos = [];
            $valorTotal = 0;
            $valorFrete = 0;
            $pedidoIncompleto = true;
            $mensagemIncompleto = 'Erro ao processar pedido';
        }

        return view('user.VerPedido', compact('dadosPedido', 'produtos', 'valorTotal', 'pedidoIncompleto', 'mensagemIncompleto', 'valorFrete'));
    }

    public function PedidoSolicitado()
    {
        $id = session('pedido_id');

        if (!$id) {
            return redirect()->route('login')->with(
                'error',
                'Sua sessão expirou ou o pedido não foi iniciado.
            Por favor, registre-se ou faça login para continuar.'
            );
        }

        $pedido = Pedido::with('itensPedidos.cardapio')
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

        $pedido = Pedido::with('itensPedidos.cardapio')
            ->where('email', $email)
            ->orderBy('created_at', 'desc')
            ->first();

        return $this->IndexPedido($pedido);
    }

    public function IndexPedido($Pedido)
    {
        $formapagamento = FormaPagamento::where('id', $Pedido->id_forma_pagamento)
            ->first();

        return view('user.PedidoAntigo', ['pedido' => $Pedido, 'pagamento' => $formapagamento->nome]);
    }

    public function Selecao()
    {
        // Obtém o carrinho do usuário
        $Pedido = $this->GetCarrinho();

        // Busca direta das configurações específicas
        $horario = Configuracao::where('nome', 'Horario de Funcionamento')->first();
        $tempoMinimo = Configuracao::where('nome', 'Tempo mínimo de Agendamento')->first();

        // Define valores padrão
        $inicioExpediente = '09:00';
        $fimExpediente = '21:00';
        $tempoMinimoAgendamento = '00:30';

        if ($horario && $horario->status) {
            $inicioExpediente = $horario->valores1 ?? $inicioExpediente;
            $fimExpediente = $horario->valores2 ?? $fimExpediente;
        }

        if ($tempoMinimo && $tempoMinimo->status) {
            $tempoMinimoAgendamento = $tempoMinimo->valores1 ?? $tempoMinimoAgendamento;
        }

        // Mantém o carregamento das outras configurações como no original
        $configuracoes = Configuracao::all()->mapWithKeys(function ($item) {
            if ($item->nome == 'Horario de Funcionamento') {
                return []; // Já tratado acima
            }
            if ($item->nome == 'Tempo mínimo de Agendamento') {
                return []; // Já tratado acima
            }
            return [$item->nome => $item->status ? $item->valores1 : null];
        });

        // Prepara os dados para a view
        $dados = [
            'Opcoes' => session('opcoes', []),
            'Pedido' => $Pedido,
            'configuracoes' => [
                'Pedido' => $configuracoes->get('Pedido'),
                'Agendamento' => $configuracoes->get('Agendamento'),
                'Tempo mínimo de Agendamento' => $tempoMinimoAgendamento,
                'Delivery' => $configuracoes->get('Delivery'),
                'Distancia Máxima' => $configuracoes->get('Distancia Máxima') ?? 10,
                'Horario de Funcionamento' => [
                    'valores1' => $inicioExpediente,
                    'valores2' => $fimExpediente
                ]
            ]
        ];

        return view('user.Selecao', $dados);
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
        $pagamento = new FormaPagamentoController();
        $pagamentos = $pagamento->GetPagamento();

        return view('admin.Pedido', compact('pagamentos'));
    }

    public function GetCarrinho()
    {
        $Carrinho = new CarrinhoController();
        return $Carrinho->calcularPedido();
    }
}
