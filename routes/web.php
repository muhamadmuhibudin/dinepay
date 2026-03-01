<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Customer routes
Route::prefix('customer')->group(function () {
    Route::get('/welcome', function () {
        return view('customer.layout.welcome');
    })->name('customer.welcome');

    Route::get('/master', function () {
        return view('customer.layout.master');
    })->name('customer.master');
});

// Menu route
Route::get('/menu', function () {
    return view('customer.layout.menu'); 
})->name('menu.index');

// Contact route
Route::get('/contact', function () {
    return view('customer.layout.contact'); 
})->name('contact');

// Cart route
Route::get('/cart', function () {
    return view('customer.layout.cart'); 
})->name('cart.index');