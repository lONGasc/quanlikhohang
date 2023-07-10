<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function() {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/supplier',App\Http\Controllers\SupplierController::class);
    Route::resource('/customer',App\Http\Controllers\CustomerController::class)->only(['index','create','edit']);
    Route::resource('/category',App\Http\Controllers\CategoryController::class);
    Route::resource('/product',App\Http\Controllers\ProductController::class);
    Route::resource('/unit',App\Http\Controllers\UnitController::class);
    Route::resource('/purchase',App\Http\Controllers\PurchaseController::class);
    Route::get('/category/product/{id}',[App\Http\Controllers\PurchaseController::class,'getProduct'])->name('product.get');
    Route::resource('/invoice',App\Http\Controllers\InvoiceController::class);
    Route::get('/report/{type}', [App\Http\Controllers\HomeController::class, 'report'])->name('report');

});


