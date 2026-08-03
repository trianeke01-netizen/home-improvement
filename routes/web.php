<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard/pelanggan', function () {
        return view('dashboard.pelanggan');
    })->middleware('role:pelanggan')->name('dashboard.pelanggan');

    Route::get('/dashboard/teknisi', function () {
        return view('dashboard.teknisi');
    })->middleware('role:teknisi')->name('dashboard.teknisi');

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->middleware('role:admin')->name('dashboard.admin');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});