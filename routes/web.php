<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CardapioController;

Route::get('/', function () {
    return view('user.Cardapio');
});
Route::get('/admin', function () {
    return view('admin.Pedido');
});

//user
//login
Route::get('/Perfil', [UserController::class, 'Perfil'])->name("User.Perfil");
Route::get('/Login', [UserController::class, 'Login'])->name("User.Login");
Route::get('/Cadastro', [UserController::class, 'Cadastro'])->name("User.Cadastro");
//Cardapio
Route::get('/Cardapio', [UserController::class, 'UserCardapio'])->name("User.Cardapio");
Route::get('/Carrinho', [UserController::class, 'Carrinho'])->name("User.Carrinho");
Route::get('/Forma', [UserController::class, 'Forma'])->name("User.Forma");
Route::get('/OpcaoPedido', [UserController::class, 'OpcaoPedido'])->name("User.OpcaoPedido");
Route::get('/Pagamento', [UserController::class, 'Pagamento'])->name("User.Pagamento");
Route::get('/Selecao', [UserController::class, 'Selecao'])->name("User.Selecao");
Route::get('/Localizacao', [UserController::class, 'Localizacao'])->name("User.Localizacao");
Route::get('/MeuPedido', [UserController::class, 'MeuPedido'])->name("User.MeuPedido");

//admin
Route::get('/admin/Dashboard', [UserController::class, 'Dashboard'])->name("Dashboard");

Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/pedidos/json', [PedidoController::class, 'getPedidosJson'])->name('pedidos.json');
Route::get('/admin/Pedidos/Avancar/{id}', [PedidoController::class, 'AvancarPedidos'])->name('Avancar.pedidos');


Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");

Route::get('/admin/Historico', [PedidoController::class, 'PedidosConcluidos'])->name("Historico");
Route::post('/admin/Historico/Filtro', [PedidoController::class, 'HistoricoFiltro'])->name("Historico.filtro");

Route::get('/admin/Cardapio', [CardapioController::class, 'Cardapio'])->name("Cardapio");
Route::get('/admin/Cardapio/Filtro', [CardapioController::class, 'CardapioFiltro'])->name("Cardapio.Filtro");

Route::get('/admin/ItemCardapio', [UserController::class, 'GetItemCardapio'])->name("ItemCardapio");

Route::post('/admin/ItemCardapio', [UserController::class, 'PostItemCardapio'])->name("PostItemCardapio");

Route::post('/admin/ItemCardapio/Save', [UserController::class, 'SaveItem'])->name("SaveItem");









