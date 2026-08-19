<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Membuat pesanan baru dari pelanggan.
     *
     * Status awal:
     * Menunggu
     *
     * Karena pelanggan belum mendapatkan teknisi.
     */
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Validasi data pesanan
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'id_sub_kategori' => [
                'required',
                'exists:sub_categories,id_sub_kategori',
            ],

            'jumlah_unit' => [
                'required',
                'integer',
                'min:1',
            ],

            'deskripsi_kerusakan' => [
                'required',
                'string',
            ],

            'alamat' => [
                'required',
                'string',
                'max:255',
            ],

            'jadwal' => [
                'required',
                'date',
            ],

            'foto_kerusakan' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'metode_pembayaran' => [
                'required',
                'in:qris,tunai',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Ambil data subkategori
        |--------------------------------------------------------------------------
        */

        $subKategori = SubCategory::findOrFail(
            $validated['id_sub_kategori']
        );


        /*
        |--------------------------------------------------------------------------
        | Hitung harga
        |--------------------------------------------------------------------------
        */

        $hargaPerUnit = $subKategori->harga_per_unit;

        $totalHarga =
            $hargaPerUnit * $validated['jumlah_unit'];


        /*
        |--------------------------------------------------------------------------
        | Upload foto kerusakan
        |--------------------------------------------------------------------------
        */

        $foto = null;

        if ($request->hasFile('foto_kerusakan')) {

            $foto = $request
                ->file('foto_kerusakan')
                ->store(
                    'foto-kerusakan',
                    'public'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Simpan order
        |--------------------------------------------------------------------------
        |
        | Saat pelanggan membuat pesanan:
        |
        | id_teknisi = NULL
        | status     = Menunggu
        |
        */

        $order = Order::create([

            'id_pelanggan' =>
                Auth::user()->id_user,

            'id_teknisi' =>
                null,

            'id_sub_kategori' =>
                $validated['id_sub_kategori'],

            'jumlah_unit' =>
                $validated['jumlah_unit'],

            'harga_per_unit' =>
                $hargaPerUnit,

            'deskripsi_kerusakan' =>
                $validated['deskripsi_kerusakan'],

            'foto_kerusakan' =>
                $foto,

            'alamat' =>
                $validated['alamat'],

            'jadwal' =>
                $validated['jadwal'],

            'status' =>
                'Menunggu',

            'total_harga' =>
                $totalHarga,

            'metode_pembayaran' =>
                $validated['metode_pembayaran'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Kirim Notifikasi Pemesanan ke Teknisi Terverifikasi & Tersedia (FR-03)
        |--------------------------------------------------------------------------
        */

        $teknisisEligible = User::where('role_user', 'teknisi')
            ->whereHas('profileTeknisi', function ($q) use ($validated) {
                $q->where('status_verifikasi', 'Disetujui')
                  ->where('status_ketersediaan', 'Tersedia')
                  ->where('id_sub_kategori', $validated['id_sub_kategori']);
            })->get();

        foreach ($teknisisEligible as $t) {
            AppNotification::send(
                $t->id_user,
                'Pesanan Baru Masuk!',
                "Ada pesanan baru {$subKategori->nama_sub_kategori} di area {$validated['alamat']}.",
                'order_masuk',
                route('dashboard.teknisi')
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Jika pembayaran menggunakan QRIS
        |--------------------------------------------------------------------------
        */

        if (
            $validated['metode_pembayaran'] === 'qris'
        ) {

            return redirect()->route(
                'dashboard.pembayaran-qris',
                $order->id_order
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Jika pembayaran menggunakan tunai
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard.riwayat-order')
            ->with(
                'success',
                'Pesanan berhasil dibuat.'
            );
    }


    /**
     * Pelanggan membatalkan pesanan.
     *
     * Syarat:
     * 1. User yang login adalah pelanggan
     * 2. Order milik pelanggan tersebut
     * 3. Status masih Menunggu
     * 4. Belum memiliki teknisi
     *
     * Status:
     *
     * Menunggu
     *      ↓
     * Dibatalkan
     */
    public function batalkan($id)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah pelanggan
        |--------------------------------------------------------------------------
        */

        if ($user->role_user !== 'pelanggan') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Cari order milik pelanggan
        |--------------------------------------------------------------------------
        |
        | Order hanya dapat dibatalkan jika:
        |
        | - ID order sesuai
        | - Milik pelanggan yang sedang login
        | - Status masih Menunggu
        | - Belum memiliki teknisi
        |
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'id_pelanggan',
                $user->id_user
            )
            ->where(
                'status',
                'Menunggu'
            )
            ->whereNull(
                'id_teknisi'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi Dibatalkan
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => 'Dibatalkan',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke riwayat order
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('dashboard.riwayat-order')
            ->with(
                'success',
                'Pesanan berhasil dibatalkan.'
            );
    }


    /**
     * Teknisi menerima pesanan.
     *
     * Status:
     *
     * Menunggu
     *      ↓
     * Dikonfirmasi
     *
     * Pada tahap ini teknisi SUDAH dipilih,
     * tetapi pekerjaan belum dimulai.
     */
    public function terima($id)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah teknisi
        |--------------------------------------------------------------------------
        */

        if ($user->role_user !== 'teknisi') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil profile teknisi
        |--------------------------------------------------------------------------
        */

        $profile = $user->profileTeknisi;


        if (!$profile) {

            return back()->with(
                'error',
                'Profil teknisi belum ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Cari order yang sesuai
        |--------------------------------------------------------------------------
        |
        | Order hanya bisa diterima jika:
        |
        | 1. Status masih Menunggu
        | 2. Belum memiliki teknisi
        | 3. Subkategori sesuai dengan keahlian teknisi
        |
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'status',
                'Menunggu'
            )
            ->whereNull(
                'id_teknisi'
            )
            ->where(
                'id_sub_kategori',
                $profile->id_sub_kategori
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Simpan teknisi dan ubah status
        |--------------------------------------------------------------------------
        |
        | SEBELUM:
        | status = Menunggu
        |
        | SESUDAH:
        | status = Dikonfirmasi
        |
        | Bukan Dikerjakan.
        |
        */

        $order->update([

            'id_teknisi' =>
                $user->id_user,

            'status' =>
                'Dikonfirmasi',
        ]);

        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Pesanan Diterima',
                "Pesanan #{$order->id_order} ({$order->subCategory->nama_sub_kategori}) telah diterima oleh Teknisi {$user->nama}.",
                'order_diterima',
                route('dashboard.detail-order', $order->id_order)
            );
        }


        return back()->with(
            'success',
            'Pesanan berhasil diterima dan dikonfirmasi.'
        );
    }


    /**
     * Teknisi menolak / melewati pesanan.
     *
     * Order tetap tersedia untuk teknisi
     * lain yang memiliki subkategori keahlian sama.
     */
    public function tolak($id)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah teknisi
        |--------------------------------------------------------------------------
        */

        if ($user->role_user !== 'teknisi') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil profile teknisi
        |--------------------------------------------------------------------------
        */

        $profile = $user->profileTeknisi;


        if (!$profile) {

            return back()->with(
                'error',
                'Profil teknisi belum ditemukan.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Cari order sesuai keahlian
        |--------------------------------------------------------------------------
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'status',
                'Menunggu'
            )
            ->whereNull(
                'id_teknisi'
            )
            ->where(
                'id_sub_kategori',
                $profile->id_sub_kategori
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Teknisi melewati order
        |--------------------------------------------------------------------------
        |
        | Tidak mengubah status order.
        |
        | Order tetap:
        |
        | status = Menunggu
        | id_teknisi = NULL
        |
        | Sehingga teknisi lain dengan keahlian
        | yang sama masih dapat menerimanya.
        |
        */

        return back()->with(
            'success',
            'Pesanan dilewati.'
        );
    }


    /**
     * Teknisi mulai mengerjakan pesanan.
     *
     * Status:
     *
     * Dikonfirmasi
     *      ↓
     * Dikerjakan
     *
     * Method ini hanya bisa dilakukan oleh
     * teknisi yang memiliki order tersebut.
     */
    public function mulaiDikerjakan($id)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah teknisi
        |--------------------------------------------------------------------------
        */

        if ($user->role_user !== 'teknisi') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Cari order milik teknisi
        |--------------------------------------------------------------------------
        |
        | Syarat:
        |
        | 1. ID order sesuai
        | 2. id_teknisi adalah teknisi yang sedang login
        | 3. Status = Dikonfirmasi
        |
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->where(
                'status',
                'Dikonfirmasi'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi Dikerjakan
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => 'Dikerjakan',
        ]);

        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Pengerjaan Dimulai',
                "Teknisi {$user->nama} telah mulai mengerjakan Pesanan #{$order->id_order}.",
                'order_dikerjakan',
                route('dashboard.detail-order', $order->id_order)
            );
        }


        return back()->with(
            'success',
            'Pesanan sekarang sedang dikerjakan.'
        );
    }


    /**
     * Teknisi menyelesaikan pesanan.
     *
     * Status:
     *
     * Dikerjakan
     *      ↓
     * Selesai
     *
     * Hanya teknisi yang menerima order
     * tersebut yang dapat menyelesaikannya.
     */
    public function selesai($id)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | Pastikan user adalah teknisi
        |--------------------------------------------------------------------------
        */

        if ($user->role_user !== 'teknisi') {
            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | Cari order milik teknisi
        |--------------------------------------------------------------------------
        |
        | Syarat:
        |
        | 1. ID order sesuai
        | 2. id_teknisi sesuai user login
        | 3. Status harus Dikerjakan
        |
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->where(
                'status',
                'Dikerjakan'
            )
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Ubah status menjadi Selesai
        |--------------------------------------------------------------------------
        */

        $order->update([
            'status' => 'Selesai',
        ]);

        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Pesanan Selesai',
                "Pesanan #{$order->id_order} telah selesai dikerjakan. Silakan berikan ulasan dan rating.",
                'order_selesai',
                route('dashboard.detail-order', $order->id_order)
            );
        }


        return back()->with(
            'success',
            'Pesanan berhasil diselesaikan.'
        );
    }
}