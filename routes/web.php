<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    // Redirect umum setelah login, arahkan sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->middleware('role:pelanggan')->group(function () {
        Route::get('/pelanggan', [DashboardController::class, 'pelanggan'])->name('pelanggan');
        Route::get('/pesan-layanan', [DashboardController::class, 'pesanLayanan'])->name('pesan-layanan');
        Route::get('/riwayat-order', [DashboardController::class, 'riwayatOrder'])->name('riwayat-order');
        Route::get('/profil', [DashboardController::class, 'profil'])->name('profil');
    });

    Route::post('/order', [DashboardController::class, 'storeOrder'])->name('order.store');
    Route::put('/profil', [DashboardController::class, 'updateProfil'])->name('profil.update');

    Route::get('/dashboard/teknisi', function () {
        return view('dashboard.teknisi');
    })->middleware('role:teknisi')->name('dashboard.teknisi');

    Route::get('/dashboard/admin', function () {
        return view('dashboard.admin');
    })->middleware('role:admin')->name('dashboard.admin');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});