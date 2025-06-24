<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\admin;
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

Route::get('/', action: function () {
    return view('admin.categories.category');
});


Route::prefix('admin')->name('admin.')->middleware('auth:admin')->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::prefix('products')->name('products.')->group(function () {

        Route::get('/trash', [Admin\ProductController::class, 'trash'])->name('trash');
        Route::post('/restore/{id}', [Admin\ProductController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [Admin\ProductController::class, 'forceDelete'])->name('force-delete');

        Route::delete('delete-image/{id}', [Admin\ProductController::class, 'deleteImage'])->name('admin.products.image.delete');
    });
    Route::resource('products', Admin\ProductController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::get('products/airpods', [ProductController::class,'airPods'])->name('products.airpods');
Route::resource('products', ProductController::class);

