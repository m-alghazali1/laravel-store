<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\pay\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
// use App\Http\Controllers\UserController;
use App\Http\Controllers\admin;
use App\Http\Controllers\VendorController;
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

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::prefix('admin')->name('admin.')->middleware(['auth:admin,vendor', 'verified'])->group(function () {
    Route::resource('categories', CategoryController::class);

    Route::prefix('products')->name('products.')->group(function () {

        Route::get('/trash', [Admin\ProductController::class, 'trash'])->name('trash');
        Route::post('/restore/{id}', [Admin\ProductController::class, 'restore'])->name('restore');
        Route::delete('/force-delete/{id}', [Admin\ProductController::class, 'forceDelete'])->name('force-delete');

        Route::delete('delete-image/{id}', [Admin\ProductController::class, 'deleteImage'])->name('admin.products.image.delete');
    });
    Route::resource('products', Admin\ProductController::class);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


    // New Routs
    Route::get('/data', [AdminController::class, 'index'])->name('index');

    Route::resource('users',UserController::class);
    Route::get('/users/{user}/permissions', [UserController::class, 'editUserPermissions'])->name('user.edit-permissions');
    Route::put('/users/{user}/permissions', [UserController::class, 'updateUserPermissions'])->name('user.update-permissions');
    // Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    // Route::get('users/{id}', [Admin\UserController::class, 'show'])->name('users.show');
    // Route::delete('users/{id}', [Admin\UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('roles', RoleController::class);
    Route::resource('admins', AdminController::class);

    Route::resource('vendors', VendorController::class);

    Route::put('roles/permissions/edit', [RoleController::class, 'updateRolePermission'])->name('roles.update-permission');
});

Route::prefix('app')->middleware('guest:admin,vendor')->group(function () {
    Route::get('{guard}/login', [AuthController::class, 'showLogin'])->name('auth.login.show');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('{guard}/register', [AuthController::class, 'showRegister'])->name('auth.register.show');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

   Route::get('/{guard}/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
    Route::post('/{guard}/forgot-password', [AuthController::class, 'sendResetEmail'])->name('password.email');
    Route::get('/forgot-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/{guard}/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});


Route::get('products/category/{id}', [ProductController::class, 'categoryProducts'])->name('products.category');
Route::resource('products', ProductController::class)->only(['show', 'index',]);;


Route::prefix('cart')->middleware(['auth:user', 'verified'])->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{cart}', [CartController::class, 'store'])->name('cart.add');
    Route::post('/update/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{cart}', [CartController::class, 'destroy'])->name('cart.remove');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('app')->middleware(['auth:admin,user,vendor'])->group(function() {
    Route::get('email-verification', [AuthController::class, 'showVerifyEmail'])->name('verification.notice');
    Route::get('email-verification/request', [AuthController::class, 'requestEmailverification'])->middleware('throttle:5,1')->name('verification.request');
    Route::get('email-verification/{id}/{hash}', [AuthController::class, 'verifiyEmail'])->middleware('signed')->name('verification.verify');
});

Route::get('/checkout', [PaymentController::class, 'checkoutForm'])->name('checkout.form');
Route::post('/checkout', [PaymentController::class, 'checkout'])->name('checkout.charge');
//Route::get('/cart/debug', function () {
//    return \Illuminate\Support\Facades\Auth::guard('user')->check() ? 'Logged in as user' : 'Not logged in';
//});


