<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('dashboard.admin');
        } elseif ($user->isTeknisi()) {
            return redirect()->route('dashboard.teknisi');
        } else {
            return redirect()->route('dashboard.pelanggan');
        }
    }
}