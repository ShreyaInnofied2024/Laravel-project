<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

use App\Http\Controllers\OrderController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminDashboardController;

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



Route::middleware(['auth', 'isAdmin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('category', CategoryController::class);
    Route::delete('/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/digital-products', [ProductController::class, 'indexDigital'])->name('products.indexDigital');
    Route::get('/physical-products', [ProductController::class, 'indexPhysical'])->name('products.indexPhysical');
    Route::get('/users', [UserController::class, 'listUsers'])->name('users.list');
    Route::get('/product_admin', [ProductController::class, 'adminProduct'])->name('product_admin');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/admin/orders', [OrderController::class, 'admin_index'])->name('admin.orders.index');
    Route::patch('admin/orders/{id}', [OrderController::class, 'admin_update'])->name('admin.orders.update');
});




Route::middleware(['auth','customer'])->group(function () {
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
    Route::get('/payment/success/{order}', [OrderController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/cancel/{order}', [OrderController::class, 'paymentCancel'])->name('payment.cancel');
    Route::get('/change-password/{email}', [UserController::class, 'showChangePasswordForm'])->name('change-password-form');
    Route::post('/change-password/{email}', [UserController::class, 'changePassword'])->name('change-password');
    Route::get('/order/{id}', [OrderController::class, 'details'])->name('order.details');
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('addresses', [UserController::class, 'manageAddresses'])->name('user.addresses');
    Route::post('addresses/add', [UserController::class, 'addAddress'])->name('user.addAddress');
    Route::post('addresses/delete/{id}', [UserController::class, 'deleteAddress'])->name('user.deleteAddress');
    Route::match(['get', 'post'], 'addresses/edit/{id}', [UserController::class, 'editAddress'])->name('user.editAddress');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/increase/{product_id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::post('/cart/decrease/{product_id}', [CartController::class, 'decrease'])->name('cart.decrease');
    Route::post('/cart/remove/{product_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
});


Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');