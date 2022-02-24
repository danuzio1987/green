<?php

use App\Http\Controllers\Cadastros\ArmazemController;
use App\Http\Controllers\Cadastros\ClienteController;
use App\Http\Controllers\Cadastros\FornecedorController;
use App\Http\Controllers\Cadastros\InsumoController;
use App\Http\Controllers\Cadastros\ProdutoController;
use App\Http\Controllers\Cadastros\TancagemController;
use App\Http\Controllers\Cadastros\UsinaController;
use App\Http\Controllers\ComprasGov\GovController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Movimento\AjusteController;
use App\Http\Controllers\Movimento\EmprestimoController;
use App\Http\Controllers\Movimento\MovimentoController;
use App\Http\Controllers\Movimento\SaleController;
use App\Http\Controllers\Movimento\TransferenciaController;
use App\Http\Controllers\Movimento\VendaController;
use App\Http\Controllers\Pedidos\PedidoController;
use App\Http\Controllers\Perfil\ProfileController;
use App\Http\Controllers\Permissoes\ACLController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\UserController;

Auth::routes(['verify' => true]);


Route::get('/', [DashboardController::class, 'home'])->middleware(['auth', 'verified'])->name('home');

/** DASHBOARDS */
Route::middleware(['auth', 'verified'])->prefix("dashboards")->group( function(){
    Route::get("/geral", [DashboardController::class, 'geral'])->name('geral');
    Route::get("/armazens", [DashboardController::class, 'armazens'])->name('vilarinho');
    Route::get("/sales", [DashboardController::class, 'vendas'])->name('sales');
    Route::get("/disponibilidades", [DashboardController::class, 'disponibilidades'])->name('disponibilidades');
    Route::get("/transfers", [DashboardController::class, 'transferencias'])->name('transfers');
    Route::resource('/extrato', MovimentoController::class);
});

/** CADASTROS */
Route::middleware(['auth', 'verified'])->prefix("cadastros")->group( function(){
    Route::get("/", [DashboardController::class, 'cadastros'])->name("cadastros");
    Route::resource("/usinas", UsinaController::class);
    Route::resource("/armazens", ArmazemController::class);
    Route::resource("/fornecedores", FornecedorController::class);
    Route::resource("/clientes", ClienteController::class);
    Route::resource("/insumos", InsumoController::class);
    Route::resource("/produtos", ProdutoController::class);
    Route::resource("/tancagem", TancagemController::class);
});

/** PEDIDOS */
Route::middleware(['auth', 'verified'])->prefix("pedidos")->group( function(){
    Route::resource("/pedidos", PedidoController::class);
    Route::get("/lista", [PedidoController::class, "lista"])->name("pedidos.lista");
});

/** MOVIMENTOS */
Route::middleware(['auth', 'verified'])->prefix("movimentos")->group( function(){
    Route::resource('/vendas', SaleController::class);
    Route::resource("/transferencias", TransferenciaController::class);
    Route::resource("/ajustes", AjusteController::class);
    Route::resource("/emprestimos", EmprestimoController::class);
});


/** CONFIGURAÇÕES */
Route::middleware(['auth', 'verified'])->prefix("configuracoes")->group( function(){
    Route::resource("/perfil", ProfileController::class);
    Route::get('/setpassword', [SetPasswordController::class, "create"])->name('setpassword');
    Route::post('/setpassword', [SetPasswordController::class, "store"])->name('setpassword.store');
    Route::resource('/acesso', ACLController::class);
});

Route::get('invitation/{user}', [UserController::class, 'invitation'])->name('invitation');


// locale Route
Route::get('lang/{locale}', [LanguageController::class, 'swap'])->name('lang-locale');

Route::get('licitacoes', [GovController::class, 'teste']);
