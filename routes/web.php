<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Home currently starts the table ordering flow from a default table.
Route::get('/', function () {
    return redirect()->route('menu.index', ['table' => 1]);
})->name('home');

// Menu routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

// Legacy customer home route kept as a redirect while the customer flow is consolidated.
Route::get('/customer/home', function () {
    return redirect()->route('menu.index', ['table' => 1]);
})->name('customer.home');

// Cart routes
Route::get('/cart', [MenuController::class, 'cart'])->name('cart.index');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');

// Checkout routes
Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');
Route::get('/checkout/success/{orderId}', [MenuController::class, 'checkoutSuccess'])
    ->name('checkout.success');


// ==========================================
// ADMIN ROUTES
// ==========================================

// Dashboard Utama
Route::get('/dashboard', function () {
    return view('admin.category.index'); 
})->name('admin.dashboard');

// Dummy route untuk mengatasi error href di sidebar (admin.menu.index)
Route::get('/dashboard/menu', function () {
    return "Halaman Kelola Menu Admin (Segera Hadir)";
})->name('admin.menu.index');

// Resource route untuk Category (URL-nya akan menjadi /categories)
Route::resource('categories', CategoryController::class)->names('admin.categories');

// Dummy route untuk Manajemen Karyawan
Route::get('/dashboard/users', function () {
    return "Halaman Manajemen Karyawan (Segera Hadir)";
})->name('admin.user.index');