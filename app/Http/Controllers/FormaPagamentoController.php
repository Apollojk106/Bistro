<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;
use Illuminate\Http\Request;

class FormaPagamentoController extends Controller
{
    public function GetPagamento()
    {
        return FormaPagamento::whereNull('deleted_at')->get();
    }

    public function SalvarFormaPagamento(Request $request)
    {
        // Validar os dados recebidos
        $request->validate([
            'metodo_pagamento' => 'required|in:pix,cartao,dinheiro',
            'troco_para' => 'nullable|numeric|required_if:metodo_pagamento,dinheiro'
        ]);

        // Recuperar ou inicializar a sessão de pagamento
        $pagamento = session()->get('pagamento', []);

        // Armazenar os dados na sessão
        $pagamento['metodo'] = $request->metodo_pagamento;

        if ($request->metodo_pagamento === 'dinheiro') {
            $pagamento['troco_para'] = $request->troco_para;
        } else {
            // Remove o troco se existir e não for dinheiro
            unset($pagamento['troco_para']);
        }

        // Atualizar a sessão
        session()->put('pagamento', $pagamento);

        // Redirecionar para a visualização do pedido
        return redirect()->route("User.VerPedido");
    }
}
