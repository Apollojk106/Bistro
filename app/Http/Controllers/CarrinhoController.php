<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CarrinhoController extends Controller
{
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

    public function SalvarPedido(Request $request)
    {
        $orderData = $request->input('orderData');

        session(['pedido' => $request->all()]);

        return response()->json(['success' => true]); 
    }
}
