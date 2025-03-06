<?php

use App\Http\Controllers\ProductController;
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

Route::get('/products', [ProductController::class, 'index']);

Route::get('/products/register', [ProductController::class,'registerView']);

Route::post('/products', [ProductController::class, 'register']);


Route::get('/products/search', [ProductController::class, 'search']);

Route::get('/products/sort', [ProductController::class, 'sort']);

Route::get('/products/reset_sort', [ProductController::class, 'resetSort']);

Route::get('/products/{productId}', [ProductController::class, 'show']);

Route::put('/products/{productId}/update', [ProductController::class, 'update']);

Route::delete('/products/{productId}/delete', [ProductController::class, 'destroy']);
