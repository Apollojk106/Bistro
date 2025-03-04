<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;
use App\Models\Cardapio;

class PedidoController extends Controller
{
    public function GetPedidos()
    {
        $TodosPedidos = Pedido::where('opcao_entrega', '!=', 'Agendamento')
            ->where('status', 'Pendente')
            ->get();

        return $TodosPedidos;
    }

    public function GetAgendados()
    {
        $Agendados = Pedido::where('opcao_entrega', 'Agendamento')
            ->where('status', 'Pendente')
            ->get();

        return $Agendados;
    }

    public function GetEmAndamento()
    {
        $EmAndamento  = Pedido::where('status', 'EmAndamento')->get();

        return $EmAndamento;
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

            if ($Pedido->Items === null) {
                $Pedido->Items = "";
            }

            foreach ($Pedido->itensPedido as $Items) {

                $Retornos = Cardapio::where('id', $Items->id_cardapio)
                ->get();

                foreach($Retornos as $Retorno)
                { 

                    $Pedido->Items .= $Items->quantidade . "x ". $Retorno->nome . ".";

                }
                
            }
        }

        return $Pedidos;
    }
}
