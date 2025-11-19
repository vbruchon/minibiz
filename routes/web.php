<?php

use App\Http\Controllers\BillController;
use App\Http\Controllers\CompanySettingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOptionController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');


    Route::prefix('bills')->name('bills.')->group(function () {
        Route::get('/', [BillController::class, 'index'])->name('index');
        Route::get('/create', [BillController::class, 'create'])->name('create');
        Route::post('/store', [BillController::class, 'store'])->name('store');
        Route::get('/{bill}', [BillController::class, 'show'])->name('show');
        Route::get('/{bill}/edit', [BillController::class, 'edit'])->name('edit');
        Route::put('/{bill}', [BillController::class, 'update'])->name('update');
        Route::patch('/{bill}/status', [BillController::class, 'updateStatus'])
            ->name('update-status');
        Route::post('/{bill}/convert', [BillController::class, 'convertQuoteToInvoice'])
            ->name('convert');
        Route::get('/bills/{bill}/pdf', [BillController::class, 'exportToPDF'])
            ->name('pdf');
        Route::delete('/{bill}', [BillController::class, 'destroy'])->name('delete');
    });

    Route::prefix('company-setup')->name('company-settings.')->group(function () {
        Route::get('/', [CompanySettingController::class, 'index'])->name('index');
        Route::post('/save', [CompanySettingController::class, 'save'])->name('save');
    });

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create', [CustomerController::class, 'create'])->name('create');
        Route::post('/store', [CustomerController::class, 'store'])->name('store');
        Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
        Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
        Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
        Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('delete');
    });

    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/{product}', [ProductController::class, 'show'])->name('show');
        Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('edit');
        Route::put('/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [ProductController::class, 'destroy'])->name('delete');
    });
    Route::prefix('products-options')->name('products-options.')->group(function () {
        Route::get('/', [ProductOptionController::class, 'index'])->name('index');
        Route::get('/create', [ProductOptionController::class, 'create'])->name('create');
        Route::post('/store', [ProductOptionController::class, 'store'])->name('store');
        Route::get('/{productOption}', [ProductOptionController::class, 'show'])->name('show');
        Route::get('/{productOption}/edit', [ProductOptionController::class, 'edit'])->name('edit');
        Route::put('/{productOption}', [ProductOptionController::class, 'update'])->name('update');
        Route::delete('/{productOption}', [ProductOptionController::class, 'destroy'])->name('delete');
        Route::post('/products/{product}/options-sync', [ProductOptionController::class, 'syncOptions'])
            ->name('sync');
    });
});
