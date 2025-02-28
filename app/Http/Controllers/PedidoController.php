<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function GetPedidos()
    {
        $TodosPedidos = Pedido::where('opcao_entrega','!=', 'Agendamento')
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
        $PedidosConcluidos = Pedido::where('status','Concluido')
        ->take(10)
        ->get();

        return $this->Historico($PedidosConcluidos);
    }

    public function HistoricoFiltro(Request $request) 
    {
        $PedidosFiltrado =Pedido::where($request->categoria, 'like', '%' . $request->pesquisa . '%')
        ->where('status','Concluido')
        ->take(10)
        ->get();

        return $this->Historico($PedidosFiltrado);
    }

    
}
