<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido;

class ClientesController extends Controller
{
    public function index()
    {
        // Primeiro busca os emails únicos da tabela pedidos
        $emailsUnicos = Pedido::select('email')
            ->distinct()
            ->pluck('email');

        $clientes = collect();

        foreach ($emailsUnicos as $email) {
            // Busca usuário existente ou cria um novo
            $cliente = User::firstOrNew(['email' => $email]);

            // Se não tem nome ou telefone, busca do último pedido
            if (empty($cliente->nome) || empty($cliente->telefone)) {
                $ultimoPedido = Pedido::where('email', $email)
                    ->orderByDesc('created_at')
                    ->first();

                if ($ultimoPedido) {
                    $cliente->nome = empty($cliente->nome) ? $ultimoPedido->nome : $cliente->nome;
                    $cliente->telefone = empty($cliente->telefone) ? $ultimoPedido->telefone : $cliente->telefone;

                    // Atualiza outros campos se necessário
                    $cliente->rua = $cliente->rua ?? $ultimoPedido->rua;
                    $cliente->bairro = $cliente->bairro ?? $ultimoPedido->bairro;
                    $cliente->numero_residencia = $cliente->numero_residencia ?? $ultimoPedido->numero_residencia;
                    $cliente->complemento = $cliente->complemento ?? $ultimoPedido->complemento;
                }
            }

            // Calcula os totais dos pedidos deste cliente
            $pedidosCliente = Pedido::where('email', $email)->get();

            $cliente->total_pedidos = $pedidosCliente->count();
            $cliente->total_valor = $pedidosCliente->sum('valor_total');
            $cliente->total_pago = $pedidosCliente->sum('valor_pago');
            $cliente->saldo = $cliente->total_pago - $cliente->total_valor;

            $clientes->push($cliente);
        }

        return view('admin.Pessoas', compact('clientes'));
    }

    public function updateCliente(REQUEST $request)
    {
        dd($request->all());

        return back()->with('success', 'Dados do cliente atualizados com sucesso!');
    }
  
    public function storeAnotacao(Request $request, User $cliente)
    {

        dd($request->all(), $cliente);

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
