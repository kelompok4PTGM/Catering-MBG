<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;

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
    });

    Route::middleware('role:User')->group(function() {
        Route::get('/user/dashboard', [HomeController::class, 'userDashboard'])->name('user.dashboard');
    });
});
