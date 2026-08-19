<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Pelanggan memberikan ulasan dan rating pada order yang telah Selesai.
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'ulasan' => 'nullable|string|max:1000',
        ]);

        $order = Order::where('id_order', $id)
            ->where('id_pelanggan', Auth::user()->id_user)
            ->where('status', 'Selesai')
            ->firstOrFail();

        // Simpan atau update ulasan
        Review::updateOrCreate(
            ['id_order' => $order->id_order],
            [
                'rating' => $validated['rating'],
                'ulasan' => $validated['ulasan'] ?? null,
            ]
        );

        if ($order->id_teknisi) {
            AppNotification::send(
                $order->id_teknisi,
                'Ulasan & Rating Diterima',
                'Pelanggan ' . Auth::user()->nama . ' memberikan ulasan & rating ' . $validated['rating'] . ' bintang pada Pesanan #' . $order->id_order . '.',
                'ulasan_baru',
                route('dashboard.teknisi.profil')
            );
        }

        return back()->with('success', 'Terima kasih! Ulasan dan rating berhasil dikirim.');
    }
}
