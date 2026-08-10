<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // POS
    Route::get('pos', [PosController::class, 'index'])->name('pos.index');
    Route::post('pos/venta', [PosController::class, 'processSale'])->name('pos.sale');

    // Sales
    Route::get('ventas', [SaleController::class, 'index'])->name('sales.index');
    Route::get('ventas/{sale}', [SaleController::class, 'show'])->name('sales.show');
    Route::get('ventas/{sale}/recibo', [SaleController::class, 'receipt'])->name('sales.receipt');
    Route::get('ventas/{sale}/recibo-termica', [SaleController::class, 'thermalReceipt'])->name('sales.thermal-receipt');

    // Admin-only routes
    Route::middleware('admin')->group(function () {
        Route::resource('productos', ProductController::class)->parameters(['productos' => 'product']);
        Route::resource('categorias', CategoryController::class)->parameters(['categorias' => 'category']);

        Route::get('inventario', [InventoryController::class, 'index'])->name('inventory.index');
        Route::post('inventario/{product}/ajustar', [InventoryController::class, 'adjust'])->name('inventory.adjust');
        Route::get('inventario/historial', [InventoryController::class, 'history'])->name('inventory.history');

        Route::get('reportes', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reportes/ventas', [ReportController::class, 'sales'])->name('reports.sales');
        Route::get('reportes/productos', [ReportController::class, 'products'])->name('reports.products');
        Route::get('reportes/ganancias', [ReportController::class, 'profits'])->name('reports.profits');

        Route::post('ventas/{sale}/anular', [SaleController::class, 'void'])->name('sales.void');

        Route::get('configuracion', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('configuracion', [SettingsController::class, 'update'])->name('settings.update');
    });
});
