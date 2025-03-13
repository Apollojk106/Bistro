<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;

class ConfiguracaoController extends Controller
{
    public function GetConfiguracao()
    {
        return Configuracao::orderBy('type')
        ->get();
    }
}
