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
    });

    Route::middleware('role:User')->group(function() {
        Route::get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');
    });
});
