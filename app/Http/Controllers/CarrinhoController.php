<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
    public function IndexCarrinho()
    {
        $Carrinho = session('carrinho', []);
        $ids = array_keys($Carrinho);

        // Verifica quais IDs existem na tabela Cardapio
        $Itens = Cardapio::whereIn('id', $ids)->get();

        return view('User.Sacola', compact('Carrinho', 'Itens'));
    }

    public function show($id)
    {
        $Item = Cardapio::where('id', $id)
            ->first();

        if ($Item) {
            // Verifica a categoria do item
            $categoria = Categoria::find($Item->id_categoria);

            if ($categoria) {
                // Se a categoria for 'Primaria', retorna até 10 itens da categoria 'Secundaria'
                if ($categoria->nivel === 'Primaria') {
                    $Itens = Cardapio::whereHas('categoria', function ($query) {
                        $query->where('nivel', 'Secundaria');
                    })->limit(10)->get();

                    $Bebidas = Cardapio::where('id_categoria', '3')->get();
                }
                // Se a categoria for 'Secundaria', retorna todos os itens dessa categoria
                elseif ($categoria->nivel === 'Secundaria') {
                    $Itens = Cardapio::where('id_categoria', $categoria->id)
                        ->where('id', '!=', $Item->id) // Exclui o item com o ID de $Item
                        ->limit(10)
                        ->get();

                    $Bebidas = Cardapio::where('id_categoria', '3')->get();
                } else {
                    $Bebidas = Cardapio::where('id_categoria', $categoria->id)
                        ->where('id', '!=', $Item->id)
                        ->get();


                    if ($Bebidas->isNotEmpty()) {
                        return view("user.Item", compact('Item', 'Bebidas'));
                    } else {
                        return view("user.Item", compact('Item'));
                    }
                }
            }
        }

        return view("user.Item", compact('Item', 'Itens', 'Bebidas'));
    }

    public function SalvarSacola(Request $request)
    {
        $itens = $request->input('itens', []);

        $carrinho = [];
        foreach ($itens as $id => $item) {
            $carrinho[$id] = [
                'quantidade' => $item['quantidade'],
                'valor' => $item['valor'],
            ];
        }

        session(['carrinho' => $carrinho]);

        return view("user.FormaDePagamento");
    }

    public function SalvarPedido(Request $request)
    {
        $dados = $request->all();
        $carrinho = session('carrinho', []);

        // Processa item principal
        if (isset($dados['mainItem'])) {
            $item = $dados['mainItem'];
            $id = $item['id'];

            if (isset($carrinho[$id])) {
                // Se já existe, soma a quantidade
                $carrinho[$id]['quantidade'] += $item['quantity'];
            } else {
                // Se não existe, adiciona novo
                $carrinho[$id] = [
                    'quantidade' => $item['quantity'],
                    'valor' => $item['price']
                ];
            }
        }

        // Processa itens adicionais
        if (isset($dados['selectedItems'])) {
            foreach ($dados['selectedItems'] as $id => $item) {
                if (isset($carrinho[$id])) {
                    $carrinho[$id]['quantidade'] += $item['quantity'];
                } else {
                    $carrinho[$id] = [
                        'quantidade' => $item['quantity'],
                        'valor' => $item['price']
                    ];
                }
            }
        }

        // Processa bebidas (remove o prefixo 'bebida-')
        if (isset($dados['selectedDrinks'])) {
            foreach ($dados['selectedDrinks'] as $id => $item) {
                $cleanId = str_replace('bebida-', '', $id);
                if (isset($carrinho[$cleanId])) {
                    $carrinho[$cleanId]['quantidade'] += $item['quantity'];
                } else {
                    $carrinho[$cleanId] = [
                        'quantidade' => $item['quantity'],
                        'valor' => $item['price']
                    ];
                }
            }
        }

        // Salva observação separadamente se necessário
        if (isset($dados['observacao'])) {
            session(['observacao' => $dados['observacao']]);
        }

        // Atualiza a sessão
        session(['carrinho' => $carrinho]);

        return response()->json(['success' => true]);
    }
}
