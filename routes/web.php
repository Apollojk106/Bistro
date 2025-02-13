<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('admin.Cardapio');
});

//user

//admin
Route::get('/admin/Dashboard', [UserController::class, 'Dashboard'])->name("Dashboard");
Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");
Route::get('/admin/Historico', [UserController::class, 'Historico'])->name("Historico");
Route::get('/admin/Cardapio', [UserController::class, 'Cardapio'])->name("Cardapio");





