<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pedido;
use App\Models\Anotacao;

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

            // Adiciona as anotações ao cliente
            $cliente->anotacoes = Anotacao::where('email', $email)
                ->orderBy('created_at', 'desc')
                ->get();

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

    public function updateCliente(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'valor_ajuste' => 'required|numeric|min:0.01',
            'tipo_ajuste' => 'required|in:adicionar,subtrair'
        ]);

        $email = $request->email;
        $valorAjuste = (float)$request->valor_ajuste;
        $tipoAjuste = $request->tipo_ajuste;

        // Busca pedidos não totalmente pagos (valor_pago < valor_total)
        $pedidos = Pedido::where('email', $email)
            ->whereColumn('valor_pago', '<', 'valor_total')
            ->orderBy('created_at', 'asc') // Mais antigos primeiro
            ->get();

        if ($pedidos->isEmpty()) {
            return back()->with('error', 'Nenhum pedido pendente encontrado para este cliente!');
        }

        // Lógica para distribuir o ajuste nos pedidos
        $valorRestante = $valorAjuste;

        foreach ($pedidos as $pedido) {
            $valorDevido = $pedido->valor_total - $pedido->valor_pago;

            if ($tipoAjuste === 'adicionar') {
                // Quanto podemos adicionar a este pedido
                $valorAplicado = min($valorRestante, $valorDevido);
                $pedido->valor_pago += $valorAplicado;
            } else {
                // Quanto podemos subtrair deste pedido (não pode ficar negativo)
                $valorAplicado = min($valorRestante, $pedido->valor_pago);
                $pedido->valor_pago -= $valorAplicado;
            }

            $pedido->save();
            $valorRestante -= $valorAplicado;

            if ($valorRestante <= 0) break;
        }

        // Atualiza apelido se fornecido
        if ($request->filled('apelido')) {
            $user = User::where('email', $email)->first();
            if ($user) {
                $user->apelido = $request->apelido;
                $user->save();
            }
        }

        $mensagem = $tipoAjuste === 'adicionar'
            ? "Valor de R$ {$valorAjuste} aplicado aos pedidos pendentes!"
            : "Valor de R$ {$valorAjuste} descontado dos pagamentos!";

        return back()->with('success', $mensagem);
    }

    public function storeAnotacao(Request $request)
    {
        $request->validate([
            'anotacao' => 'required|string|max:1000'
        ]);

        Anotacao::create([
            'email' => $request->email,
            'conteudo' => $request->anotacao
        ]);

        return back()->with('success', 'Anotação adicionada com sucesso!');
    }

    public function buscarAnotacoes(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $anotacoes = Anotacao::where('email', $request->email)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($anotacoes);
    }

    public function destroy(User $cliente)
    {
        $cliente->delete();
        return back()->with('success', 'Cliente excluído com sucesso!');
    }
}
