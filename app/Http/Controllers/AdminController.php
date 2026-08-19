<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\ProfileTeknisi;
use App\Models\Review;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * =========================================================
     * DASHBOARD UTAMA ADMIN
     * =========================================================
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Statistik Order
        |--------------------------------------------------------------------------
        */

        $totalOrder = Order::count();

        $orderMenunggu = Order::where(
            'status',
            'Menunggu'
        )->count();

        $orderDikerjakan = Order::whereIn(
            'status',
            [
                'Dikonfirmasi',
                'Dikerjakan',
                'Diproses',
            ]
        )->count();

        $orderSelesai = Order::where(
            'status',
            'Selesai'
        )->count();

        $totalPendapatan = Order::where(
            'status',
            'Selesai'
        )->sum('total_harga');


        /*
        |--------------------------------------------------------------------------
        | ORDER BULAN INI
        |--------------------------------------------------------------------------
        */

        $orderBulanIni = Order::whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();


        /*
        |--------------------------------------------------------------------------
        | Statistik Pengguna
        |--------------------------------------------------------------------------
        */

        $totalPelanggan = User::where(
            'role_user',
            'pelanggan'
        )->count();

        $totalTeknisi = User::where(
            'role_user',
            'teknisi'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Statistik Verifikasi Teknisi
        |--------------------------------------------------------------------------
        */

        $teknisiVerifikasiPending = ProfileTeknisi::where(
            'status_verifikasi',
            'Menunggu'
        )->count();

        $teknisiAktif = ProfileTeknisi::where(
            'status_verifikasi',
            'Disetujui'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Pesanan Terbaru
        |--------------------------------------------------------------------------
        */

        $pesananTerbaru = Order::with([
            'pelanggan',
            'teknisi',
            'subCategory.category',
        ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Teknisi Pending
        |--------------------------------------------------------------------------
        */

        $teknisiPending = ProfileTeknisi::with([
            'user',
            'category',
            'subCategory',
        ])
            ->where(
                'status_verifikasi',
                'Menunggu'
            )
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kategori / Layanan Terpopuler
        |--------------------------------------------------------------------------
        */

        $kategoriTerpopuler = SubCategory::with(
            'category'
        )
            ->withCount('orders')
            ->orderByDesc('orders_count')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Kirim Data ke Dashboard
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.admin',
            compact(
                'totalOrder',
                'orderMenunggu',
                'orderDikerjakan',
                'orderSelesai',
                'totalPendapatan',
                'totalPelanggan',
                'totalTeknisi',
                'orderBulanIni',
                'teknisiVerifikasiPending',
                'teknisiAktif',
                'pesananTerbaru',
                'teknisiPending',
                'kategoriTerpopuler'
            )
        );
    }


    /**
     * =========================================================
     * HALAMAN VERIFIKASI TEKNISI
     * =========================================================
     */
    public function verifikasiTeknisi(Request $request)
    {
        $status = $request->query(
            'status',
            'Menunggu'
        );


        $query = ProfileTeknisi::with([
            'user',
            'category',
            'subCategory',
        ]);


        if ($status !== 'semua') {
            $query->where(
                'status_verifikasi',
                $status
            );
        }


        $teknisis = $query
            ->latest()
            ->get();


        return view(
            'dashboard.admin-verifikasi-teknisi',
            compact(
                'teknisis',
                'status'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE STATUS VERIFIKASI TEKNISI
     * =========================================================
     */
    public function updateStatusVerifikasi(
        Request $request,
        $id
    ) {
        $request->validate([
            'status_verifikasi' => [
                'required',
                'in:Disetujui,Ditolak,Menunggu',
            ],
        ]);


        $profile = ProfileTeknisi::findOrFail(
            $id
        );


        $profile->update([
            'status_verifikasi' =>
                $request->status_verifikasi,
        ]);


        if (
            $request->status_verifikasi
            === 'Disetujui'
        ) {

            $statusText = 'disetujui';

        } elseif (
            $request->status_verifikasi
            === 'Ditolak'
        ) {

            $statusText = 'ditolak';

        } else {

            $statusText = 'diperbarui';
        }


        $namaTeknisi =
            $profile->user->nama
            ?? 'Teknisi';

        AppNotification::send(
            $profile->id_user,
            'Status Verifikasi Akun',
            "Status pendaftaran akun teknisi Anda telah {$statusText} oleh Admin.",
            'verifikasi',
            route('dashboard.teknisi.profil')
        );

        return back()->with(
            'success',
            "Akun teknisi {$namaTeknisi} berhasil {$statusText}."
        );
    }


    /**
     * =========================================================
     * HALAMAN KELOLA ORDER / TRANSAKSI
     * =========================================================
     */
    public function orders(Request $request)
    {
        $status = $request->query(
            'status'
        );


        $query = Order::with([
            'pelanggan',
            'teknisi',
            'subCategory.category',
            'review',
        ]);


        if ($status) {

            $query->where(
                'status',
                $status
            );
        }


        $orders = $query
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Teknisi Terverifikasi
        |--------------------------------------------------------------------------
        */

        $teknisiAktif = User::where(
            'role_user',
            'teknisi'
        )
            ->whereHas(
                'profileTeknisi',
                function ($q) {
                    $q->where(
                        'status_verifikasi',
                        'Disetujui'
                    );
                }
            )
            ->with(
                'profileTeknisi.subCategory'
            )
            ->get();


        return view(
            'dashboard.admin-orders',
            compact(
                'orders',
                'status',
                'teknisiAktif'
            )
        );
    }


    /**
     * =========================================================
     * ASSIGN TEKNISI KE ORDER
     * =========================================================
     */
    public function assignTeknisi(
        Request $request,
        $id
    ) {
        $request->validate([
            'id_teknisi' => [
                'required',
                'exists:users,id_user',
            ],
        ]);


        $order = Order::findOrFail(
            $id
        );


        $teknisi = User::where(
            'id_user',
            $request->id_teknisi
        )
            ->where(
                'role_user',
                'teknisi'
            )
            ->firstOrFail();


        $order->update([
            'id_teknisi' => $teknisi->id_user,
            'status' => 'Dikonfirmasi',
        ]);

        AppNotification::send(
            $teknisi->id_user,
            'Pesanan Ditugaskan',
            "Admin telah menugaskan Anda untuk menangani Pesanan #{$order->id_order}.",
            'order_masuk',
            route('dashboard.teknisi')
        );

        if ($order->id_pelanggan) {
            AppNotification::send(
                $order->id_pelanggan,
                'Teknisi Ditugaskan',
                "Pesanan #{$order->id_order} telah ditugaskan kepada Teknisi {$teknisi->nama}.",
                'order_diterima',
                route('dashboard.detail-order', $order->id_order)
            );
        }


        return back()->with(
            'success',
            "Order #{$order->id_order} berhasil dihubungkan dengan Teknisi {$teknisi->nama}. Status diubah menjadi Dikonfirmasi."
        );
    }


    /**
     * =========================================================
     * HALAMAN MANAJEMEN PENGGUNA
     * =========================================================
     */
    public function pengguna(
        Request $request
    ) {
        $role = $request->query(
            'role'
        );

        $search = $request->query(
            'q'
        );


        $query = User::with(
            'profileTeknisi.subCategory'
        );


        if ($role) {

            $query->where(
                'role_user',
                $role
            );
        }


        if ($search) {

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'nama',
                        'like',
                        "%{$search}%"
                    )
                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'no_hp',
                            'like',
                            "%{$search}%"
                        );
                }
            );
        }


        $users = $query
            ->latest()
            ->get();


        return view(
            'dashboard.admin-pengguna',
            compact(
                'users',
                'role',
                'search'
            )
        );
    }


    public function kategori()
    {
    $kategori = Category::with('subCategories')->get();

    return view('dashboard.admin-kelola-layanan', compact('kategori'));
    }

    public function storeKategori(
        Request $request
    ) {
        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:categories,nama_kategori',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);


        Category::create(
            $validated
        );


        return back()->with(
            'success',
            'Kategori layanan baru berhasil ditambahkan.'
        );
    }


    /**
     * =========================================================
     * EDIT KATEGORI
     * =========================================================
     */
    public function updateKategori(
        Request $request,
        $id
    ) {
        $kategori = Category::findOrFail(
            $id
        );


        $validated = $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:100',
                'unique:categories,nama_kategori,' .
                    $kategori->id_kategori .
                    ',id_kategori',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);


        $kategori->update(
            $validated
        );


        return back()->with(
            'success',
            'Kategori berhasil diperbarui.'
        );
    }


    /**
     * =========================================================
     * TAMBAH SUB-KATEGORI
     * =========================================================
     */
    public function storeSubKategori(
        Request $request
    ) {
        $validated = $request->validate([
            'id_kategori' => [
                'required',
                'exists:categories,id_kategori',
            ],

            'nama_sub_kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'harga_per_unit' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);


        SubCategory::create(
            $validated
        );


        return back()->with(
            'success',
            'Sub-kategori layanan baru berhasil ditambahkan.'
        );
    }


    /**
     * =========================================================
     * EDIT SUB-KATEGORI
     * =========================================================
     */
    public function updateSubKategori(
        Request $request,
        $id
    ) {
        $subKategori =
            SubCategory::findOrFail(
                $id
            );


        $validated = $request->validate([
            'id_kategori' => [
                'required',
                'exists:categories,id_kategori',
            ],

            'nama_sub_kategori' => [
                'required',
                'string',
                'max:100',
            ],

            'harga_per_unit' => [
                'required',
                'numeric',
                'min:0',
            ],
        ]);


        $subKategori->update(
            $validated
        );


        return back()->with(
            'success',
            'Sub-kategori berhasil diperbarui.'
        );
    }


    /**
     * =========================================================
     * STATISTIK ADMIN
     * =========================================================
     */
    public function statistik()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGGUNA
        |--------------------------------------------------------------------------
        */

        $totalPelanggan = User::where(
            'role_user',
            'pelanggan'
        )->count();


        $totalTeknisi = User::where(
            'role_user',
            'teknisi'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | STATUS TEKNISI
        |--------------------------------------------------------------------------
        */

        $teknisiDisetujui =
            ProfileTeknisi::where(
                'status_verifikasi',
                'Disetujui'
            )->count();


        $teknisiMenunggu =
            ProfileTeknisi::where(
                'status_verifikasi',
                'Menunggu'
            )->count();


        $teknisiDitolak =
            ProfileTeknisi::where(
                'status_verifikasi',
                'Ditolak'
            )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER
        |--------------------------------------------------------------------------
        */

        $totalOrder = Order::count();


        $orderMenunggu =
            Order::where(
                'status',
                'Menunggu'
            )->count();


        $orderDikonfirmasi =
            Order::where(
                'status',
                'Dikonfirmasi'
            )->count();


        $orderDikerjakan =
            Order::whereIn(
                'status',
                [
                    'Dikerjakan',
                    'Diproses',
                ]
            )->count();


        $orderSelesai =
            Order::where(
                'status',
                'Selesai'
            )->count();


        $orderDitolak =
            Order::where(
                'status',
                'Ditolak'
            )->count();


        $orderDibatalkan =
            Order::where(
                'status',
                'Dibatalkan'
            )->count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL TRANSAKSI SELESAI
        |--------------------------------------------------------------------------
        */

        $totalTransaksiSelesai =
            Order::where(
                'status',
                'Selesai'
            )->sum(
                'total_harga'
            );


        /*
        |--------------------------------------------------------------------------
        | ORDER BULAN INI
        |--------------------------------------------------------------------------
        */

        $orderBulanIni =
            Order::whereMonth(
                'created_at',
                now()->month
            )
                ->whereYear(
                    'created_at',
                    now()->year
                )
                ->count();


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI BULAN INI
        |--------------------------------------------------------------------------
        */

        $transaksiBulanIni =
            Order::where(
                'status',
                'Selesai'
            )
                ->whereMonth(
                    'created_at',
                    now()->month
                )
                ->whereYear(
                    'created_at',
                    now()->year
                )
                ->sum(
                    'total_harga'
                );


        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK 6 BULAN
        |--------------------------------------------------------------------------
        */

        $bulanLabels = [];

        $orderBulanan = [];

        $pendapatanBulanan = [];


        for (
            $i = 5;
            $i >= 0;
            $i--
        ) {

            $tanggal =
                now()->subMonths(
                    $i
                );


            $bulanLabels[] =
                $tanggal->translatedFormat(
                    'M'
                );


            $orderBulanan[] =
                Order::whereMonth(
                    'created_at',
                    $tanggal->month
                )
                    ->whereYear(
                        'created_at',
                        $tanggal->year
                    )
                    ->count();


            $pendapatanBulanan[] =
                Order::where(
                    'status',
                    'Selesai'
                )
                    ->whereMonth(
                        'created_at',
                        $tanggal->month
                    )
                    ->whereYear(
                        'created_at',
                        $tanggal->year
                    )
                    ->sum(
                        'total_harga'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | LAYANAN TERPOPULER
        |--------------------------------------------------------------------------
        */

        $layananTerpopuler =
            SubCategory::with(
                'category'
            )
                ->withCount(
                    'orders'
                )
                ->orderByDesc(
                    'orders_count'
                )
                ->take(5)
                ->get();


        /*
        |--------------------------------------------------------------------------
        | METODE PEMBAYARAN
        |--------------------------------------------------------------------------
        */

        $jumlahQris =
            Order::where(
                'metode_pembayaran',
                'QRIS'
            )->count();


        $jumlahTunai =
            Order::where(
                'metode_pembayaran',
                'Tunai'
            )->count();


        /*
        |--------------------------------------------------------------------------
        | REVIEW DAN RATING
        |--------------------------------------------------------------------------
        */

        $totalReview =
            Review::count();


        $rataRataRating =
            Review::avg(
                'rating'
            );


        $rataRataRating =
            $rataRataRating !== null
                ? round(
                    $rataRataRating,
                    1
                )
                : 0;


        /*
        |--------------------------------------------------------------------------
        | DISTRIBUSI RATING
        |--------------------------------------------------------------------------
        */

        $rating5 =
            Review::where(
                'rating',
                5
            )->count();


        $rating4 =
            Review::where(
                'rating',
                4
            )->count();


        $rating3 =
            Review::where(
                'rating',
                3
            )->count();


        $rating2 =
            Review::where(
                'rating',
                2
            )->count();


        $rating1 =
            Review::where(
                'rating',
                1
            )->count();


        /*
        |--------------------------------------------------------------------------
        | VARIABEL TAMBAHAN UNTUK VIEW STATISTIK
        |--------------------------------------------------------------------------
        */

        $totalPesanan = $totalOrder;
        $pesananSelesai = $orderSelesai;
        $sedangDikerjakan = $orderDikerjakan + $orderDikonfirmasi;
        $pesananDibatalkan = $orderDibatalkan + $orderDitolak;

        $grafikLabels = $bulanLabels;
        $grafikTotal = $orderBulanan;

        $grafikSelesai = [];
        for ($i = 5; $i >= 0; $i--) {
            $tanggal = now()->subMonths($i);
            $grafikSelesai[] = Order::where('status', 'Selesai')
                ->whereMonth('created_at', $tanggal->month)
                ->whereYear('created_at', $tanggal->year)
                ->count();
        }

        $kategoriStatistik = Category::all()->map(function ($cat) {
            $jumlah = Order::whereHas('subCategory', function ($q) use ($cat) {
                $q->where('id_kategori', $cat->id_kategori);
            })->count();

            return (object) [
                'nama_kategori' => $cat->nama_kategori,
                'jumlah'        => $jumlah,
            ];
        })->filter(function ($item) {
            return $item->jumlah > 0;
        })->values();

        if ($kategoriStatistik->isEmpty()) {
            $kategoriStatistik = Category::all()->map(function ($cat) {
                return (object) [
                    'nama_kategori' => $cat->nama_kategori,
                    'jumlah'        => 0,
                ];
            });
        }

        $topLayanan = SubCategory::withCount(['orders as jumlah_pesanan'])
            ->orderByDesc('jumlah_pesanan')
            ->take(5)
            ->get();

        $totalPendapatan = Order::sum('total_harga') ?? 0;
        $pendapatanSelesai = Order::where('status', 'Selesai')->sum('total_harga') ?? 0;
        $countOrderSelesai = Order::where('status', 'Selesai')->count();
        $rataRataPerPesanan = $countOrderSelesai > 0 ? round($pendapatanSelesai / $countOrderSelesai) : 0;

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.admin-statistik',
            compact(
                'totalPelanggan',
                'totalTeknisi',

                'teknisiDisetujui',
                'teknisiMenunggu',
                'teknisiDitolak',

                'totalOrder',
                'totalPesanan',
                'pesananSelesai',
                'sedangDikerjakan',
                'pesananDibatalkan',

                'orderMenunggu',
                'orderDikonfirmasi',
                'orderDikerjakan',
                'orderSelesai',
                'orderDitolak',
                'orderDibatalkan',

                'totalTransaksiSelesai',
                'totalPendapatan',
                'pendapatanSelesai',
                'rataRataPerPesanan',

                'orderBulanIni',
                'transaksiBulanIni',

                'bulanLabels',
                'orderBulanan',
                'pendapatanBulanan',

                'grafikLabels',
                'grafikTotal',
                'grafikSelesai',

                'kategoriStatistik',
                'topLayanan',
                'layananTerpopuler',

                'jumlahQris',
                'jumlahTunai',

                'totalReview',
                'rataRataRating',

                'rating5',
                'rating4',
                'rating3',
                'rating2',
                'rating1'
            )
        );
    }

    /**
     * =========================================================
     * PROFIL ADMIN
     * =========================================================
     */
    public function profil()
    {
        $user = auth()->user();
        return view('dashboard.admin-profil', compact('user'));
    }

    /**
     * =========================================================
     * UPDATE PROFIL ADMIN
     * =========================================================
     */
    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $user->id_user . ',id_user',
            'no_hp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_hp = $request->no_hp;
        $user->alamat = $request->alamat;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Admin berhasil diperbarui.');
    }
}