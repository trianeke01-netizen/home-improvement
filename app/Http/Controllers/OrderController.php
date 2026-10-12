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

        if ($user->role_user !== 'pelanggan') {
            abort(403);
        }

        $order = Order::where('id_order', $id)->first();

        if (!$order) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->id_pelanggan != $user->id_user) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with('error', 'Anda tidak memiliki hak untuk membatalkan pesanan ini.');
        }

        if ($order->status === 'Dibatalkan') {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with('info', 'Pesanan ini sudah dibatalkan sebelumnya.');
        }

        if (in_array($order->status, ['Dikerjakan', 'Selesai'])) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with('error', 'Pesanan tidak dapat dibatalkan karena sedang dikerjakan atau telah selesai.');
        }

        if (!in_array($order->status, ['Menunggu', 'Dikonfirmasi', 'Pengajuan_Batal'])) {
            return redirect()
                ->route('dashboard.riwayat-order')
                ->with('error', 'Pesanan tidak dapat dibatalkan pada status saat ini.');
        }

        // Jika ada teknisi yang sudah menunjuk/dikonfirmasi, beri notifikasi
        if ($order->id_teknisi) {
            AppNotification::send(
                $order->id_teknisi,
                'Pesanan Dibatalkan Pelanggan',
                "Pelanggan telah membatalkan Pesanan #{$order->id_order}.",
                'order_dibatalkan',
                route('dashboard.teknisi.riwayat-order')
            );
        }

        $order->update([
            'status' => 'Dibatalkan',
        ]);

        return redirect()
            ->route('dashboard.riwayat-order')
            ->with('success', 'Pesanan berhasil dibatalkan.');
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
        | Cek apakah teknisi sedang memiliki orderan aktif
        |--------------------------------------------------------------------------
        */

        $adaOrderBerjalan = Order::where('id_teknisi', $user->id_user)
            ->whereIn('status', ['Dikonfirmasi', 'Dikerjakan', 'Diproses'])
            ->whereNull('waktu_pengajuan_batal')
            ->exists();

        if ($adaOrderBerjalan) {
            return back()->with(
                'error',
                'Anda masih memiliki pesanan yang sedang berjalan. Selesaikan pesanan tersebut terlebih dahulu sebelum menerima pesanan baru.'
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
            ->first();

        if (!$order) {
            return redirect()
                ->route('dashboard.teknisi')
                ->with(
                    'error',
                    'Maaf, pesanan ini sudah diambil oleh teknisi lain atau sudah tidak tersedia.'
                );
        }


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

            'waktu_diterima' =>
                now(),
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
            'Pesanan berhasil diterima dan dikonfirmasi. Harap tiba di lokasi pelanggan dalam batas waktu 1 jam.'
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
        | status = Menunggu
        | id_teknisi = NULL
        |
        | Sehingga teknisi lain dengan keahlian
        | yang sama masih dapat menerimanya.
        |
        */

        $excluded = $order->excluded_teknisi_ids ?? [];
        if (!in_array((int)$user->id_user, array_map('intval', $excluded))) {
            $excluded[] = (int)$user->id_user;
            $order->update(['excluded_teknisi_ids' => $excluded]);
        }

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
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan.');
        }

        if ($order->status === 'Dikerjakan') {
            return back()->with('success', 'Pesanan sudah dalam status dikerjakan.');
        }


        /*
        |--------------------------------------------------------------------------
        | Cek Batas Waktu 1 Jam Setelah Terima Order
        |--------------------------------------------------------------------------
        */

        if ($order->waktu_diterima && \Carbon\Carbon::parse($order->waktu_diterima)->addMinutes(60)->isPast()) {
            Order::releaseExpiredOrders();

            return back()->with(
                'error',
                'Batas waktu 1 jam untuk tiba di lokasi/mulai pengerjaan telah habis. Pesanan ini telah dialihkan untuk mencari teknisi pengganti.'
            );
        }


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
                "Teknisi {$user->nama} telah tiba di lokasi dan mulai mengerjakan Pesanan #{$order->id_order}.",
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
     * Wajib melampirkan foto bukti perbaikan.
     */
    public function selesai(Request $request, $id)
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
        | Validasi Foto Bukti Perbaikan (Wajib)
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'foto_bukti' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5048',
            ],
        ], [
            'foto_bukti.required' => 'Anda wajib melampirkan foto bukti perbaikan sebelum dapat menyelesaikan pesanan.',
            'foto_bukti.image' => 'File bukti perbaikan harus berupa gambar (JPG, JPEG, PNG, WebP).',
            'foto_bukti.max' => 'Ukuran foto bukti perbaikan maksimal 5MB.',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Cari order milik teknisi
        |--------------------------------------------------------------------------
        */

        $order = Order::where(
            'id_order',
            $id
        )
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->first();

        if (!$order) {
            return back()->with('error', 'Pesanan tidak ditemukan atau Anda tidak memiliki akses ke pesanan ini.');
        }

        if (in_array($order->status, ['Selesai', 'Dibatalkan', 'Ditolak'])) {
            return back()->with('error', 'Pesanan ini sudah selesai atau telah dibatalkan.');
        }


        /*
        |--------------------------------------------------------------------------
        | Upload Foto Bukti & Ubah status menjadi Selesai
        |--------------------------------------------------------------------------
        */

        $fotoBukti = $request->file('foto_bukti')->store('foto-bukti', 'public');

        $order->update([
            'status' => 'Selesai',
            'foto_bukti' => $fotoBukti,
        ]);

        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Pesanan Selesai',
                "Pesanan #{$order->id_order} telah selesai dikerjakan dengan bukti foto terlampir. Silakan berikan ulasan dan rating.",
                'order_selesai',
                route('dashboard.detail-order', $order->id_order)
            );
        }

        // Send confirmation notification to technician about released funds
        $formattedNominal = 'Rp ' . number_format($order->total_harga ?? 0, 0, ',', '.');
        AppNotification::send(
            $user->id_user,
            'Dana Pesanan Disalurkan',
            "Bukti foto berhasil diunggah! Pembayaran sebesar {$formattedNominal} untuk Pesanan #{$order->id_order} telah resmi disalurkan ke akun Anda.",
            'pembayaran_berhasil',
            route('dashboard.teknisi')
        );


        return back()->with(
            'success',
            "Pesanan #{$order->id_order} berhasil diselesaikan! Bukti foto tersimpan dan dana sebesar {$formattedNominal} telah disalurkan."
        );
    }

    /**
     * Teknisi mengajukan pembatalan / melaporkan kendala ke Admin.
     */
    public function ajukanBatalTeknisi(Request $request, $id)
    {
        $user = Auth::user();

        if ($user->role_user !== 'teknisi') {
            abort(403);
        }

        $validated = $request->validate([
            'alasan_batal_teknisi' => 'required|string|max:255',
            'catatan_batal_teknisi' => 'required|string|max:1000',
            'foto_kendala' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5048',
        ], [
            'alasan_batal_teknisi.required' => 'Pilih alasan utama kendala / pembatalan.',
            'catatan_batal_teknisi.required' => 'Tuliskan penjelasan catatan kendala yang dialami.',
            'foto_kendala.image' => 'File foto kendala harus berupa gambar (JPG, PNG, WebP).',
        ]);

        $order = Order::where('id_order', $id)
            ->where('id_teknisi', $user->id_user)
            ->firstOrFail();

        if (in_array($order->status, ['Selesai', 'Dibatalkan', 'Ditolak'])) {
            return back()->with('error', 'Pesanan ini sudah selesai atau dibatalkan.');
        }

        $fotoKendala = null;
        if ($request->hasFile('foto_kendala')) {
            $fotoKendala = $request->file('foto_kendala')->store('foto-kendala', 'public');
        }

        $excluded = $order->excluded_teknisi_ids ?? [];
        if (!in_array((int)$user->id_user, array_map('intval', $excluded))) {
            $excluded[] = (int)$user->id_user;
        }

        $order->update([
            'status' => 'Pengajuan_Batal',
            'alasan_batal_teknisi' => $validated['alasan_batal_teknisi'],
            'catatan_batal_teknisi' => $validated['catatan_batal_teknisi'],
            'foto_kendala' => $fotoKendala,
            'waktu_pengajuan_batal' => now(),
            'excluded_teknisi_ids' => $excluded,
        ]);

        // Kirim notifikasi ke Admin
        $admins = User::where('role_user', 'admin')->get();
        foreach ($admins as $admin) {
            AppNotification::send(
                $admin->id_user,
                'Pengajuan Pembatalan Teknisi',
                "Teknisi {$user->nama} mengajukan pembatalan untuk Pesanan #{$order->id_order}. Alasan: {$validated['alasan_batal_teknisi']}.",
                'pengajuan_batal',
                route('admin.orders')
            );
        }

        // Kirim notifikasi ke Pelanggan agar tahu teknisi terkendala & sistem akan mengalihkan
        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Teknisi Mengajukan Kendala',
                "Teknisi {$user->nama} mengajukan kendala kedatangan pada Pesanan #{$order->id_order} (Alasan: {$validated['alasan_batal_teknisi']}). Admin sedang memproses pengalihan teknisi pengganti.",
                'pengajuan_batal_pelanggan',
                route('dashboard.detail-order', $order->id_order)
            );
        }

        return back()->with(
            'success',
            "Pengajuan pembatalan untuk Pesanan #{$order->id_order} telah dikirim ke Admin. Harap tunggu verifikasi Admin."
        );
    }
}