<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Cardapio;

class ValidarCarrinho
{
    public function handle(Request $request, Closure $next)
    {
        $carrinho = session('carrinho', []);

        if (empty($carrinho)) {
            return redirect()
                ->route('User.Cardapio')
                ->with('error', 'Seu carrinho está vazio!');
        }

        $hoje = now()->dayOfWeekIso;
        $removidos = [];

        //prato fora do dia
        foreach ($carrinho as $id => $item) {
            $cardapio = Cardapio::find($id);

            if (
                !$cardapio ||
                $cardapio->status !== 'ligado' ||
                !in_array($hoje, $cardapio->disponibilidade)
            ) {
                unset($carrinho[$id]);
                $removidos[] = $id;
            }
        }

        session(['carrinho' => $carrinho]);

        if (!empty($removidos)) {
            return redirect()
                ->route('User.Cardapio')
                ->with('error', 'Alguns itens foram removidos por indisponibilidade.');
        }

        return $next($request);
    }
}
