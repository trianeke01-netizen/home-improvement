<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return match ($user->role_user) {
            'pelanggan' => redirect()->route('dashboard.pelanggan'),
            'teknisi'   => redirect()->route('dashboard.teknisi'),
            'admin'     => redirect()->route('dashboard.admin'),
            default     => redirect('/'),
        };
    }

    public function pelanggan()
    {
        return view('dashboard.pelanggan');
    }

    public function pesanLayanan()
    {
        return view('dashboard.pesan-layanan');
    }

    public function riwayatOrder()
    {
        return view('dashboard.riwayat-order');
    }

    public function profil()
    {
        return view('dashboard.profil');
    }

    public function storeOrder(Request $request)
    {
        //
    }

    public function updateProfil(Request $request)
    {
        //
    }
}