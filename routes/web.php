<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;


use App\Http\Controllers\CartController;

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

Route::get('/', [ProductController::class, 'index'])->name('home');


Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register');


Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::get('/change-password/{email}', [UserController::class, 'showChangePasswordForm'])->name('change-password-form');
Route::post('/change-password/{email}', [UserController::class, 'changePassword'])->name('change-password');

Route::get('addresses', [UserController::class, 'manageAddresses'])->name('user.addresses');
Route::post('addresses/add', [UserController::class, 'addAddress'])->name('user.addAddress');
Route::post('addresses/delete/{id}', [UserController::class, 'deleteAddress'])->name('user.deleteAddress');
Route::match(['get', 'post'], 'addresses/edit/{id}', [UserController::class, 'editAddress'])->name('user.editAddress');

Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::delete('/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/products/digital', [ProductController::class, 'showDigitalProducts'])->name('products.digital');
    Route::get('/products/physical', [ProductController::class, 'showPhysicalProducts'])->name('products.physical');
    Route::get('/users', [UserController::class, 'listUsers'])->name('users.list');
    Route::get('/product_admin', [ProductController::class, 'adminProduct'])->name('product_admin');
});


Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/increase/{product_id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{product_id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});

use App\Http\Controllers\OrderController;

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/payment', [OrderController::class, 'payment'])->name('order.payment');
    Route::get('/success', [OrderController::class, 'success'])->name('order.success');
    Route::get('/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
    Route::get('/order/history', [OrderController::class, 'history'])->name('order.history');
    Route::get('/order/{order}', [OrderController::class, 'details'])->name('order.details');
    Route::post('/user/address', [UserController::class, 'addAddress'])->name('user.addAddress');
    Route::put('/addresses/update/{id}', [UserController::class, 'updateAddress'])->name('addresses.update');
    Route::delete('/addresses/delete/{id}', [UserController::class, 'deleteAddress'])->name('addresses.destroy');
    Route::post('/payment', [OrderController::class, 'payment'])->name('payment');
});
