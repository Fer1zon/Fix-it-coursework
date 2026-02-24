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

//Auth::routes();
Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');
Route::get("/catalog", [App\Http\Controllers\HomeController::class, 'catalog'])->name('catalog');
Route::get("/cart", [App\Http\Controllers\HomeController::class, 'cart'])->name('cart')->middleware("auth");
Route::get("/orders", [App\Http\Controllers\HomeController::class, 'orders'])->name('orders')->middleware("auth");

Route::post("/catalog/add_to_cart/{id}", [App\Http\Controllers\HomeController::class, 'add_to_cart'])->name('add_cart')->middleware("auth");
Route::post("/catalog/remove/{id}", [App\Http\Controllers\HomeController::class, 'remove_from_cart'])->name('remove_cart')->middleware("auth");
Route::post("/order/create", [App\Http\Controllers\HomeController::class, 'create_order_c'])->name('create_order')->middleware("auth");



Route::get("/admin", [App\Http\Controllers\AdminController::class, 'index'])->name('admin_index')->middleware("isAdmin");
