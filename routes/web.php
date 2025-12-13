<?php

use App\Http\Controllers\OrdemServicoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PagamentoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('ordensservico.index');
})->middleware('auth');

Route::middleware('auth')->group(function () {
    // Rotas de Ordens de Serviço
    Route::get('ordensservico', [OrdemServicoController::class, 'index'])->name('ordensservico.index');
    Route::get('ordensservico/{ordem}', [OrdemServicoController::class, 'show'])->whereNumber('ordem')->name('ordensservico.show');
    Route::get('ordensservico/{ordem}/edit', [OrdemServicoController::class, 'edit'])->name('ordensservico.edit');
    Route::put('ordensservico/{ordem}', [OrdemServicoController::class, 'update'])->name('ordensservico.update');
    
    Route::get('clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('clientes/{cliente}', [ClienteController::class, 'show'])->whereNumber('cliente')->name('clientes.show');
    
    Route::get('pdf/gerar/{ordem}', [PDFController::class, 'gerarOrdem'])->name('pdf.gerar');
    Route::get('pdf/visualizar/{ordem}', [PDFController::class, 'visualizarOrdem'])->name('pdf.visualizar');
});

// Rotas apenas para Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('ordensservico/create', [OrdemServicoController::class, 'create'])->name('ordensservico.create');
    Route::post('ordensservico', [OrdemServicoController::class, 'store'])->name('ordensservico.store');
    Route::delete('ordensservico/{ordem}', [OrdemServicoController::class, 'destroy'])->name('ordensservico.destroy');
    
    Route::get('clientes/create', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('clientes', [ClienteController::class, 'store'])->name('clientes.store');
    Route::get('clientes/{cliente}/edit', [ClienteController::class, 'edit'])->name('clientes.edit');
    Route::put('clientes/{cliente}', [ClienteController::class, 'update'])->name('clientes.update');
    Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');

    // Pagamentos (admin)
    Route::post('pagamentos', [PagamentoController::class, 'store'])->name('pagamentos.store');
    Route::delete('pagamentos/{pagamento}', [PagamentoController::class, 'destroy'])->name('pagamentos.destroy');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1'); // Max 5 tentativas por minuto
});

Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Rota pública para cliente ver sua ordem (sem login)
Route::get('ordem/{token}', [\App\Http\Controllers\PublicOrdemController::class, 'show'])->name('ordem.publica');

