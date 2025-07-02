<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ok - api
Route::prefix('app')->name('auth.')->group(function () {
    Route::prefix('{guard}')->group(function () {
        Route::post('/login', [\App\Http\Controllers\Api\Auth\AuthController::class, 'login'])->name('login');
        Route::post('/register', [\App\Http\Controllers\Api\Auth\AuthController::class, 'register'])->name('register');
    });
});

// ok - api
Route::Post('/logout', [\App\Http\Controllers\Api\Auth\AuthController::class, 'logout'])->middleware(['auth:sanctum'])->name('logout');

// ok - api

Route::prefix('admin')->name('admin.')->middleware(['auth:admin-api'])->group(function () {
    Route::resource('categories', CategoryController::class); // ok - api

    Route::prefix('products')->name('products.')->group(function () {

        Route::get('/trash', [\App\Http\Controllers\Api\Admin\ProductController::class, 'trash'])->name('trash'); // ok - api
        Route::post('/restore/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class, 'restore'])->name('restore'); // ok - api
        Route::delete('/force-delete/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class, 'forceDelete'])->name('force-delete'); // ok - api

        Route::delete('delete-image/{id}', [\App\Http\Controllers\Api\Admin\ProductController::class, 'deleteImage'])->name('admin.products.image.delete'); // ok - api
    });
    Route::resource('products', \App\Http\Controllers\Api\Admin\ProductController::class); // ok - api
});

// ok - api
Route::resource('products', \App\Http\Controllers\Api\ProductController::class); // ok - api
Route::get('products/category/{id}', [\App\Http\Controllers\Api\ProductController::class, 'categoryProducts'])->name('products.category'); // ok - api

// ok - api
Route::prefix('cart')->middleware(['auth:user-api'])->group(function () {
    Route::get('/', [\App\Http\Controllers\Api\CartController::class, 'index'])->name('cart.index'); // ok -api
    Route::post('/add', [\App\Http\Controllers\Api\CartController::class, 'store'])->name('cart.add'); // ok - api
    Route::put('/update/{id}', [\App\Http\Controllers\Api\CartController::class, 'update'])->name('cart.update');  // ok - api
    Route::delete('/remove/{id}', [\App\Http\Controllers\Api\CartController::class, 'destroy'])->name('cart.remove');  //ok - api
});




