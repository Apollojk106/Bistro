<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\FormaPagamento;
use App\Models\Pedido;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ItensPedido;
use App\Models\Configuracao;
use App\Models\Cliente; // Certifique-se de importar o modelo Cliente


class PedidoController extends Controller
{
    public function GetPedido(Request $request)
    {
        $PedidosUser = Pedido::with('itensPedido.cardapio')
            ->where('id', $request->id)
            ->first();

        $carrinho = [];

        // Preenche o carrinho com os itens do pedido
        foreach ($PedidosUser->itensPedido as $item) {
            $carrinho[$item->id_cardapio] = [
                'quantidade' => $item->quantidade,
                'valor' => $item->valor_unitario
            ];
        }

        // Armazena na sessão
        session(['carrinho' => $carrinho]);

        return redirect()->route("User.Sacola")->with([
            'success' => 'Pedido resgatado com sucesso!'
        ]);
    }

    public function gerarPedido()
    {
        $validacao = $this->validarPedido();
        if ($validacao !== true) {
            return $validacao; // Retorna o redirecionamento com erro se a validação falhar
        }

        $dadosPedido = session()->all();

        // Verificação prévia do status dos itens do carrinho
        $carrinho = $dadosPedido['carrinho'] ?? [];
        $produtoIds = array_keys($carrinho);

        // Buscar os produtos com status 'ligado'
        $produtos = \App\Models\Cardapio::whereIn('id', $produtoIds)->get()->keyBy('id');
        $carrinhoValido = [];
        $removidos = false;

        foreach ($carrinho as $id => $item) {
            if (isset($produtos[$id]) && $produtos[$id]->status === 'ligado') {
                $carrinhoValido[$id] = $item;
            } else {
                $removidos = true;
            }
        }

        // Se houve remoção, não prosseguir com o pedido
        if ($removidos) {
            session(['carrinho' => $carrinhoValido]);
            return redirect()->route('User.VerPedido')->with('error', 'Alguns itens estavam indisponíveis e foram removidos. Por favor, revise seu pedido.');
        }

        DB::beginTransaction();
        try {
            $NomePagamento = $dadosPedido['pagamento']['metodo'];
            $formaPagamento = FormaPagamento::where('nome', 'like', "%{$NomePagamento}%")->first();

            $valorTotalItens = collect($carrinhoValido)->sum(fn($item) => $item['quantidade'] * $item['valor']);
            $valorTaxa = $valorTotalItens * ($formaPagamento->taxa / 100);

            $pedido = Pedido::create([
                'nome'              => ucfirst(strtolower($dadosPedido['User']['nome'])),
                'email'             => strtolower($dadosPedido['User']['email']),
                'telefone'          => $dadosPedido['User']['telefone'],
                'rua'               => $dadosPedido['User']['rua'] ?? null,
                'bairro'            => ucfirst(strtolower($dadosPedido['User']['bairro'] ?? '')),
                'numero_residencia' => $dadosPedido['User']['numero_residencia'] ?? null,
                'complemento'       => ucfirst(strtolower($dadosPedido['User']['complemento'] ?? '')),
                'categoria_pedido'  => ucfirst(strtolower($dadosPedido['opcoes']['categoria'])),
                'status_pedido'     => 'Pendente',
                'opcao_entrega'     => ucfirst(strtolower($dadosPedido['opcoes']['opcao_entrega'])),
                'horario'           => isset($dadosPedido['opcoes']['horario']) ? date('Y-m-d H:i:s', strtotime($dadosPedido['opcoes']['horario'])) : null,
                'id_forma_pagamento' => $formaPagamento->id,
                'descricao'         => $dadosPedido['observacao'] ?? "",
                'valor_total'       => $valorTotalItens,
                'frete'             => 0,
                'valor_taxa'        => $valorTaxa,
            ]);

            foreach ($carrinhoValido as $id_cardapio => $item) {
                ItensPedido::create([
                    'id_pedido'     => $pedido->id,
                    'id_cardapio'   => $id_cardapio,
                    'quantidade'    => $item['quantidade'],
                    'valor_unitario' => $item['valor'],
                    'subtotal'      => $item['quantidade'] * $item['valor'],
                ]);
            }

            //session(['pedido_id' => $pedido->id]);
            DB::commit();

            //session()->forget(['carrinho', 'opcoes', 'pagamento', 'observacao']);

            return redirect()->route("User.Pedido")->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao gerar o pedido. Tente novamente. ' . $e->getMessage());
        }
    }

