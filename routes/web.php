<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;

// Default route → Home page
Route::get('/', function () {
    return view('customer.home');
})->name('home');

// Menu routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Customer routes
Route::prefix('customer')->group(function () {
    Route::get('/welcome', function () {
        return view('customer.welcome');
    })->name('customer.welcome');

    Route::get('/home', function () {
        return view('customer.home');
    })->name('customer.home');
});

// Cart routes
Route::get('/cart', [MenuController::class,'cart'])->name('cart.index');
Route::post('/cart/add', [MenuController::class,'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');

// Checkout routes
Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');

// Contact route (if contact.blade.php exists in customer folder)
Route::get('/contact', function () {
    return view('customer.contact'); 
})->name('contact');
