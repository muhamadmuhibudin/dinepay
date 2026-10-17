<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\DashboardController;
use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;

// ==========================================
// 1. PUBLIC & CUSTOMER ROUTES
// ==========================================
// Redirect main page directly to the customer menu (default table 1)
Route::get('/', function () {
    return redirect()->route('menu.index', ['table' => 1]);
})->name('home');

// Menu & Cart Routes
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/cart', [MenuController::class, 'cart'])->name('cart.index');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');

Route::patch('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear', [MenuController::class, 'clearCart'])->name('cart.clear');

// Checkout Routes
Route::get('/checkout', [MenuController::class, 'checkout'])->name('checkout');
Route::post('/checkout/store', [MenuController::class, 'storeOrder'])->name('checkout.store');
Route::get('/checkout/success/{orderId}', [MenuController::class, 'checkoutSuccess'])->name('checkout.success');


// ==========================================
// 2. AUTHENTICATED & ADMIN ROUTES
// ==========================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Access Global (All logged-in users can access)
    Route::get('/dashboard', function () {
    $today = Carbon::today();

    $data = [
        'categories' => Category::all(),
        'items'      => Item::all(),
        'orders'     => Order::all(),
        'users'      => User::all(),
        'roles'      => Role::all(),
        
        'todayOrders'  => \App\Models\Order::whereDate('created_at', $today)->count(),
        
        'todayRevenue' => \App\Models\Order::whereDate('created_at', $today)
                                           ->whereIn('status', ['settlement', 'cooked'])
                                           ->sum('grand_total'),
                                           
        'totalOrders'  => \App\Models\Order::count(),
        
        'totalRevenue' => \App\Models\Order::whereIn('status', ['settlement', 'cooked'])
                                           ->sum('grand_total'),
    ];
    
    return view('admin.dashboard', $data);
    })->name('dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'index']
    )->name('admin.dashboard');

    // Default Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // DinePay Admin Modules (URL prefix: /admin/... | Name prefix: admin....)
    Route::prefix('admin')->name('admin.')->group(function () {

        // --------------------------------------------------------
        // LEVEL 1: Can be accessed by Admin, Chef, and Cashier
        // --------------------------------------------------------
        Route::middleware(['role:admin,chef,cashier'])->group(function () {
            // Items / Menu
            Route::patch('items/{id}/update-status', [ItemController::class, 'updateStatus'])
                ->name('items.updateStatus');
            Route::resource('items', ItemController::class);

            // Orders
            Route::patch('orders/{id}/update-status', [OrderController::class, 'updateStatus'])
                ->name('orders.updateStatus');
            
            // Route Cashier 
            Route::patch('orders/{id}/settlement', [OrderController::class, 'settlement'])
                ->name('orders.settlement');
                
            // Route Chef 
            Route::patch('orders/{id}/process', [OrderController::class, 'process'])
                ->name('orders.process');
                
            Route::resource('orders', OrderController::class);
        });

        // --------------------------------------------------------
        // LEVEL 2: Just Admin and Chef
        // --------------------------------------------------------
        Route::middleware(['role:admin,chef'])->group(function () {
            // Categories
            Route::resource('categories', CategoryController::class);
        });

        // --------------------------------------------------------
        // LEVEL 3: Only Super Admin
        // --------------------------------------------------------
        Route::middleware(['role:admin'])->group(function () {
            // Users & Roles
            Route::resource('users', UserController::class);
            Route::resource('roles', RoleController::class);
        });

    });
});

require __DIR__.'/auth.php';