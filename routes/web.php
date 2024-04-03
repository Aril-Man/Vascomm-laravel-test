<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/landing', [LandingController::class, 'index'])->name('landing');

Auth::routes();
Route::get('/', [LoginController::class, 'index']);
Route::get('/register', [LoginController::class, 'registerPage'])->name('registerPage');
Route::post('register', [LoginController::class, 'register'])->name('register');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::group(['middleware' => ['IsAdmin']], function () {
    Route::prefix('admin')->group(function() {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/user', [AdminController::class, 'userIndex'])->name('admin.user.index');
        Route::get('/user/{id}', [AdminController::class, 'getUserById'])->name('admin.user.detail');
        Route::patch('/user/update', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::get('/user/delete/{id}', [AdminController::class, 'deleteUser']);

        Route::post('user', [AdminController::class, 'storeUser'])->name('admin.user.store');

        Route::get('/products', [AdminController::class, 'productIndex'])->name('admin.product.index');
        Route::get('/product/{id}', [AdminController::class, 'getProductById'])->name('admin.product.detail');
        Route::get('/product/delete/{id}', [AdminController::class, 'deleteProduct']);
        Route::patch('/product/update', [AdminController::class, 'updateProduct'])->name('admin.product.update');




        Route::post('product', [AdminController::class, 'storeProduct'])->name('admin.product.store');
    });
});
