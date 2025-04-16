<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarrinhoController extends Controller
{
    public function IndexCarrinho()
    {
        $Carrinho = session('carrinho', []);
        $ids = array_keys($Carrinho);

        $User = new UserController();
        $Pedido = $User->GetCarrinho();

        $Itens = Cardapio::whereIn('id', $ids)->get();

        return view('User.Sacola', compact('Carrinho', 'Itens', 'Pedido'));
    }

    public function LimparCarrinho()
    {
        session()->put('carrinho', []);

        return $this->IndexCarrinho();
    }

    public function show($id)
    {
        $Item = Cardapio::where('id', $id)
            ->where('status', 'ligado')
            ->first();

        if ($Item) {
            // Verifica a categoria do item
            $categoria = Categoria::find($Item->id_categoria);

            if ($categoria) {
                // Se a categoria for 'Primaria', retorna até 10 itens da categoria 'Secundaria'
                if ($categoria->nivel === 'Primaria') {
                    $Itens = Cardapio::whereHas('categoria', function ($query) {
                        $query->where('nivel', 'Secundaria');
                    })
                        ->where('status', 'ligado')
                        ->limit(10)
                        ->get();

                    $Bebidas = Cardapio::where('id_categoria', '3')
                        ->where('status', 'ligado')
                        ->get();
                }
                // Se a categoria for 'Secundaria', retorna todos os itens dessa categoria
                elseif ($categoria->nivel === 'Secundaria') {
                    $Itens = Cardapio::where('id_categoria', $categoria->id)
                        ->where('id', '!=', $Item->id) // Exclui o item com o ID de $Item
                        ->where('status', 'ligado')
                        ->limit(10)
                        ->get();

                    $Bebidas = Cardapio::where('id_categoria', '3')
                        ->where('status', 'ligado')
                        ->get();
                } else {
                    $Bebidas = Cardapio::where('id_categoria', $categoria->id)
                        ->where('id', '!=', $Item->id)
                        ->where('status', 'ligado')
                        ->get();

                    if ($Bebidas->isNotEmpty()) {
                        return view("user.Item", compact('Item', 'Bebidas'));
                    } else {
                        return view("user.Item", compact('Item'));
                    }
                }
            }
        }

        return view("user.Item", compact('Item', 'Itens', 'Bebidas'));
    }

    public function OpcaoPedidoLogin()
    {
        $user = Auth::user();

        $User = [
            'nome' => $user->nome,
            'telefone' => $user->telefone,
            'email' => $user->email,
            'cep' => $user->cep,
            'rua' => $user->rua,
            'bairro' => $user->bairro,
            'numero_residencia' => $user->numero_residencia,
            'complemento' => $user->complemento,
        ];

        session(['User' => $User]);

        return redirect()->route("User.Pagamento");
    }

    public function SalvarOpcaoPedido(Request $request)
    {
        // Criando o array de dados do usuário
        $userData = [
            'nome' => $request->input('nome'),
            'telefone' => $request->input('telefone'),
            'email' => $request->input('email'),
            'cep' => $request->input('cep'),
            'rua' => $request->input('rua'),
            'bairro' => $request->input('bairro'),
            'numero_residencia' => $request->input('numero_residencia'),
            'complemento' => $request->input('complemento'),
        ];

        // Armazenando os dados na sessão
        session(['User' => $userData]);

        return redirect()->route("User.Pagamento");
    }

    public function SalvarSelecao($opcaoSelecionada, $tipoOpcao)
    {
        $Opcoes = [
            'categoria' => $tipoOpcao,
            'opcao_entrega' => $opcaoSelecionada,
        ];

        return $this->EditarSelecao($Opcoes);
    }

    public function SalvarSelecaoHorario($opcaoSelecionada, $tipoOpcao, $horario)
    {
        $Opcoes = [
            'categoria' => $tipoOpcao,
            'opcao_entrega' => $opcaoSelecionada,
            'horario' => $horario,
        ];

        return $this->EditarSelecao($Opcoes);
    }

    public function EditarSelecao($Opcoes)
    {
        session(['opcoes' => $Opcoes]);

        return redirect()->route('User.OpcaoPedido');
    }

    public function SalvarSacola(Request $request)
    {
        $itens = $request->input('itens', []);

        $carrinho = [];

        foreach ($itens as $id => $item) {
            // Buscar o item no banco
            $itemCardapio = Cardapio::find($id);

            // Verifica se o item existe, está com status 'ligado' e tem quantidade > 0
            if ($itemCardapio && $itemCardapio->status === 'ligado' && $item['quantidade'] > 0) {
                $carrinho[$id] = [
                    'quantidade' => $item['quantidade'],
                    'valor' => $item['valor'],
                ];
            }
        }

        session(['carrinho' => $carrinho]);

        return redirect()->route('User.Selecao');
    }

    public function SalvarPedido(Request $request)
    {
        $dados = $request->all();
        $carrinho = session('carrinho', []);

        // Processa item principal
        if (isset($dados['mainItem'])) {
            $item = $dados['mainItem'];
            $id = $item['id'];

            if (isset($carrinho[$id])) {
                // Se já existe, soma a quantidade
                $carrinho[$id]['quantidade'] += $item['quantity'];
            } else {
                // Se não existe, adiciona novo
                $carrinho[$id] = [
                    'quantidade' => $item['quantity'],
                    'valor' => $item['price']
                ];
            }
        }

        // Processa itens adicionais
        if (isset($dados['selectedItems'])) {
            foreach ($dados['selectedItems'] as $id => $item) {
                if (isset($carrinho[$id])) {
                    $carrinho[$id]['quantidade'] += $item['quantity'];
                } else {
                    $carrinho[$id] = [
                        'quantidade' => $item['quantity'],
                        'valor' => $item['price']
                    ];
                }
            }
        }

        // Processa bebidas (remove o prefixo 'bebida-')
        if (isset($dados['selectedDrinks'])) {
            foreach ($dados['selectedDrinks'] as $id => $item) {
                $cleanId = str_replace('bebida-', '', $id);
                if (isset($carrinho[$cleanId])) {
                    $carrinho[$cleanId]['quantidade'] += $item['quantity'];
                } else {
                    $carrinho[$cleanId] = [
                        'quantidade' => $item['quantity'],
                        'valor' => $item['price']
                    ];
                }
            }
        }

        // Salva observação separadamente se necessário
        if (isset($dados['observacao'])) {
            session(['observacao' => $dados['observacao']]);
        }

        // Atualiza a sessão
        session(['carrinho' => $carrinho]);

        return response()->json(['success' => true]);
    }

    public function calcularPedido()
    {
        $carrinho = session('carrinho', []);

        $totalItens = 0;
        $valorTotal = 0;

        foreach ($carrinho as $item) {
            $totalItens += $item['quantidade'];
            $valorTotal += $item['quantidade'] * $item['valor'];
        }

        return [
            'valor' => $valorTotal,
            'quantidade' => $totalItens
        ];
    }
}
