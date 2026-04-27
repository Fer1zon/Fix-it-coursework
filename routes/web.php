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
Route::get("/catalog/{service_id}", [App\Http\Controllers\HomeController::class, 'service_masters'])->name('service_masters');
Route::get("/catalog/call/{service_id}/{master_id}", [App\Http\Controllers\HomeController::class, 'call_master_page'])->name('call_master_page')->middleware('auth');
Route::post("/catalog/call", [App\Http\Controllers\HomeController::class, 'create_call_master'])->name('call_master')->middleware("auth");
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/profile/calls/decline', [App\Http\Controllers\HomeController::class, 'decline_call_master'])->name('call_decline')->middleware('auth');
Route::get('/reviews/send/{service_id}/{master_id}', [App\Http\Controllers\HomeController::class, 'send_review_page'])->name('send_review_page')->middleware('auth');
Route::post('/reviews/send', [App\Http\Controllers\HomeController::class, 'send_review'])->name('send_review')->middleware('auth');
Route::get("/our_us", [App\Http\Controllers\HomeController::class, 'our_us_page'])->name('our_us');

Route::get("/master/{master_id}", [App\Http\Controllers\HomeController::class, 'master_page'])->name('master_page');

Route::get("/admin", [App\Http\Controllers\AdminController::class, 'index'])->name('admin_index')->middleware("isAdmin");
Route::get("/admin/masters", [App\Http\Controllers\AdminController::class, 'masters'])->name('masters_manage')->middleware("isAdmin");
Route::post("/admin/masters/update", [App\Http\Controllers\AdminController::class, 'update_master'])->name('master_update')->middleware("isAdmin");
Route::post("/admin/masters/create", [App\Http\Controllers\AdminController::class, 'create_master'])->name('master_create')->middleware("isAdmin");
Route::get("admin/masters/delete/{id}", [App\Http\Controllers\AdminController::class, 'delete_master'])->name('master_delete')->middleware("isAdmin");

Route::get("/admin/masters/services/{master_id}", [App\Http\Controllers\AdminController::class, 'master_services'])->name('master_services')->middleware("isAdmin");
Route::post("/admin/masters/services/update", [App\Http\Controllers\AdminController::class, 'update_master_service'])->name('master_update_service')->middleware("isAdmin");
Route::post("/admin/masters/services/create", [App\Http\Controllers\AdminController::class, 'add_master_service'])->name('master_add_service')->middleware("isAdmin");
Route::get("/admin/masters/services/delete/{relation_id}", [App\Http\Controllers\AdminController::class, 'delete_master_service'])->name('master_delete_service')->middleware("isAdmin");

Route::get("/admin/categories", [App\Http\Controllers\AdminController::class, 'categories'])->name('admin_categories')->middleware("isAdmin");
Route::post("/admin/categories/update", [App\Http\Controllers\AdminController::class, 'update_category'])->name('admin_update_category')->middleware("isAdmin");
Route::post("/admin/categories/create", [App\Http\Controllers\AdminController::class, 'create_category'])->name('admin_create_category')->middleware("isAdmin");
Route::get("/admin/categories/delete/{id}", [App\Http\Controllers\AdminController::class, 'delete_category'])->name('admin_delete_category')->middleware("isAdmin");

Route::get("/admin/categories/{category_id}", [App\Http\Controllers\AdminController::class, 'services'])->name('admin_services')->middleware("isAdmin");
Route::post("/admin/categories/{category_id}/update", [App\Http\Controllers\AdminController::class, 'update_service'])->name('admin_update_service')->middleware("isAdmin");
Route::post("/admin/categories/{category_id}/create", [App\Http\Controllers\AdminController::class, 'create_service'])->name('admin_create_service')->middleware("isAdmin");
Route::get("/admin/categories/{category_id}/delete/{id}", [App\Http\Controllers\AdminController::class, 'delete_service'])->name('admin_delete_service')->middleware("isAdmin");

Route::get("/admin/calls_master", [App\Http\Controllers\AdminController::class, 'calls_master'])->name('admin_calls_master')->middleware("isAdmin");
Route::post("/admin/calls_master/update", [App\Http\Controllers\AdminController::class, 'update_call_master'])->name('admin_update_calls_master')->middleware("isAdmin");
Route::get("/admin/calls_master/delete/{id}", [App\Http\Controllers\AdminController::class, 'delete_call_master'])->name('admin_delete_calls_master')->middleware("isAdmin");
Route::get("/admin/users", [App\Http\Controllers\AdminController::class, 'users'])->name('admin_users')->middleware("isAdmin");
Route::post("/admin/users/update", [App\Http\Controllers\AdminController::class, 'user_update'])->name('admin_update_user')->middleware("isAdmin");
