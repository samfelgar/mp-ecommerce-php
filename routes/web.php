<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/result', [\App\Http\Controllers\HomeController::class, 'result'])->name('result');

Route::post('/detail', [\App\Http\Controllers\ProductController::class, 'detail'])->name('products.detail');

Route::post('/pay', [\App\Http\Controllers\ProductController::class, 'pay'])->name('products.payment');
