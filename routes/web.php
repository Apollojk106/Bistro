<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\CardapioController;
use App\Http\Controllers\ConfiguracaoController;
use App\Http\Controllers\CarrinhoController;
use App\Http\Controllers\FormaPagamentoController;
use App\Http\Controllers\ClientesController;

Route::get('/sessionData', [UserController::class, 'sessionData'])->name("sessionData");
Route::get('/', [UserController::class, 'UserCardapio']);

//login index
//user
Route::get('/Login', [UserController::class, 'Login'])->name("User.Login");
Route::post('/Login/Post', [UserController::class, 'PostLogin'])->name("User.Login.Post");

Route::get('/Cadastro', [UserController::class, 'Cadastro'])->name("User.Cadastro");
Route::post('/Cadastro/Post', [UserController::class, 'PostCadastro'])->name("User.Cadastro.Post");

Route::get('/Perfil', [UserController::class, 'Perfil'])->name("User.Perfil");
Route::post('/Save/Perfil', [UserController::class, 'SavePerfil'])->name("User.Save.Perfil");
Route::post('/Historico/id', [PedidoController::class, 'GetPedido'])->name("Pedido.Historico");
Route::get('/Logout', [UserController::class, 'Logout'])->name("User.Logout");

//Cardapio
Route::get('/Cardapio', [UserController::class, 'UserCardapio'])->name("User.Cardapio");
Route::get('/Item/{id}', [CarrinhoController::class, 'show'])->name('item.get');

Route::get('/PagamentoPix', [UserController::class, 'PagamentoPix'])->name("User.Pix");

Route::get('/OpcaoPedido', [UserController::class, 'OpcaoPedido'])->name("User.OpcaoPedido");
Route::post('/Salvar/OpcaoPedido', [CarrinhoController::class, 'SalvarOpcaoPedido'])->name("User.OpcaoPedido.Post");

Route::get('/Pagamento', [UserController::class, 'FormaPagamento'])->name("User.Pagamento");
Route::post('/Salvar/Pagamento', [FormaPagamentoController::class, 'SalvarFormaPagamento'])->name("User.Pagamento.Post");

Route::get('/Selecao', [UserController::class, 'Selecao'])->name("User.Selecao");

Route::get('/Localizacao', [UserController::class, 'Localizacao'])->name("User.Localizacao");

Route::get('/Sacola', [CarrinhoController::class, 'IndexCarrinho'])->name("User.Sacola");
Route::get('/Sacola/Limpar', [CarrinhoController::class, 'LimparCarrinho'])->name("User.Sacola.Limpar");

//Rotas Json
Route::post('/Salvar/pedido', [CarrinhoController::class, 'SalvarPedido'])->name('salvar.pedido');
Route::post('/Salvar/Sacola', [CarrinhoController::class, 'SalvarSacola'])->name('salvar.sacola');

Route::get('/Salvar/Selecao/{opcaoSelecionada}/{tipoOpcao}', [CarrinhoController::class, 'SalvarSelecao'])->name('salvar.selecao');
Route::get('/Salvar/Selecao/{opcaoSelecionada}/{tipoOpcao}/{horario}', [CarrinhoController::class, 'SalvarSelecaoHorario'])->name('salvar.selecao.horario');

Route::post('/Editar/pedido', [CarrinhoController::class, 'SalvarPedido'])->name('editar.item');

Route::get('/Pedido/Solicitado', [UserController::class, 'PedidoSolicitado'])->name("User.Pedido");
Route::get('/Pedido/User', [UserController::class, 'UltimoPedido'])->name("User.Ultimo.Pedido");

Route::get('/VerPedido', [UserController::class, 'VerPedido'])->name('User.VerPedido');
Route::get('/gerarPedido', [PedidoController::class, 'gerarPedido'])->name('Gerar.Pedido');

//admin
Route::get('/admin/Dashboard', [PedidoController::class, 'IndexDashboard'])->name("Dashboard");
Route::get('/admin/Dashboard/Filtro', [PedidoController::class, 'IndexDashboard'])->name("Dashboard.get");
Route::post('/admin/Dashboard/Filtro', [PedidoController::class, 'FilterDashboard'])->name("Dashboard.filtro");

Route::get('/admin', [UserController::class, 'Pedido'])->name("Index.Admin");
Route::get('/admin/Pedido', [UserController::class, 'Pedido'])->name("Pedidos");
Route::get('/pedidos/json', [PedidoController::class, 'getPedidosJson'])->name('pedidos.json');
Route::get('/admin/Pedidos/Avancar/{id}', [PedidoController::class, 'AvancarPedidos'])->name('Avancar.pedidos');
Route::get('/admin/Pedidos/Voltar/{id}', [PedidoController::class, 'VoltarPedidos'])->name('Voltar.pedidos');
Route::post('/Atualizar/Pedidos', [PedidoController::class, 'AtualizarPedidos'])->name('pedidos.confirmar-pagamento');

Route::get('/admin/Configuracao', [UserController::class, 'Configuracao'])->name("Configuracao");
Route::post('/Configuracao/update', [ConfiguracaoController::class, 'updateConfiguracoes'])->name('admin.configuracao.update');
Route::post('/Configuracao/forma-pagamento', [ConfiguracaoController::class, 'gerenciarFormaPagamento'])->name('admin.configuracao.forma-pagamento');
Route::put('/Configuracao/forma-pagamento', [ConfiguracaoController::class, 'gerenciarFormaPagamento'])->name('admin.configuracao.forma-pagamento');

Route::put('/Configuracao/categoria/{id}', [ConfiguracaoController::class, 'atualizarCategoria'])->name('admin.configuracao.categoria.update');

Route::get('/admin/Historico', [PedidoController::class, 'PedidosConcluidos'])->name("Historico");
Route::post('/admin/Historico/Filtro', [PedidoController::class, 'HistoricoFiltro'])->name("Historico.filtro");

Route::get('/admin/Cardapio', [CardapioController::class, 'IndexCardapio'])->name("Cardapio");
Route::post('/eye-on', [CardapioController::class, 'eyeOn'])->name('rota-eye-on');
Route::post('/eye-off', [CardapioController::class, 'eyeOff'])->name('rota-eye-off');
Route::post('/admin/Cardapio/Filtro', [CardapioController::class, 'CardapioFiltro'])->name("Cardapio.Filtro");
Route::get('/admin/Cardapio/Delete{id}', [CardapioController::class, 'DeleteItem'])->name('DeleteItem');
Route::delete('/admin/Cardapio/DeleteMultiple', [CardapioController::class, 'deleteMultiple']);


Route::get('/admin/ItemCardapio', [UserController::class, 'GetItemCardapio'])->name("ItemCardapio");
Route::post('/admin/ItemCardapio', [UserController::class, 'EditItemCardapio'])->name("EditItemCardapio");
Route::post('/admin/ItemCardapio/Save', [UserController::class, 'SaveItem'])->name("SaveItem");

Route::get('/admin/Pessoas', [ClientesController::class, 'index'])->name("Pessoas");
Route::post('/clientes/{cliente}/anotacoes', [ClientesController::class, 'storeAnotacao'])->name('admin.clientes.anotacoes.store');
Route::post('/admin/Pessoas', [ClientesController::class, 'updateCliente'])->name('admin.pessoas.update');
