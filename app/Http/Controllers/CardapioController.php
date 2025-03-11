<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CardapioController extends Controller
{
    public function IndexCardapio()
    {
        $Items = Cardapio::take(10)
            ->get();

        return $this->GetCardapio($Items);
    }

    public function CardapioFiltro(Request $request)
    {
        if ($request->categoria == "id_categoria") {

            $conteudo = Categoria::where('nome', $request->conteudo)
                ->first();

            $Items = Cardapio::where($request->categoria, 'like', '%' . $conteudo->id . '%')
                ->take(10)
                ->get();
        } else {
            $Items = Cardapio::where($request->categoria, 'like', '%' . $request->conteudo . '%')
                ->take(10)
                ->get();
        }

        return $this->GetCardapio($Items);
    }

    public function GetCardapio($Items)
    {
        $Categorias = $this->TodasCategorias();

        $Items = $this->PegarCategoria($Items);

        return view('admin.Cardapio', compact('Categorias', 'Items'));
    }

    public function PegarCategoria($Items)
    {
        foreach ($Items as $Item) {
            $Categoria = Categoria::where('id', $Item->id_categoria)
                ->first();

            $Item->categoria = $Categoria->nome;
        }

        return $Items;
    }

    public function TodasCategorias()
    {
        return Categoria::pluck('nome');
    }

    public function eyeOn(Request $request)
    {
        return $this->AlterarVisibilidade($request->categoria, "ligado");
    }

    public function eyeOff(Request $request)
    {
        return $this->AlterarVisibilidade($request->categoria, "desligado");
    }

    public function AlterarVisibilidade($Categoria, $Status)
    {
        $Categoria = Categoria::where('nome', $Categoria)
            ->first();

        $items = Cardapio::where('id_categoria', $Categoria->id)->get();

        // Atualiza o status de todos os itens para "ligado"
        foreach ($items as $item) {
            $item->status = $Status;
            $item->save();
        }

        return $this->IndexCardapio();
    }

    //Tela de Item

    public function SaveItem($Item)
    {
        // Processar o upload da imagem
        $imagemPath = null;
        if ($Item->hasFile('Imagem')) {
            $imagemPath = $Item->file('Imagem')->store('cardapio_imagens', 'public'); // Armazena a imagem na pasta "storage/app/public/cardapio_imagens"
        }

        if ($Item->categoria == "novo") {
            $idcategoria = $this->CriarCategoria($Item->newcategory);
        } else {
            $idcategoria = $Item->categoria;
        }

        $registroExistente = Cardapio::where('nome', $Item->Nome)->first();

        $ItemCriado = Cardapio::updateOrCreate(
            ['nome' => $Item->Nome],
            [
                'nome' => $Item->Nome,
                'imagem' => $imagemPath ?? $registroExistente->imagem,
                'descricao' => $Item->Descricao,
                'valor' => $Item->Valor,
                'desconto' => $request->Desconto ?? 0,
                'disponibilidade' => $Item->Disponibilidade,
                'status' => 'ligado', 
                'ingredientes' => $Item->Igredientes,
                'id_categoria' => $idcategoria, 
            ]
        );

        return $this->IndexCardapio();
    }

    public function CriarCategoria($nome)
    {
        $categoria = Categoria::firstOrCreate([
            'nome' => $nome,
        ]);

        return $categoria->id;
    }
}
