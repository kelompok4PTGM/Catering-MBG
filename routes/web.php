<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\CateringController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Default dashboard will redirect based on role
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Role specific dashboards
    Route::middleware('role:Superadmin')->group(function() {
        Route::get('/superadmin/dashboard', [HomeController::class, 'superadminDashboard'])->name('superadmin.dashboard');
    });

    Route::middleware('role:Admin')->group(function() {
        Route::get('/admin/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // Catering Profile
        Route::get('/admin/catering/profile', [CateringController::class, 'profile'])->name('admin.catering.profile');
        Route::post('/admin/catering/profile', [CateringController::class, 'updateProfile'])->name('admin.catering.update');
        
        // Menu & Paket Routes
        Route::resource('admin/menu', MenuController::class);
        Route::resource('admin/paket', PaketController::class);

        // Admin Catering Incoming Orders (Strictly isolated by id_catering)
        Route::get('/admin/orders', [\App\Http\Controllers\AdminOrderController::class, 'index'])->name('admin.orders.index');
        Route::get('/admin/orders/{id}', [\App\Http\Controllers\AdminOrderController::class, 'show'])->name('admin.orders.show');
        Route::post('/admin/orders/{id}/status', [\App\Http\Controllers\AdminOrderController::class, 'updateStatus'])->name('admin.orders.status');
    });

    Route::middleware('role:User')->group(function() {
        Route::get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');
        
        // Checkout & User Order Routes
        Route::get('/checkout', [\App\Http\Controllers\OrderController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [\App\Http\Controllers\OrderController::class, 'store'])->name('checkout.store');
        Route::get('/user/orders', [\App\Http\Controllers\OrderController::class, 'userOrders'])->name('user.orders');
        Route::get('/user/orders/{id}', [\App\Http\Controllers\OrderController::class, 'userOrderDetail'])->name('user.orders.show');
        Route::post('/user/orders/{id}/pay', [\App\Http\Controllers\OrderController::class, 'pay'])->name('user.orders.pay');
    });

    // Public / Shared Cart Routes (accessible when logged in or viewing)
    Route::get('/catering/{id}', [\App\Http\Controllers\CateringStoreController::class, 'show'])->name('catering.show');
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove/{key}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
});
