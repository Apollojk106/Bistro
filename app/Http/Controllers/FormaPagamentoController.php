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
            'troco_para' => 'nullable|numeric|required_if:metodo_pagamento,dinheiro',
            'opcao_cartao' => 'nullable|numeric',
        ]);

        $pagamento = session()->get('pagamento', []);

        $pagamento['metodo'] = $request->metodo_pagamento;

        if ($request->metodo_pagamento === 'dinheiro') {
            $pagamento['troco_para'] = $request->troco_para;
        } else {
            unset($pagamento['troco_para']);
        }

        if($request->opcao_cartao != null)
        {
            $opcao = FormaPagamento::where('id', $request->opcao_cartao)
            ->first();

            $pagamento['metodo'] = $opcao->nome;
        }

        session()->put('pagamento', $pagamento);

        if ($request->metodo_pagamento === 'pix') {
            return redirect()->route("User.Pix");
        } else
        {      
            return redirect()->route("User.VerPedido");
        }
    }
}
