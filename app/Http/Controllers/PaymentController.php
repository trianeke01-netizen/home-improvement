<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PaymentController extends Controller
{
    /**
     * Konfigurasi Midtrans Sandbox.
     */
    private function configureMidtrans(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.is_sanitized', true);
        Config::$is3ds = config('midtrans.is_3ds', true);
    }

    /**
     * Menampilkan halaman pembayaran dan membuat
     * transaksi Midtrans.
     */
    public function show($id)
    {
        $this->configureMidtrans();

        $order = Order::with([
            'subCategory',
            'payment',
        ])
            ->where('id_order', $id)
            ->where('id_pelanggan', auth()->user()->id_user)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Pastikan metode pembayaran Online
        |--------------------------------------------------------------------------
        */

        if (!in_array($order->metode_pembayaran, ['qris', 'online'])) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with(
                    'error',
                    'Pesanan ini tidak menggunakan pembayaran online.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Jika status order sudah Selesai, Dibatalkan, atau Ditolak
        |--------------------------------------------------------------------------
        */

        if (in_array($order->status, ['Selesai', 'Dibatalkan', 'Ditolak'])) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with(
                    'info',
                    'Pesanan ini sudah ' . strtolower($order->status) . ' dan tidak memerlukan pembayaran.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Jika pembayaran sudah berhasil
        |--------------------------------------------------------------------------
        */

        $existingPayment = Payment::where(
            'id_order',
            $order->id_order
        )
            ->whereIn('transaction_status', [
                'settlement',
                'capture',
            ])
            ->first();

        if ($existingPayment) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with(
                    'success',
                    'Pembayaran pesanan ini sudah berhasil.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada transaksi pending
        |--------------------------------------------------------------------------
        |
        | Gunakan transaksi yang sudah ada agar pelanggan tidak
        | mendapatkan transaksi Midtrans baru setiap kali refresh.
        |
        */

        $payment = Payment::where(
            'id_order',
            $order->id_order
        )
            ->where(
                'transaction_status',
                'pending'
            )
            ->first();

        try {
            $midtransOrderId =
                'ORDER-' .
                $order->id_order .
                '-' .
                now()->format('YmdHis') .
                '-' .
                strtoupper(substr(uniqid(), -5));

            $params = [
                'transaction_details' => [
                    'order_id' => $midtransOrderId,
                    'gross_amount' => (int) $order->total_harga,
                ],

                'item_details' => [
                    [
                        'id' => 'SERVICE-' . $order->id_order,
                        'price' => (int) $order->total_harga,
                        'quantity' => 1,
                        'name' => 'Layanan Perbaikan Rumah',
                    ],
                ],

                'customer_details' => [
                    'first_name' => auth()->user()->nama,
                    'email' => auth()->user()->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            if ($payment) {
                $payment->update([
                    'order_id_midtrans' => $midtransOrderId,
                    'gross_amount' => $order->total_harga,
                ]);
            } else {
                $payment = Payment::create([
                    'id_order' => $order->id_order,
                    'order_id_midtrans' => $midtransOrderId,
                    'gross_amount' => $order->total_harga,
                    'payment_method' => 'online',
                    'transaction_status' => 'pending',
                    'payout_status' => 'ditahan',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Tampilkan halaman pembayaran Midtrans
            |--------------------------------------------------------------------------
            */

            return view(
                'dashboard.pembayaran-midtrans',
                compact(
                    'order',
                    'snapToken'
                )
            );

        } catch (\Throwable $e) {

            return redirect()
                ->route('dashboard.riwayat-order')
                ->with(
                    'error',
                    'Gagal membuat pembayaran Midtrans: ' .
                    $e->getMessage()
                );
        }
    }

    /**
     * Method create tetap disediakan.
     *
     * Jika route lama menggunakan pembayaran-midtrans,
     * arahkan ke show().
     */
    public function create($id)
    {
        return $this->show($id);
    }

    /**
     * Format nama metode pembayaran dari Midtrans menjadi label yang rapi.
     */
    private function formatPaymentMethod(?string $paymentType, $raw = null): string
    {
        if (empty($paymentType) || in_array(strtolower($paymentType), ['online', 'pending'])) {
            return 'Pembayaran Online';
        }

        $type = strtolower($paymentType);

        if ($type === 'gopay') return 'GoPay';
        if ($type === 'qris') return 'QRIS';
        if ($type === 'shopeepay') return 'ShopeePay';
        if ($type === 'credit_card') return 'Kartu Kredit';
        if ($type === 'echannel') return 'Mandiri Virtual Account';
        if ($type === 'permata_va') return 'Permata Virtual Account';

        if ($type === 'bank_transfer') {
            $bank = null;
            if (is_array($raw) && isset($raw['va_numbers'][0]['bank'])) {
                $bank = $raw['va_numbers'][0]['bank'];
            } elseif (is_object($raw) && isset($raw->va_numbers[0]->bank)) {
                $bank = $raw->va_numbers[0]->bank;
            }
            if ($bank) {
                return strtoupper($bank) . ' Virtual Account';
            }
            return 'Virtual Account';
        }

        if ($type === 'cstore') {
            $store = is_array($raw) ? ($raw['store'] ?? 'Minimarket') : (is_object($raw) ? ($raw->store ?? 'Minimarket') : 'Minimarket');
            return ucfirst($store);
        }

        return ucwords(str_replace(['_', '-'], ' ', $paymentType));
    }

    /**
     * Konfirmasi pembayaran berhasil dari frontend.
     */
    public function success(Request $request, $id)
    {
        $order = Order::where('id_order', $id)
            ->where('id_pelanggan', auth()->user()->id_user)
            ->firstOrFail();

        $payment = Payment::where('id_order', $order->id_order)->first();

        if ($payment) {
            $rawType = $request->input('payment_type');
            $rawResult = $request->input('raw_result');
            $methodName = $this->formatPaymentMethod($rawType, $rawResult);

            $payment->update([
                'transaction_status' => 'settlement',
                'paid_at' => now(),
                'payment_method' => $methodName,
                'transaction_id' => $request->input('transaction_id', $payment->transaction_id),
            ]);
        }

        if ($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Pembayaran berhasil dikonfirmasi.',
                'redirect_url' => route('dashboard.riwayat-order'),
            ]);
        }

        return redirect()
            ->route('dashboard.riwayat-order')
            ->with('success', 'Pembayaran berhasil! Terima kasih.');
    }

    /**
     * Menerima notification dari Midtrans.
     */
    public function notification(Request $request)
    {
        $this->configureMidtrans();

        try {

            $notification = new Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $transactionId = $notification->transaction_id;

            /*
            |--------------------------------------------------------------------------
            | Cari payment berdasarkan order_id Midtrans
            |--------------------------------------------------------------------------
            */

            $payment = Payment::where(
                'order_id_midtrans',
                $orderId
            )->first();

            if (!$payment) {
                return response()->json([
                    'message' => 'Payment tidak ditemukan.',
                ], 404);
            }

            /*
            |--------------------------------------------------------------------------
            | Update transaksi
            |--------------------------------------------------------------------------
            */

            $methodName = $this->formatPaymentMethod($notification->payment_type, $notification);

            $payment->update([
                'transaction_id' => $transactionId,
                'transaction_status' => $transactionStatus,
                'payment_method' => $methodName,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Pembayaran berhasil
            |--------------------------------------------------------------------------
            |
            | Dana belum disalurkan ke teknisi.
            |
            */

            if (in_array($transactionStatus, [
                'settlement',
                'capture',
            ])) {

                $payment->update([
                    'paid_at' => now(),
                    'payout_status' => 'ditahan',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Pembayaran masih pending
            |--------------------------------------------------------------------------
            */

            if ($transactionStatus === 'pending') {

                $payment->update([
                    'payout_status' => 'ditahan',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Pembayaran gagal / dibatalkan / expired
            |--------------------------------------------------------------------------
            */

            if (in_array($transactionStatus, [
                'cancel',
                'deny',
                'expire',
                'failure',
            ])) {

                $payment->update([
                    'payout_status' => 'ditahan',
                ]);
            }

            return response()->json([
                'message' => 'Notification berhasil diproses.',
            ]);

        } catch (\Throwable $e) {

            return response()->json([
                'message' => 'Notification gagal diproses.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}