<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('user.Cardapio');
});

//user


//admin
Route::get('/admin/Dashboard', [UserController::class, 'Dashboard'])->name("Dashboard");
Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");
Route::get('/admin/Historico', [UserController::class, 'Historico'])->name("Historico");
Route::get('/admin/Cardapio', [UserController::class, 'Cardapio'])->name("Cardapio");
Route::get('/admin/ItemCardapio', [UserController::class, 'GetItemCardapio'])->name("ItemCardapio");
Route::post('/admin/ItemCardapio', [UserController::class, 'PostItemCardapio'])->name("PostItemCardapio");
Route::post('/admin/ItemCardapio/Save', [UserController::class, 'SaveItem'])->name("SaveItem");








