<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\CarrinhoController;

Route::get('/', [UserController::class, 'UserCardapio']);
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

Route::get('/Item', [UserController::class, 'Item'])->name("User.Item");
Route::get('/Item/{id}', [CarrinhoController::class, 'show'])->name('item.get');


Route::get('/PagamentoPix', [UserController::class, 'PagamentoPix'])->name("User.Pix");
Route::get('/OpcaoPedido', [UserController::class, 'OpcaoPedido'])->name("User.OpcaoPedido");
Route::get('/Pagamento', [UserController::class, 'FormaPagamento'])->name("User.Pagamento");
Route::get('/Selecao', [UserController::class, 'Selecao'])->name("User.Selecao");
Route::get('/Localizacao', [UserController::class, 'Localizacao'])->name("User.Localizacao");
Route::get('/Sacola', [UserController::class, 'Sacola'])->name("User.Sacola");
Route::get('/VerPedido', [UserController::class, 'VerPedido'])->name("User.VerPedido");


//admin
Route::get('/admin/Dashboard', [PedidoController::class, 'IndexDashboard'])->name("Dashboard");
Route::get('/admin/Dashboard/Filtro', [PedidoController::class, 'IndexDashboard'])->name("Dashboard.get");
Route::post('/admin/Dashboard/Filtro', [PedidoController::class, 'FilterDashboard'])->name("Dashboard.filtro");

Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/pedidos/json', [PedidoController::class, 'getPedidosJson'])->name('pedidos.json');
Route::get('/admin/Pedidos/Avancar/{id}', [PedidoController::class, 'AvancarPedidos'])->name('Avancar.pedidos');

Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");
Route::post('/Configuracao/update', [ConfiguracaoController::class, 'updateConfiguracoes'])->name('admin.configuracao.update');
Route::post('/Configuracao/forma-pagamento', [ConfiguracaoController::class, 'gerenciarFormaPagamento'])->name('admin.configuracao.forma-pagamento');
Route::put('/Configuracao/forma-pagamento', [ConfiguracaoController::class, 'gerenciarFormaPagamento'])->name('admin.configuracao.forma-pagamento');

Route::put('/Configuracao/categoria/{id}', [ConfiguracaoController::class, 'atualizarCategoria'])->name('admin.configuracao.categoria.update');

Route::get('/admin/Historico', [PedidoController::class, 'PedidosConcluidos'])->name("Historico");
Route::post('/admin/Historico/Filtro', [PedidoController::class, 'HistoricoFiltro'])->name("Historico.filtro");

Route::get('/admin/Cardapio', [CardapioController::class, 'IndexCardapio'])->name("Cardapio");
Route::get('/eye-on', [CardapioController::class, 'eyeOn'])->name('rota-eye-on');
Route::get('/eye-off', [CardapioController::class, 'eyeOff'])->name('rota-eye-off');
Route::post('/admin/Cardapio/Filtro', [CardapioController::class, 'CardapioFiltro'])->name("Cardapio.Filtro");
Route::get('/admin/Cardapio/Delete{id}', [CardapioController::class, 'DeleteItem'])->name('DeleteItem');


Route::get('/admin/ItemCardapio', [UserController::class, 'GetItemCardapio'])->name("ItemCardapio");

Route::post('/admin/ItemCardapio', [UserController::class, 'EditItemCardapio'])->name("EditItemCardapio");

Route::post('/admin/ItemCardapio/Save', [UserController::class, 'SaveItem'])->name("SaveItem");









