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
    public function index(Request $request)
    {
        $totalPelanggan = User::where('role_user', 'pelanggan')->count();
        $totalTeknisi = User::where('role_user', 'teknisi')->count();
        $jumlahPengguna = User::count();
        $jumlahTeknisi = $totalTeknisi;

        $jumlahMenunggu = ProfileTeknisi::where('status_verifikasi', 'Menunggu')->count();
        $teknisiVerifikasiPending = $jumlahMenunggu;
        $teknisiAktif = ProfileTeknisi::where('status_verifikasi', 'Disetujui')->count();

        $totalOrder = Order::count();
        $orderMenunggu = Order::where('status', 'Menunggu')->count();
        $orderDikonfirmasi = Order::where('status', 'Dikonfirmasi')->count();
        $orderDikerjakan = Order::whereIn('status', ['Dikerjakan', 'Diproses'])->count();
        $orderSelesai = Order::where('status', 'Selesai')->count();
        $orderDibatalkan = Order::where('status', 'Dibatalkan')->count();
        $orderDitolak = Order::where('status', 'Ditolak')->count();
        $orderPengajuanBatal = Order::where('status', 'Pengajuan_Batal')->count();

        $totalPesanan = $totalOrder;
        $pesananSelesai = $orderSelesai;
        $sedangDikerjakan = $orderDikerjakan + $orderDikonfirmasi;
        $pesananDibatalkan = $orderDibatalkan + $orderDitolak;

        $orderBulanIni = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $grafikLabels = [];
        $grafikTotal = [];
        $grafikSelesai = [];

        for ($i = 4; $i >= 0; $i--) {
            $startWeek = now()->subWeeks($i)->startOfWeek();
            $endWeek = now()->subWeeks($i)->endOfWeek();

            if ($startWeek->month === $endWeek->month) {
                $grafikLabels[] = $startWeek->format('j') . '-' . $endWeek->translatedFormat('j M');
            } else {
                $grafikLabels[] = $startWeek->translatedFormat('j M') . ' - ' . $endWeek->translatedFormat('j M');
            }

            $grafikTotal[] = Order::whereBetween('created_at', [$startWeek->startOfDay(), $endWeek->endOfDay()])->count();
            $grafikSelesai[] = Order::where('status', 'Selesai')
                ->whereBetween('created_at', [$startWeek->startOfDay(), $endWeek->endOfDay()])
                ->count();
        }

        $grafikBulanLabels = [];
        $grafikBulanTotal = [];
        $grafikBulanSelesai = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $startMonth = $date->copy()->startOfMonth();
            $endMonth = $date->copy()->endOfMonth();

            $grafikBulanLabels[] = $date->translatedFormat('M Y');
            $grafikBulanTotal[] = Order::whereBetween('created_at', [$startMonth, $endMonth])->count();
            $grafikBulanSelesai[] = Order::where('status', 'Selesai')
                ->whereBetween('created_at', [$startMonth, $endMonth])
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

        return view(
            'dashboard.admin',
            compact(
                'totalOrder',
                'orderMenunggu',
                'orderDikerjakan',
                'orderSelesai',
                'orderPengajuanBatal',
                'totalPendapatan',
                'totalPelanggan',
                'totalTeknisi',
                'orderBulanIni',
                'teknisiVerifikasiPending',
                'teknisiAktif',
                'jumlahPengguna',
                'jumlahTeknisi',
                'jumlahMenunggu',
                'totalPesanan',
                'pesananSelesai',
                'sedangDikerjakan',
                'pesananDibatalkan',
                'grafikLabels',
                'grafikTotal',
                'grafikSelesai',
                'grafikBulanLabels',
                'grafikBulanTotal',
                'grafikBulanSelesai',
                'kategoriStatistik',
                'topLayanan',
                'pendapatanSelesai',
                'rataRataPerPesanan'
            )
        );
    }

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


        return view(
            'dashboard.admin-orders',
            compact(
                'orders',
                'status'
            )
        );
    }

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

    public function statistik(Request $request)
    {
        return redirect()->route('admin.dashboard', $request->all());
    }

    public function profil()
    {
        $user = auth()->user();
        return view('dashboard.admin-profil', compact('user'));
    }

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

    public function setujuiBatalDanReassign($id)
    {
        $order = Order::with(['subCategory', 'pelanggan', 'teknisi'])->findOrFail($id);

        if (!in_array($order->status, ['Pengajuan_Batal', 'Dikonfirmasi', 'Dikerjakan'])) {
            return back()->with('error', 'Pesanan ini tidak dalam status pengajuan pembatalan.');
        }

        $oldTeknisiId = $order->id_teknisi;
        $oldTeknisiNama = $order->teknisi ? $order->teknisi->nama : 'Teknisi';

        $excludedIds = $order->excluded_teknisi_ids ?? [];
        if ($oldTeknisiId && !in_array((int)$oldTeknisiId, array_map('intval', $excludedIds))) {
            $excludedIds[] = (int)$oldTeknisiId;
        }

        $replacementTeknisi = User::where('role_user', 'teknisi')
            ->where('id_user', '!=', $oldTeknisiId)
            ->whereNotIn('id_user', $excludedIds)
            ->whereHas('profileTeknisi', function ($q) use ($order) {
                $q->where('status_verifikasi', 'Disetujui')
                  ->where('status_ketersediaan', 'Tersedia')
                  ->where('id_sub_kategori', $order->id_sub_kategori);
            })
            ->first();

        if ($replacementTeknisi) {
            $order->update([
                'id_teknisi' => $replacementTeknisi->id_user,
                'status' => 'Dikonfirmasi',
                'waktu_diterima' => now(),
                'excluded_teknisi_ids' => $excludedIds,
            ]);

            if ($order->id_pelanggan) {
                AppNotification::send(
                    $order->id_pelanggan,
                    'Pesanan Dialihkan Otomatis',
                    "Teknisi sebelumnya berhalangan. Pesanan #{$order->id_order} telah dialihkan otomatis oleh sistem ke Teknisi {$replacementTeknisi->nama}.",
                    'order_dialihkan',
                    route('dashboard.detail-order', $order->id_order)
                );
            }

            if ($oldTeknisiId) {
                AppNotification::send(
                    $oldTeknisiId,
                    'Pengajuan Batal Disetujui',
                    "Pengajuan pembatalan Pesanan #{$order->id_order} telah disetujui Admin. Pesanan berhasil dialihkan ke teknisi lain.",
                    'pengajuan_batal_disetujui',
                    route('dashboard.teknisi')
                );
            }
            AppNotification::send(
                $replacementTeknisi->id_user,
                'Pesanan Dialihkan ke Anda!',
                "Anda menerima pengalihan Pesanan #{$order->id_order} ({$order->subCategory->nama_sub_kategori}) di area {$order->alamat}. Harap segera menuju lokasi.",
                'order_masuk',
                route('dashboard.teknisi')
            );

            return back()->with(
                'success',
                "Pengajuan pembatalan disetujui. Pesanan #{$order->id_order} berhasil dialihkan otomatis oleh sistem ke Teknisi {$replacementTeknisi->nama}."
            );
        } else {
            $order->update([
                'status' => 'Menunggu',
                'id_teknisi' => null,
                'excluded_teknisi_ids' => $excludedIds,
            ]);
            $teknisisEligible = User::where('role_user', 'teknisi')
                ->where('id_user', '!=', $oldTeknisiId)
                ->whereNotIn('id_user', $excludedIds)
                ->whereHas('profileTeknisi', function ($q) use ($order) {
                    $q->where('status_verifikasi', 'Disetujui')
                      ->where('id_sub_kategori', $order->id_sub_kategori);
                })->get();

            foreach ($teknisisEligible as $t) {
                AppNotification::send(
                    $t->id_user,
                    'Pesanan Butuh Teknisi!',
                    "Ada pesanan terbuka #{$order->id_order} ({$order->subCategory->nama_sub_kategori}) di area {$order->alamat}.",
                    'order_masuk',
                    route('dashboard.teknisi')
                );
            }

            if ($order->id_pelanggan) {
                AppNotification::send(
                    $order->id_pelanggan,
                    'Sistem Mencarikan Teknisi Pengganti',
                    "Teknisi sebelumnya berhalangan. Pesanan #{$order->id_order} tetap aktif dan sistem sedang memproses pencarian teknisi pengganti lain untuk Anda.",
                    'mencari_teknisi_lagi',
                    route('dashboard.detail-order', $order->id_order)
                );
            }

            if ($oldTeknisiId) {
                AppNotification::send(
                    $oldTeknisiId,
                    'Pengajuan Batal Disetujui',
                    "Pengajuan pembatalan Pesanan #{$order->id_order} disetujui Admin. Pesanan telah dilepaskan dari akun Anda dan dikembalikan ke sistem.",
                    'pengajuan_batal_disetujui',
                    route('dashboard.teknisi')
                );
            }

            return back()->with(
                'success',
                "Pengajuan pembatalan disetujui. Pesanan #{$order->id_order} dilepaskan dari teknisi lama dan dikembalikan ke status 'Menunggu' agar sistem/teknisi lain dapat menerimanya."
            );
        }
    }

    public function tolakPengajuanBatal(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status !== 'Pengajuan_Batal') {
            return back()->with('error', 'Pesanan ini tidak dalam status pengajuan pembatalan.');
        }

        $order->update([
            'status' => 'Dikonfirmasi',
        ]);

        if ($order->id_teknisi) {
            AppNotification::send(
                $order->id_teknisi,
                'Pengajuan Batal Ditolak',
                "Pengajuan pembatalan Pesanan #{$order->id_order} ditolak oleh Admin. Harap tetap menuju lokasi dan menjalankan tugas sesuai jadwal.",
                'pengajuan_batal_ditolak',
                route('dashboard.teknisi')
            );
        }

        return back()->with('success', "Pengajuan pembatalan teknisi untuk Pesanan #{$order->id_order} ditolak.");
    }
}