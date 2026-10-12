<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');


/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | LOGIN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/login',
        [AuthController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [AuthController::class, 'login']
    );


    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/register',
        [AuthController::class, 'showRegister']
    )->name('register');

    Route::post(
        '/register',
        [AuthController::class, 'register']
    );


    /*
    |--------------------------------------------------------------------------
    | LUPA PASSWORD / RESET PASSWORD
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/forgot-password',
        [AuthController::class, 'showForgotPassword']
    )->name('password.request');

    Route::post(
        '/forgot-password',
        [AuthController::class, 'resetPassword']
    )->name('password.update');
});


/*
|--------------------------------------------------------------------------
| MIDTRANS NOTIFICATION
|--------------------------------------------------------------------------
|
| Route ini berada DI LUAR middleware auth karena notification
| dikirim langsung oleh server Midtrans.
|
*/

Route::post(
    '/midtrans/notification',
    [PaymentController::class, 'notification']
)->name('midtrans.notification');


/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD UTAMA
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard',
        [DashboardController::class, 'index']
    )->name('dashboard');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PELANGGAN
    |--------------------------------------------------------------------------
    */

    Route::prefix('dashboard')
        ->name('dashboard.')
        ->middleware('role:pelanggan')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD PELANGGAN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/pelanggan',
                [DashboardController::class, 'pelanggan']
            )->name('pelanggan');


            /*
            |--------------------------------------------------------------------------
            | PESAN LAYANAN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/pesan-layanan',
                [DashboardController::class, 'pesanLayanan']
            )->name('pesan-layanan');


            /*
            |--------------------------------------------------------------------------
            | RIWAYAT ORDER
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/riwayat-order',
                [DashboardController::class, 'riwayatOrder']
            )->name('riwayat-order');


            /*
            |--------------------------------------------------------------------------
            | PROFIL
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/profil',
                [DashboardController::class, 'profil']
            )->name('profil');


            /*
            |--------------------------------------------------------------------------
            | PEMBAYARAN QRIS - MIDTRANS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/pembayaran-qris/{id}',
                [PaymentController::class, 'show']
            )->name('pembayaran-qris');


            /*
            |--------------------------------------------------------------------------
            | MEMBUAT TRANSAKSI MIDTRANS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/pembayaran-midtrans/{id}',
                [PaymentController::class, 'create']
            )->name('pembayaran-midtrans');

            Route::post(
                '/pembayaran-midtrans/{id}/success',
                [PaymentController::class, 'success']
            )->name('pembayaran-midtrans.success');


            /*
            |--------------------------------------------------------------------------
            | SIMULASI PEMBAYARAN QRIS LAMA
            |--------------------------------------------------------------------------
            |
            | Dipertahankan sementara agar fitur lama tidak rusak.
            |
            */

            Route::post(
                '/pembayaran-qris/{id}/simulasi',
                [DashboardController::class, 'simulasiPembayaran']
            )->name('pembayaran-qris.simulasi');

        });


    /*
    |--------------------------------------------------------------------------
    | DETAIL ORDER
    |--------------------------------------------------------------------------
    | Dapat diakses oleh pelanggan dan teknisi.
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard/detail-order/{id}',
        [DashboardController::class, 'detailOrder']
    )->name('dashboard.detail-order');


    /*
    |--------------------------------------------------------------------------
    | ORDER PELANGGAN
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/order',
        [OrderController::class, 'store']
    )
        ->middleware('role:pelanggan')
        ->name('order.store');


    /*
    |--------------------------------------------------------------------------
    | BATALKAN ORDER
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/order/{id}/batalkan',
        [OrderController::class, 'batalkan']
    )
        ->middleware('role:pelanggan')
        ->name('order.batalkan');


    /*
    |--------------------------------------------------------------------------
    | REVIEW ORDER
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/order/{id}/review',
        [ReviewController::class, 'store']
    )
        ->middleware('role:pelanggan')
        ->name('order.review');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD TEKNISI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard/teknisi',
        [DashboardController::class, 'teknisi']
    )
        ->middleware('role:teknisi')
        ->name('dashboard.teknisi');


    /*
    |--------------------------------------------------------------------------
    | PROFIL TEKNISI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard/teknisi/profil',
        [DashboardController::class, 'profilTeknisi']
    )
        ->middleware('role:teknisi')
        ->name('dashboard.teknisi.profil');


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL TEKNISI
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/dashboard/teknisi/profil/update',
        [DashboardController::class, 'updateProfilTeknisi']
    )
        ->middleware('role:teknisi')
        ->name('dashboard.teknisi.profil.update');


    /*
    |--------------------------------------------------------------------------
    | STATUS KETERSEDIAAN TEKNISI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/dashboard/teknisi/ketersediaan',
        [DashboardController::class, 'updateKetersediaan']
    )
        ->middleware('role:teknisi')
        ->name('dashboard.teknisi.ketersediaan');


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT ORDER TEKNISI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dashboard/teknisi/riwayat-order',
        [DashboardController::class, 'riwayatOrderTeknisi']
    )
        ->middleware('role:teknisi')
        ->name('dashboard.teknisi.riwayat-order');


    /*
    |--------------------------------------------------------------------------
    | ORDER TEKNISI - TERIMA
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/dashboard/teknisi/order/{id}/terima',
        [OrderController::class, 'terima']
    )
        ->middleware('role:teknisi')
        ->name('order.terima');


    /*
    |--------------------------------------------------------------------------
    | ORDER TEKNISI - TOLAK
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/dashboard/teknisi/order/{id}/tolak',
        [OrderController::class, 'tolak']
    )
        ->middleware('role:teknisi')
        ->name('order.tolak');


    /*
    |--------------------------------------------------------------------------
    | ORDER TEKNISI - MULAI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/dashboard/teknisi/order/{id}/mulai',
        [OrderController::class, 'mulaiDikerjakan']
    )
        ->middleware('role:teknisi')
        ->name('order.mulai');


    /*
    |--------------------------------------------------------------------------
    | ORDER TEKNISI - SELESAI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/dashboard/teknisi/order/{id}/selesai',
        [OrderController::class, 'selesai']
    )
        ->middleware('role:teknisi')
        ->name('order.selesai');

    Route::post(
        '/dashboard/teknisi/order/{id}/ajukan-batal',
        [OrderController::class, 'ajukanBatalTeknisi']
    )
        ->middleware('role:teknisi')
        ->name('order.ajukan-batal');


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL PELANGGAN / USER
    |--------------------------------------------------------------------------
    */

    Route::put(
        '/profil',
        [DashboardController::class, 'updateProfil']
    )->name('profil.update');


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('dashboard/admin')
        ->name('admin.')
        ->group(function () {


            /*
            |--------------------------------------------------------------------------
            | DASHBOARD ADMIN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/',
                [AdminController::class, 'index']
            )->name('dashboard');


            /*
            |--------------------------------------------------------------------------
            | VERIFIKASI TEKNISI
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/verifikasi-teknisi',
                [AdminController::class, 'verifikasiTeknisi']
            )->name('teknisi.verifikasi');


            /*
            |--------------------------------------------------------------------------
            | UPDATE STATUS VERIFIKASI TEKNISI
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/verifikasi-teknisi/{id}',
                [AdminController::class, 'updateStatusVerifikasi']
            )->name('teknisi.update-verifikasi');


            /*
            |--------------------------------------------------------------------------
            | KELOLA ORDER / TRANSAKSI
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/orders',
                [AdminController::class, 'orders']
            )->name('orders');

            Route::post(
                '/orders/{id}/setujui-batal-reassign',
                [AdminController::class, 'setujuiBatalDanReassign']
            )->name('orders.setujui-batal-reassign');

            Route::post(
                '/orders/{id}/tolak-batal',
                [AdminController::class, 'tolakPengajuanBatal']
            )->name('orders.tolak-batal');


            /*
            |--------------------------------------------------------------------------
            | PENGGUNA
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/pengguna',
                [AdminController::class, 'pengguna']
            )->name('pengguna');


            /*
            |--------------------------------------------------------------------------
            | KELOLA KATEGORI
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/kategori',
                [AdminController::class, 'kategori']
            )->name('kategori');


            /*
            |--------------------------------------------------------------------------
            | TAMBAH KATEGORI
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/kategori/store',
                [AdminController::class, 'storeKategori']
            )->name('kategori.store');


            /*
            |--------------------------------------------------------------------------
            | EDIT KATEGORI
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/kategori/{id}',
                [AdminController::class, 'updateKategori']
            )->name('kategori.update');


            /*
            |--------------------------------------------------------------------------
            | TAMBAH SUB-KATEGORI
            |--------------------------------------------------------------------------
            */

            Route::post(
                '/sub-kategori/store',
                [AdminController::class, 'storeSubKategori']
            )->name('subkategori.store');


            /*
            |--------------------------------------------------------------------------
            | EDIT SUB-KATEGORI
            |--------------------------------------------------------------------------
            */

            Route::put(
                '/sub-kategori/{id}',
                [AdminController::class, 'updateSubKategori']
            )->name('subkategori.update');


            /*
            |--------------------------------------------------------------------------
            | STATISTIK ADMIN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/statistik',
                [AdminController::class, 'statistik']
            )->name('statistik');


            /*
            |--------------------------------------------------------------------------
            | PROFIL ADMIN
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/profil',
                [AdminController::class, 'profil']
            )->name('profil');

            Route::put(
                '/profil/update',
                [AdminController::class, 'updateProfil']
            )->name('profil.update');

        });


    /*
    |--------------------------------------------------------------------------
    | NOTIFIKASI
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/notifikasi/{id}/baca',
        [NotificationController::class, 'markAsRead']
    )->name('notifikasi.baca');

    Route::post(
        '/notifikasi/baca-semua',
        [NotificationController::class, 'markAllAsRead']
    )->name('notifikasi.baca-semua');


    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/logout',
        [AuthController::class, 'logout']
    )->name('logout');

});