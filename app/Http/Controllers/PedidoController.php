<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Cardapio;
use Carbon\Carbon;
use App\Models\ItensPedido;
use App\Http\Controllers\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PedidoController extends Controller
{
    public function GetPedidos()
    {
        $TodosPedidos = Pedido::where('opcao_entrega', '!=', 'Agendamento')
            ->where('status', 'Pendente')
            ->with('itensPedido') // Carregar o relacionamento
            ->get();

        return $this->GetItems($TodosPedidos);
    }

    public function GetAgendados()
    {
        $Agendados = Pedido::where('opcao_entrega', 'Agendamento')
            ->where('status', 'Pendente')
            ->with('itensPedido') // Carregar o relacionamento
            ->get();

        return $this->GetItems($Agendados);
    }

    public function GetEmAndamento()
    {
        $EmAndamento = Pedido::where('status', 'EmAndamento')
            ->with('itensPedido') // Carregar o relacionamento
            ->get();

        return $this->GetItems($EmAndamento);
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

        // Lógica para atualizar o status
        $statusAtual = $pedido->status;

        // Definindo os status possíveis
        $statusPossiveis = ['Pendente', 'EmAndamento', 'Concluido'];

        // Pegando o próximo status
        $proximoStatusIndex = array_search($statusAtual, $statusPossiveis) + 1;

        // Se o status atual for o último ('Concluido'), não faz mais a atualização
        if ($proximoStatusIndex < count($statusPossiveis)) {
            $pedido->status = $statusPossiveis[$proximoStatusIndex];
            $pedido->save();
        }

        return redirect()->route('Pedidos');
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

        $PedidosFiltrado = Pedido::ith('itensPedido.cardapio')
            ->where($request->categoria, 'like', '%' . $request->pesquisa . '%')
            ->where('status', 'Concluido')
            ->take(10)
            ->get();

        $PedidosFiltrado = $this->GetItems($PedidosFiltrado);

        return $this->Historico($PedidosFiltrado);
    }

    public function GetItems($Pedidos)
    {
        foreach ($Pedidos as $Pedido) {
            // Verifica se o relacionamento "itensPedido" foi carregado
            if (!$Pedido->relationLoaded('itensPedido')) {
                \Log::error('Relacionamento itensPedido não carregado para o pedido: ' . $Pedido->id);
                $Pedido->Items = ''; // Garante que o campo Items seja vazio
                continue;
            }

            // Verifica se há itens no pedido
            if ($Pedido->itensPedido->isEmpty()) {
                \Log::info('Pedido ' . $Pedido->id . ' não possui itens.');
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
                    \Log::warning('Cardápio não encontrado para o item: ' . $item->id_cardapio);
                }
            }

            // Junta todos os itens em uma única string separada por ponto
            $Pedido->Items = implode('. ', $itensDescricao) . '.';
        }

        return $Pedidos;
    }

    //Dashboard
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
                    // Define os formatos de data
                    $formatacaoInicial = "d/m/Y";
                    $formatacaoFinal = "Y-m-d";

                    // Tenta converter a data para o formato Y-m-d
                    $dataFormatada = Carbon::createFromFormat($formatacaoInicial, $pesquisa)->format($formatacaoFinal);

                    // Filtra os pedidos e itens pedidos pela data formatada
                    $Pedidos = Pedido::whereDate('created_at', $dataFormatada)->get();
                    $ItemPedido = ItensPedido::with('cardapio.categoria')
                        ->whereDate('created_at', $dataFormatada)
                        ->get();
                } catch (\Exception $e) {
                    return back()->with(
                        'error',
                        'Data inválida. Por favor,
                        insira uma data válida no formato dd/mm/aaaa.'
                    );
                }
            default:
                // Filtro padrão (últimos 30 dias)
                $Pedidos = Pedido::where('created_at', '>=', Carbon::now()->subDays(30))->get();
                $ItemPedido = ItensPedido::with('cardapio.categoria')
                    ->where('created_at', '>=', Carbon::now()->subDays(30))
                    ->get();
                break;
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
}
