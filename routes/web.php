<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController; // ← SALE bukan SALES

Route::get('/', function () {
    return redirect()->route('sales.create');
});

// Master Data Routes
Route::resource('customers', CustomerController::class);
Route::resource('products', ProductController::class);

// Transaksi Routes
Route::resource('sales', SaleController::class); // ← Nama class: SaleController
