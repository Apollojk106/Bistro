<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cardapio;

class CheckPedidoLigado
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $carrinho = session('carrinho', []);

        // Verifica se todos os itens do carrinho estão com status "ligado"
        $produtoIds = array_keys($carrinho);
        $produtos = Cardapio::whereIn('id', $produtoIds)->get();

        foreach ($produtos as $produto) {
            if ($produto->status != 'Ligado') {
                return redirect()->route('User.Cardapio')->with('error', 'Sistema esta indisponível, por favor, tente mais tarde.');
            }
        }

        return $next($request);
    }
}