    public function GetPedidos()
    {
        $TodosPedidos = Pedido::with('itensPedido.cardapio')
            ->where('opcao_entrega', '!=', 'Agendamento')
            ->where('status', 'Pendente')
            ->get();

        $TodosPedidos = $this->GetPagamento($TodosPedidos);
        return $this->GetItems($TodosPedidos);
    }

    public function GetAgendados()
    {
        $Agendados = Pedido::with('itensPedido.cardapio')
            ->where('opcao_entrega', 'Agendamento')
            ->where('status', 'Pendente')
            ->get();

        $Agendados = $this->GetPagamento($Agendados);
        return $this->GetItems($Agendados);
    }

    public function GetEmAndamento()
    {
        $EmAndamento = Pedido::with('itensPedido.cardapio')
            ->where('status', 'EmAndamento')
            ->get();

        $EmAndamento = $this->GetPagamento($EmAndamento);
        return $this->GetItems($EmAndamento);
    }

    public function GetPagamento($TodosPedidos)
    {
        foreach ($TodosPedidos as $pedido) {
            $forma = FormaPagamento::find($pedido->id_forma_pagamento);
            $pedido->formapagamento = $forma ? $forma->nome : 'Não informado';
        }

        return $TodosPedidos;
    }

    public function getPedidosJson()
    {
        $pedidos = [
            'pendentes' => $this->GetPedidos(),
            'em_andamento' => $this->GetEmAndamento(),
            'agendamentos' => $this->GetAgendados(),
        ];

        return response()->json($pedidos);
    }

    public function AvancarPedidos($id)
    {
        $pedido = Pedido::findOrFail($id);

        $statusAtual = $pedido->status;
        $statusPossiveis = ['Pendente', 'EmAndamento', 'Concluido'];

        $proximoStatusIndex = array_search($statusAtual, $statusPossiveis) + 1;
        if ($proximoStatusIndex < count($statusPossiveis)) {
            $pedido->status = $statusPossiveis[$proximoStatusIndex];
            $pedido->save();
        }

        return redirect()->route('Pedidos');
    }

    public function VoltarPedidos($id)
    {
        $pedido = Pedido::findOrFail($id);

        $statusAtual = $pedido->status;
        $statusPossiveis = ['Pendente', 'EmAndamento', 'Concluido'];

        $statusAnteriorIndex = array_search($statusAtual, $statusPossiveis) - 1;
        if ($statusAnteriorIndex >= 0) {
            $pedido->status = $statusPossiveis[$statusAnteriorIndex];
            $pedido->save();
        }

        return redirect()->route('Pedidos');
    }

