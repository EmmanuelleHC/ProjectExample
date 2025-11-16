<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
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
// PUBLIC
Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

// ADMIN ONLY
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('products', ProductController::class);
});

//BOTH ADMIN AND CLIENT
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
});


// CLIENT ONLY
Route::middleware(['auth', 'client'])->group(function () {
    Route::resource('cart', CartController::class);

    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('checkout', [TransactionController::class, 'checkout'])->name('transactions.checkout');
    Route::post('checkout', [TransactionController::class, 'processCheckout'])->name('transactions.processCheckout');
    Route::post('/payment', [PaymentController::class, 'processPayment'])->name('payment.process');
});
