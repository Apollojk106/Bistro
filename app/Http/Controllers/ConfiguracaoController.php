<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracao;
use App\Models\Categoria;
use App\Models\FormaPagamento;

class ConfiguracaoController extends Controller
{

    public function GetConfiguracao()
    {
        return Configuracao::orderBy('type')
            ->get();
    }

    public function updateConfiguracoes(Request $request)
    {
        $configs = $request->input('configs');

        foreach ($configs as $id => $config) {
            $configuracao = Configuracao::find($id);
            if ($configuracao) {
                $status = $config['status'] ?? $configuracao->status;

                $configuracao->update([
                    'status' => $status,
                    'valores1' => $config['valores1'] ?? $configuracao->valores1,
                    'valores2' => $config['valores2'] ?? $configuracao->valores2,
                ]);
            }
        }

        return redirect()->route('Configuracao')->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function gerenciarFormaPagamento(Request $request)
    {
        $formas = $request->input('forma');

        

        foreach ($formas as $id => $forma) {
            if ($id === 'new') {
                // Adicionar nova forma de pagamento
                FormaPagamento::create([
                    'nome' => $forma['nome'],
                    'taxa' => $forma['taxa'],
                ]);
            } else {
                // Editar ou deletar forma de pagamento existente
                $formaPagamento = FormaPagamento::find($id);
                if ($formaPagamento) {
                    if ($request->input('action') === 'edit') {
                        $formaPagamento->update([
                            'nome' => $forma['nome'],
                            'taxa' => $forma['taxa'],
                        ]);
                    } elseif ($request->input('action') === 'delete'.$formaPagamento->id) {
                        // Marcar como deletado (aplicando "soft delete" manualmente)
                        $formaPagamento->update([
                            'deleted_at' => now(),
                        ]);

                        break;
                    }
                }
            }
        }

        return redirect()->route('Configuracao')->with('success', 'Formas de pagamento atualizadas com sucesso!');
    }

    public function atualizarCategoria(Request $request, $id)
    {
        $categoria = Categoria::find($id);
        if ($categoria) {
            $categoria->update([
                'nivel' => $request->input('nivel'),
            ]);
        }

        return redirect()->route('Configuracao')->with('success', 'Categoria atualizada com sucesso!');
    }
}
