<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // POS & Sales (Admin & Cashier)
    Route::middleware('permission:pos.access')->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
        Route::post('/pos/checkout', [PosController::class, 'store'])->name('pos.store');
    });

    Route::middleware('permission:sale.view')->group(function () {
        Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
        Route::get('/sales/{sale}', [SaleController::class, 'show'])->name('sales.show');
        Route::get('/sales/{sale}/receipt', [SaleController::class, 'receipt'])->name('sales.receipt');
    });

    // Customers (Admin & Cashier)
    Route::middleware('permission:customer.view')->group(function () {
        Route::resource('customers', CustomerController::class);
    });

    // Master Data (Sirf Admin & Staff) - Cashier blocked
    Route::middleware('permission:category.view')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('units', UnitController::class);
        Route::resource('suppliers', SupplierController::class);
        Route::resource('products', ProductController::class);
        Route::resource('expenses', App\Http\Controllers\ExpenseController::class);
        Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/export', [App\Http\Controllers\ReportController::class, 'exportCsv'])->name('reports.export');
    });
});

require __DIR__.'/auth.php';