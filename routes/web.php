<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('user.Cardapio');
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
Route::get('/Item', [UserController::class, 'Item'])->name("User.Item");
Route::get('/Pagamento', [UserController::class, 'Pagamento'])->name("User.Pagamento");
Route::get('/Selecao', [UserController::class, 'Selecao'])->name("User.Selecao");
Route::get('/Localizacao', [UserController::class, 'Localizacao'])->name("User.Localizacao");
Route::get('/MeuPedido', [UserController::class, 'MeuPedido'])->name("User.MeuPedido");

//admin
Route::get('/admin/Dashboard', [UserController::class, 'Dashboard'])->name("Dashboard");
Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");
Route::get('/admin/Historico', [UserController::class, 'Historico'])->name("Historico");
Route::get('/admin/Cardapio', [UserController::class, 'Cardapio'])->name("Cardapio");
Route::get('/admin/ItemCardapio', [UserController::class, 'GetItemCardapio'])->name("ItemCardapio");
Route::post('/admin/ItemCardapio', [UserController::class, 'PostItemCardapio'])->name("PostItemCardapio");
Route::post('/admin/ItemCardapio/Save', [UserController::class, 'SaveItem'])->name("SaveItem");








