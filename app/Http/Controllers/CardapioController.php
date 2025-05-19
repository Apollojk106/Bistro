<?php

namespace App\Http\Controllers;

use App\Models\Cardapio;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CardapioController extends Controller
{
    public function CardapioPorCategoria()
    {
        // Buscar todas as categorias e seus cardápios relacionados com status 'ligado'
        $categorias = Categoria::with(['cardapios' => function ($query) {
            $query->where('status', 'ligado');
        }])->get();

        // Formatar a resposta, dividindo o cardápio por categoria
        $cardapioPorCategoria = [];

        foreach ($categorias as $categoria) {
            // Filtrar novamente para garantir (embora o with já tenha filtrado)
            $cardapiosAtivos = $categoria->cardapios->where('status', 'ligado');

            // Só adiciona a categoria se tiver itens ativos
            if ($cardapiosAtivos->count() > 0) {
                $cardapioPorCategoria[] = [
                    'categoria' => $categoria->nome, // Nome da categoria
                    'itens' => $cardapiosAtivos->map(function ($item) {
                        return [
                            'id' => $item->id,
                            'nome' => $item->nome,
                            'descricao' => $item->descricao,
                            'valor' => $item->valor,
                            'desconto' => $item->desconto,
                            'disponibilidade' => $item->disponibilidade,
                            'ingredientes' => $item->ingredientes,
                        ];
                    }),
                ];
            }
        }

        return $cardapioPorCategoria;
    }

    public function IndexCardapio()
    {
        $Items = Cardapio::take(10)
            ->get();

        return $this->GetCardapio($Items);
    }

    public function CardapioFiltro(Request $request)
    {
        if ($request->categoria == "id_categoria") {
            try {
                $conteudo = Categoria::where('nome', $request->conteudo)
                    ->first();

                $Items = Cardapio::where($request->categoria, 'like', '%' . $conteudo->id . '%')
                    ->take(10)
                    ->get();
            } catch (\Exception $e) {
                $Items = collect();
            }
        } else {
            $Items = Cardapio::where($request->categoria, 'like', '%' . $request->conteudo . '%')
                ->take(10)
                ->get();
        }

        if ($Items->isEmpty()) {
            return redirect()->route("Cardapio")->with('error', 'Item não encontrado!');
        }

        return $this->GetCardapio($Items);
    }

    public function GetCardapio($Items)
    {
        $Items = $this->PegarCategoria($Items);

        return view('admin.Cardapio', compact('Items'));
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
        return $this->AlterarVisibilidade("ligado", $request->ids);
    }

    public function eyeOff(Request $request)
    {
        return $this->AlterarVisibilidade("desligado", $request->ids);
    }

    public function AlterarVisibilidade($status, $ids = [])
    {
        if (empty($ids)) {
            return redirect()->route('Cardapio')->with('error', 'Nenhum item selecionado.');
        }

        $items = Cardapio::whereIn('id', $ids)->get();

        foreach ($items as $item) {
            $item->status = $status;
            $item->save();
        }

        return redirect()->route('Cardapio')->with('success', 'Itens atualizados com sucesso.');
    }

    //Tela de Item
    public function SaveItem($Item)
    {
        $imagemPath = null;
        if ($Item->hasFile('Imagem')) {
            $imagemPath = $Item->file('Imagem')->store('cardapio_imagens', 'public');
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

    public function DeleteItem($id)
    {
        $item = Cardapio::find($id);

        if ($item) {
            $item->itensPedidos()->delete();
            $item->delete();

            return redirect()->route('Cardapio')->with('success', 'Item deletado com sucesso!');
        } else {
            return redirect()->route('Cardapio')->with('error', 'Item não encontrado!');
        }
    }

    public function deleteMultiple(Request $request)
    {
        $ids = $request->input('ids', []);

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $item = Cardapio::find($id);

                if ($item) {
                    $item->itensPedidos()->delete();
                    $item->delete();
                }
            }

            return redirect()->route('Cardapio')->with('success', 'Itens deletados com sucesso!');
        }

        return redirect()->route('Cardapio')->with('error', 'Nenhum item selecionado para exclusão.');
    }
}
