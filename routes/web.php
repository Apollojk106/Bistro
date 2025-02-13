<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NavigationController;

Route::get('/', function () {
    return view('admin.Cardapio');
});

//user

//admin
Route::get('/admin/Dashboard', [NavigationController::class, 'Dashboard'])->name("Dashboard");
Route::get('/admin/Pedido', [NavigationController::class, 'Pedido'])->name("Pedidos");
Route::get('/admin/Configuracao', [NavigationController::class, 'Configuracao'])->name("Configuracao");
Route::get('/admin/Historico', [NavigationController::class, 'Historico'])->name("Historico");
Route::get('/admin/Cardapio', [NavigationController::class, 'Cardapio'])->name("Cardapio");





