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
        if($Item->categoria == "novo")
        {
            $idcategoria = $this->CriarCategoria($Item->newcategory);
        }
        else
        {
            $idcategoria = $Item->categoria;
        }

        $ItemCriado = Cardapio::updateOrCreate(
            ['nome' => $Item->Nome],
        [
            'nome' => $Item->Nome,
            'imagem' => $Item->Imagem,
            'descricao' => $Item->Descricao,
            'valor' => $Item->Valor,
            'desconto' => $request->Desconto ?? 0, 
            'disponibilidade' => $Item->Disponibilidade,
            'status' => 'ligado', // Valor default
            'ingredientes' => $Item->Igredientes,
            'id_categoria' => $idcategoria, // Referência à categoria (seja nova ou existente)
        ]);

        return $this->IndexCardapio();
    }

    public function CriarCategoria($nome)
    {
        $categoria = Categoria::firstOrCreate([
            'nome' => $nome,
        ]);

        return $categoria->id;
    }

    /*
        #parameters: array:10 [▼
      "_token" => "5uDzBXUHj9OfROAzOCoz8VlLXq7Jhqdy08p61j73"
      "Nome" => "asd"
      "Imagem" => "Diagrama em branco (2).png"
      "Descricao" => "asd"
      "Valor" => "asd"
      "categoria" => "novo"
      "c" => "asd"
      "Igredientes" => "asd"
      "Desconto" => "asd"
      "Disponibilidade" => "asd"
    ]

    #parameters: array:10 [▼
      "_token" => "5uDzBXUHj9OfROAzOCoz8VlLXq7Jhqdy08p61j73"
      "Nome" => "asd"
      "Imagem" => "Diagrama em branco (2).png"
      "Descricao" => "asd"
      "Valor" => "asd"
      "categoria" => "Complemento"
      "newcategory" => null
      "Igredientes" => "asd"
      "Desconto" => "asd"
      "Disponibilidade" => "asd"
    ]
    */
}
