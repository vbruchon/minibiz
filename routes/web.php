<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard/customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/store', [CustomerController::class, 'store'])->name('store');
    Route::get('/edit/{customer}', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/update/{customer}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/delete/{customer}', [CustomerController::class, 'destroy'])->name('delete');
});