    public function AtualizarPedidos(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|integer',
            'forma_pagamento' => 'required|numeric',
            'valor_ajuste' => 'required|numeric',
            'valor_pago' => 'required|numeric',
        ]);

        // Busca a forma de pagamento usando LIKE (case insensitive)
        $forma = FormaPagamento::where('id', $request->forma_pagamento)->first();
        if (!$forma) {
            return redirect()->back()->with('error', 'Forma de pagamento não encontrada.');
        }

        // Busca o pedido
        $pedido = Pedido::find($request->pedido_id);

        if (!$pedido) {
            return redirect()->back()->with('error', 'Pedido não encontrado.');
        }

        // Atualiza os valores do pedido
        $pedido->id_forma_pagamento = $forma->id;
        $pedido->valor_total = floatval($pedido->valor_total) + floatval($request->valor_ajuste);
        $pedido->valor_pago = $request->valor_pago;
        $pedido->status = 'Concluido';
        $pedido->save();

        return redirect()->back()->with('success', 'Pedido atualizado com sucesso.');
    }

    public function Historico($Pedidos)
    {
        return view('admin.Historico', compact('Pedidos'));
    }

    public function PedidosConcluidos()
    {
        $PedidosConcluidos = Pedido::with('itensPedido.cardapio')
            ->where('status', 'Concluido')
            ->take(10)
            ->get();

        $PedidosConcluidos = $this->GetItems($PedidosConcluidos);

        return $this->Historico($PedidosConcluidos);
    }

    public function HistoricoFiltro(Request $request)
    {
        $PedidosFiltrado = Pedido::with('itensPedido.cardapio')
            ->where($request->categoria, 'like', '%' . $request->pesquisa . '%')
            ->where('status', 'Concluido')
            ->take(10)
            ->get();

        dd($PedidosFiltrado);

        $PedidosFiltrado = $this->GetItems($PedidosFiltrado);

        return $this->Historico($PedidosFiltrado);
    }

    public function GetItems($Pedidos)
    {
        foreach ($Pedidos as $Pedido) {
            // Verifica se o relacionamento "itensPedido" foi carregado
            if (!$Pedido->relationLoaded('itensPedido')) {
                //\Log::error('Relacionamento itensPedido não carregado para o pedido: ' . $Pedido->id);
                $Pedido->Items = ''; // Garante que o campo Items seja vazio
                continue;
            }

            // Verifica se há itens no pedido
            if ($Pedido->itensPedido->isEmpty()) {
                //\Log::info('Pedido ' . $Pedido->id . ' não possui itens.');
                $Pedido->Items = ''; // Garante que o campo Items seja vazio
                continue;
            }

            // Array para armazenar as descrições dos itens
            $itensDescricao = [];

            // Itera sobre os itens do pedido
            foreach ($Pedido->itensPedido as $item) {
                // Usa o relacionamento "cardapio" para buscar as informações do item
                $cardapio = $item->cardapio;

                // Verifica se o cardápio foi encontrado
                if ($cardapio) {
                    // Concatena a quantidade e o nome do item
                    $itensDescricao[] = $item->quantidade . "x " . $cardapio->nome;
                } else {
                    //\Log::warning('Cardápio não encontrado para o item: ' . $item->id_cardapio);
                }
            }

            // Junta todos os itens em uma única string separada por ponto
            $Pedido->Items = implode('. ', $itensDescricao) . '.';
        }

        return $Pedidos;
    }

    public function IndexDashboard()
    {
        $Pedidos = Pedido::where('created_at', '>=', Carbon::now()->subDays(30))
            ->get();

        $ItemPedido = ItensPedido::with('cardapio.categoria') // Carrega Cardapio e Categoria
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->get();

        return $this->ReturnDashboard($Pedidos, $ItemPedido);
    }

    public function FilterDashboard(Request $request)
    {
        $filtro = $request->filtro;
        $pesquisa = $request->pesquisa;

        switch ($filtro) {
            case 'Ano':
                // Filtra pelo ano inteiro
                $ano = $pesquisa;
                $Pedidos = Pedido::whereYear('created_at', $ano)->get();
                $ItemPedido = ItensPedido::with('cardapio.categoria')
                    ->whereYear('created_at', $ano)
                    ->get();
                break;

            case 'Mes':
                // Filtra pelo mês inteiro do ano atual
                $mes = $pesquisa;
                $ano = Carbon::now()->year; // Assume o ano atual
                $Pedidos = Pedido::whereYear('created_at', $ano)
                    ->whereMonth('created_at', $mes)
                    ->get();
                $ItemPedido = ItensPedido::with('cardapio.categoria')
                    ->whereYear('created_at', $ano)
                    ->whereMonth('created_at', $mes)
                    ->get();
                break;

            case 'Dia':
                // Filtra pelo dia específico
                $dia = $pesquisa;
                $mes = Carbon::now()->month; // Assume o mês atual
                $ano = Carbon::now()->year; // Assume o ano atual
                $Pedidos = Pedido::whereYear('created_at', $ano)
                    ->whereMonth('created_at', $mes)
                    ->whereDay('created_at', $dia)
                    ->get();
                $ItemPedido = ItensPedido::with('cardapio.categoria')
                    ->whereYear('created_at', $ano)
                    ->whereMonth('created_at', $mes)
                    ->whereDay('created_at', $dia)
                    ->get();
                break;

            case 'Data':
                // Filtra por data específica (formato d/m/Y)
                try {
                    $dataFormatada = Carbon::createFromFormat("d/m/Y", $pesquisa)->format("Y-m-d");

                    $Pedidos = Pedido::whereRaw('DATE(created_at) = ?', [$dataFormatada])->get();

                    $ItemPedido = ItensPedido::with('cardapio.categoria')
                        ->whereDate('created_at', $dataFormatada)
                        ->get();
                } catch (\Exception $e) {

                    return response()->json(['error' => 'Erro ao processar a data: ' . $e->getMessage()], 400);
                }
        }

        return $this->ReturnDashboard($Pedidos, $ItemPedido);
    }

    public function ReturnDashboard($Pedidos, $ItemPedido)
    {
        // Quantidade de pedidos agendados e normais
        $pedidosAgendados = $Pedidos->where('opcao_entrega', 'Agendamento')->count();
        $pedidosNormais = $Pedidos->where('opcao_entrega', '!=', 'Agendamento')->count();

        // Total de valores de pedidos agendados e normais
        $valorTotalAgendados = $Pedidos->where('opcao_entrega', 'Agendamento')->sum('valor_total');
        $valorTotalNormais = $Pedidos->where('opcao_entrega', '!=', 'Agendamento')->sum('valor_total');

        // As 3 categorias mais pedidas
        $categoriasMaisPedidas = $ItemPedido->groupBy(function ($item) {
            return $item->cardapio->categoria->nome;
        })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortDesc()
            ->take(3);

        // Os 3 itens mais pedidos
        $itensMaisPedidos = $ItemPedido->groupBy('id_cardapio')
            ->map(function ($group) {
                return [
                    'item' => $group->first()->cardapio->nome,
                    'total_pedidos' => $group->sum('quantidade'),
                ];
            })
            ->sortByDesc('total_pedidos')
            ->take(3);

        $top3dias = $this->TopPedidos($Pedidos);

        $pratosVendidos = $this->UltimosPedidos($Pedidos);

        $User = new UserController;
        return $User->Dashboard(
            $pratosVendidos,
            $pedidosAgendados,
            $pedidosNormais,
            $valorTotalAgendados,
            $valorTotalNormais,
            $categoriasMaisPedidas,
            $itensMaisPedidos,
            $top3dias,
        );
    }

    public function TopPedidos($Pedidos)
    {
        $pedidosPorDia = $Pedidos->groupBy(function ($pedido) {
            return Carbon::parse($pedido->created_at)->format('d/m');
        });

        // Calcula o total de pedidos e o valor total por dia
        $diasComVendas = $pedidosPorDia->map(function ($pedidosDoDia) {
            return [
                'total_pedidos' => $pedidosDoDia->count(), // Total de pedidos no dia
                'valor_total' => $pedidosDoDia->sum('valor_total'), // Valor total vendido no dia
            ];
        });

        // Ordena os dias pelo valor total vendido (do maior para o menor)
        $diasOrdenados = $diasComVendas->sortByDesc('valor_total');

        return $diasOrdenados->take(3);
    }

    public function UltimosPedidos($Pedidos)
    {
        $pedidosPorDia = $Pedidos->groupBy(function ($pedido) {
            return Carbon::parse($pedido->created_at)->format('d/m');
        });

        // Ordena os dias pela data de criação (do mais recente para o mais antigo)
        $diasOrdenados = $pedidosPorDia->sortKeysDesc();

        // Pega os 7 dias mais recentes
        $ultimos7Dias = $diasOrdenados->take(7);

        // Formata o resultado: data (dd/mm) e quantidade de pedidos
        $resultados = $ultimos7Dias->map(function ($pedidosDoDia) {
            return [
                'data' => $pedidosDoDia->first()->created_at->format('d/m'), // Data no formato dd/mm
                'quantidade' => $pedidosDoDia->count(), // Quantidade de pedidos no dia
            ];
        });

        return $resultados;
    }

    public function validarPedido()
    {
        // Verifica se a configuração "Pedido" está "Ligado"
        $configuracaoPedido = Configuracao::where('nome', 'Pedido')->value('valores1');
        if ($configuracaoPedido != 'Ligado') {
            return redirect()->route('User.Cardapio')->with('error', 'O sistema de pedidos está indisponível no momento.');
        }

        // Verifica se a configuração "Agendamento" está "Ligado"
        $configuracaoAgendamento = Configuracao::where('nome', 'Agendamento')->value('valores1');
        $opcaoUsuario = session('opcoes')['opcao_entrega'] ?? null; // Ajuste para pegar corretamente a opção
        if ($configuracaoAgendamento != 'Ligado' && $opcaoUsuario === 'Agendamento') {
            return redirect()->route('User.Selecao')->with('error', 'O sistema de agendamento está indisponível no momento.');
        }

        // Verifica se a configuração "Delivery" está "Ligado"
        $configuracaoDelivery = Configuracao::where('nome', 'Delivery')->value('valores1');
        $opcaoCategoria = session('opcoes')['categoria'] ?? null;
        if ($configuracaoDelivery != 'Ligado' && $opcaoCategoria === 'Entrega') {
            return redirect()->route('User.Selecao')->with('error', 'O sistema de delivery está indisponível no momento.');
        }

        return true;
    }
}
