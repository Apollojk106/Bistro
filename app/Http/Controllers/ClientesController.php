<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Modelo para a tabela de clientes
use App\Models\User; // Modelo para a tabela de usuários (clientes)

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = User::with(['anotacoes', 'pedidos'])
            ->orderBy('nome')
            ->get()
            ->map(function ($cliente) {
                // Calcular saldo (soma dos valores dos pedidos)
                $cliente->saldo = $cliente->pedidos->sum('valor_total');

                // Total de pedidos
                $cliente->total_pedidos = $cliente->pedidos->count();

                // Último pedido
                $cliente->ultimo_pedido = $cliente->pedidos->sortByDesc('created_at')->first();

                return $cliente;
            });

        return view('admin.Pessoas', compact('clientes'));
    }

    public function storeAnotacao(Request $request, User $cliente)
    {
        $request->validate([
            'conteudo' => 'required|string|max:1000'
        ]);

        $cliente->anotacoes()->create([
            'conteudo' => $request->conteudo
        ]);

        return back()->with('success', 'Anotação adicionada com sucesso!');
    }

    public function destroy(User $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente excluído com sucesso!');
    }
}
