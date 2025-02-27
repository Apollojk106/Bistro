<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function GetPedidos()
    {
        $TodosPedidos = Pedido::where('opcao_entrega', 'Agora')
            ->orWhere('opcao_entrega', 'Viagem')
            ->get();

        return $TodosPedidos;
    }

    public function GetAgendados()
    {
        $Agendados = Pedido::where('opcao_entrega', 'Agendamento')->get();

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
}
