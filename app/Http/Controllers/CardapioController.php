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
        $hoje = now()->dayOfWeekIso;

        // Buscar categorias com cardápios ATIVOS e DISPONÍVEIS HOJE
        $categorias = Categoria::with(['cardapios' => function ($query) use ($hoje) {
            $query->where('status', 'ligado')
                ->whereJsonContains('disponibilidade', $hoje);
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
                            'imagem' => $item->imagem,
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
    public function SaveItem($request)
    {
        // Se tem ID, é edição
        $id = $request->input('id');

        if ($id) {
            $item = Cardapio::findOrFail($id);
        } else {
            $item = Cardapio::where('nome', $request->input('Nome'))->first();

            if (!$item) {
                $item = new Cardapio();
            }
        }

        // Determinar categoria
        $idcategoria = ($request->categoria == "novo")
            ? $this->CriarCategoria($request->newcategory)
            : $request->categoria;

        // Atualizar dados
        $item->nome = $request->input('Nome');
        $item->descricao = $request->input('Descricao');
        $item->valor = $request->input('Valor');
        $item->desconto = $request->input('Desconto', 0);
        $item->disponibilidade = $request->input('Disponibilidade');
        $item->status = 'ligado';
        $item->ingredientes = $request->input('Igredientes');
        $item->id_categoria = $idcategoria;

        $item->save();

        // Processar imagem se for enviada
        if ($request->hasFile('Imagem')) {
            // Excluir imagem anterior se existir
            if ($item->imagem && file_exists(public_path($item->imagem))) {
                unlink(public_path($item->imagem));
            }

            // Nome baseado no ID
            $nomeImagem = 'img' . $item->id . '.png';

            // Garantir diretório
            if (!file_exists(public_path('Storage'))) {
                mkdir(public_path('Storage'), 0755, true);
            }

            // Mover imagem
            $request->file('Imagem')->move(public_path('Storage'), $nomeImagem);

            // Atualizar caminho
            $item->imagem = 'Storage/' . $nomeImagem;
            $item->save();
        }

        return $item;
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
