<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('register', [UserController::class, 'register'])->name('register');
Route::post('/register', [UserController::class, 'register'])->name('register');


Route::get('login', [UserController::class, 'login'])->name('login');
Route::post('login', [UserController::class, 'login'])->name('login');

Route::get('logout', [UserController::class, 'logout'])->name('logout');

Route::get('change-password', [UserController::class, 'changePassword'])->name('change-password');
Route::post('change-password', [UserController::class, 'changePassword']);

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
});
