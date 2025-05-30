<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente; // Modelo para a tabela de clientes

class ItensPedidoController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('admin.Pessoas', compact('clientes'));
    }

    public function destroy($id)
    {
        // Busca o cliente pelo ID e o exclui
        $cliente = Cliente::findOrFail($id);
        $cliente->delete();

        // Redireciona de volta para a lista com uma mensagem de sucesso
        return redirect()->route('admin.pessoas.index')->with('success', 'Cliente excluído com sucesso!');
    }
}
