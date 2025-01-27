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
    Route::get('category', [CategoryController::class, 'index'])->name('category.index'); // Show all categories
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create'); // Show form to create category
    Route::post('category', [CategoryController::class, 'store'])->name('category.store'); // Store new category
    Route::get('category/{category}', [CategoryController::class, 'show'])->name('category.show'); // Show a single category
    Route::delete('category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy'); // Delete category
    Route::delete('/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/digital-products', [ProductController::class, 'indexDigital'])->name('products.indexDigital');
    Route::get('/physical-products', [ProductController::class, 'indexPhysical'])->name('products.indexPhysical');
    Route::get('/users', [UserController::class, 'listUsers'])->name('users.list');
    Route::get('/product_admin', [ProductController::class, 'adminProduct'])->name('product_admin');
    Route::patch('/users/become-seller/{id}', [UserController::class, 'becomeSeller'])->name('users.becomeSeller');
    Route::patch('/users/deactivate/{id}', [UserController::class, 'deactivateSeller'])->name('users.deactivate');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    Route::delete('/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('products.deleteImage');
    Route::get('/admin/orders', [OrderController::class, 'admin_index'])->name('admin.orders.index');
    Route::patch('admin/orders/{id}', [OrderController::class, 'admin_update'])->name('admin.orders.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});




Route::middleware(['auth', 'customer'])->group(function () {
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


Route::middleware(['auth', 'seller'])->group(function () {
    Route::get('/sellerdashboard', [AdminDashboardController::class, 'indexseller'])->name('seller.dashboard');
    Route::delete('seller/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('seller.products.deleteImage');
    Route::get('seller/digital-products', [ProductController::class, 'indexDigital'])->name('seller.products.indexDigital');
    Route::get('seller/physical-products', [ProductController::class, 'indexPhysical'])->name('seller.products.indexPhysical');
    Route::get('seller/product_admin', [ProductController::class, 'adminProduct'])->name('seller.product_admin');
    Route::get('seller/products/create', [ProductController::class, 'create'])->name('seller.products.create');
    Route::post('seller/products', [ProductController::class, 'store'])->name('seller.products.store');
    Route::get('seller/products/{product}/edit', [ProductController::class, 'edit'])->name('seller.products.edit');
    Route::put('seller/products/{product}', [ProductController::class, 'update'])->name('seller.products.update');
    Route::delete('seller/products/{product}', [ProductController::class, 'destroy'])->name('seller.products.destroy');
    Route::delete('seller/products/images/{imageId}', [ProductController::class, 'deleteImage'])->name('seller.products.deleteImage');
    Route::get('seller/category', [CategoryController::class, 'index'])->name('seller.category.index'); // Show all categories
    Route::get('seller/category/create', [CategoryController::class, 'create'])->name('seller.category.create'); // Show form to create category
    Route::post('seller/category', [CategoryController::class, 'store'])->name('seller.category.store'); // Store new category
    Route::get('seller/category/{category}', [CategoryController::class, 'show'])->name('seller.category.show'); // Show a single category
    Route::delete('seller/category/{category}', [CategoryController::class, 'destroy'])->name('seller.category.destroy'); // Delete category

});




Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/cart/add/{product_id}', [CartController::class, 'add'])->name('cart.add');
