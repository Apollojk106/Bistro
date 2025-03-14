<?php

namespace App\Http\Controllers;

use App\Models\FormaPagamento;


class FormaPagamentoController extends Controller
{
    public function GetPagamento()
    {
        return FormaPagamento::whereNull('deleted_at')->get();
    }
}
