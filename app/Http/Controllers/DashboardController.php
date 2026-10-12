<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\ProfileTeknisi;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        return match ($user->role_user) {
            'pelanggan' => redirect()->route('dashboard.pelanggan'),
            'teknisi'   => redirect()->route('dashboard.teknisi'),
            'admin'     => redirect()->route('admin.dashboard'),
            default     => redirect('/'),
        };
    }

    public function pelanggan()
    {
        Order::releaseExpiredOrders();

        $userId = Auth::user()->id_user;

        $totalOrder = Order::where(
            'id_pelanggan',
            $userId
        )->count();

        $sedangBerjalan = Order::where(
            'id_pelanggan',
            $userId
        )
            ->whereIn('status', [
                'Menunggu',
                'Dikonfirmasi',
                'Dikerjakan',
            ])
            ->count();

        $selesai = Order::where(
            'id_pelanggan',
            $userId
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();

        $orderAktif = Order::with([
            'subCategory.category',
            'teknisi',
            'payment',
        ])
            ->where(
                'id_pelanggan',
                $userId
            )
            ->whereIn('status', [
                'Menunggu',
                'Dikonfirmasi',
                'Dikerjakan',
            ])
            ->latest()
            ->take(1)
            ->get();

        $riwayatOrder = Order::with([
            'subCategory.category',
            'teknisi',
            'payment',
            'review',
        ])
            ->where(
                'id_pelanggan',
                $userId
            )
            ->where(
                'status',
                'Selesai'
            )
            ->latest()
            ->take(3)
            ->get();

        return view(
            'dashboard.pelanggan',
            compact(
                'totalOrder',
                'sedangBerjalan',
                'selesai',
                'orderAktif',
                'riwayatOrder'
            )
        );
    }


    public function teknisi()
    {
        Order::releaseExpiredOrders();

        $user = Auth::user();

        $profile = $user->profileTeknisi;


        $sudahDiverifikasi =
            $profile &&
            $profile->status_verifikasi === 'Disetujui';


        $subKategoriId = $profile?->id_sub_kategori;

        $orderDikerjakan = Order::with([
            'pelanggan',
            'subCategory.category',
        ])
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->whereIn('status', [
                'Dikonfirmasi',
                'Dikerjakan',
                'Diproses',
                'Pengajuan_Batal',
            ])
            ->latest()
            ->get();

        $hasActiveOrder = $orderDikerjakan->count() > 0;

        if ($sudahDiverifikasi && $subKategoriId && !$hasActiveOrder) {

            $orderMasuk = Order::with([
                'pelanggan',
                'subCategory.category',
            ])
                ->where(
                    'status',
                    'Menunggu'
                )
                ->whereNull(
                    'id_teknisi'
                )
                ->where(
                    'id_sub_kategori',
                    $subKategoriId
                )
                ->latest()
                ->get()
                ->filter(function ($order) use ($user) {
                    $excluded = $order->excluded_teknisi_ids ?? [];
                    if (!is_array($excluded)) return true;
                    return !in_array((int)$user->id_user, array_map('intval', $excluded));
                });

        } else {

            $orderMasuk = collect();
        }


        $totalOrder = Order::all()
            ->filter(function ($order) use ($user) {
                if ((int) $order->id_teknisi === (int) $user->id_user) {
                    return true;
                }
                $excluded = $order->excluded_teknisi_ids ?? [];
                if (is_array($excluded) && in_array((int) $user->id_user, array_map('intval', $excluded))) {
                    return true;
                }
                return false;
            })
            ->count();

        $orderHariIni = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->count();

        $orderSelesai = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();

        $totalPendapatan = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->where(
                'status',
                'Selesai'
            )
            ->whereIn('metode_pembayaran', ['qris', 'online'])
            ->sum('total_harga') ?? 0;

        $rating = Review::whereHas(
            'order',
            function ($query) use ($user) {

                $query->where(
                    'id_teknisi',
                    $user->id_user
                );

            }
        )->avg('rating');

        $rating = $rating ?? 0;


        $rincianPendapatan = Order::with(['subCategory', 'pelanggan'])
            ->where('id_teknisi', $user->id_user)
            ->where('status', 'Selesai')
            ->whereIn('metode_pembayaran', ['qris', 'online'])
            ->latest()
            ->get();


        return view(
            'dashboard.teknisi',
            compact(
                'orderMasuk',
                'orderDikerjakan',
                'totalOrder',
                'orderHariIni',
                'orderSelesai',
                'totalPendapatan',
                'rincianPendapatan',
                'rating'
            )
        );
    }


    public function admin()
    {

        $totalPengguna = \App\Models\User::count();

        $totalTeknisi = \App\Models\User::where(
            'role_user',
            'teknisi'
        )->count();

        $orderBulanIni = Order::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        $menungguVerifikasi = ProfileTeknisi::where(
            'status_verifikasi',
            'Menunggu'
        )->count();

        $teknisiVerifikasi = ProfileTeknisi::with([
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


        $statistikLayanan = Order::with([
            'subCategory.category'
        ])
            ->get()
            ->groupBy(function ($order) {

                return optional(
                    optional(
                        $order->subCategory
                    )->category
                )->nama_kategori ?? 'Lainnya';

            })
            ->map(function ($orders) {

                return $orders->count();

            })
            ->sortDesc();

        $transaksiTerbaru = Order::with([
            'pelanggan',
            'subCategory.category',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.admin',
            compact(
                'totalPengguna',
                'totalTeknisi',
                'orderBulanIni',
                'menungguVerifikasi',
                'teknisiVerifikasi',
                'statistikLayanan',
                'transaksiTerbaru'
            )
        );
    }

    public function profilTeknisi()
    {
        $user = Auth::user();

        $profile = ProfileTeknisi::with([
            'category',
            'subCategory',
        ])
            ->where(
                'id_user',
                $user->id_user
            )
            ->first();

        $nama = $user->nama ?? '-';

        $email = $user->email ?? '-';

        $noHp = $user->no_hp ?? '-';

        $alamat = $user->alamat ?? '-';


        $namaKategori =
            $profile?->category?->nama_kategori
            ?? '-';

        $keahlian =
            $profile?->subCategory?->nama_sub_kategori
            ?? '-';

        $kategori = Category::with(
            'subCategories'
        )
            ->orderBy(
                'nama_kategori'
            )
            ->get();

        $ktp = $profile?->ktp;

        $fotoDiri = $profile?->foto_diri;

        $portofolio = $profile?->portofolio;

        $statusVerifikasi =
            $profile?->status_verifikasi
            ?? 'Menunggu';

        $statusKetersediaan =
            $profile?->status_ketersediaan
            ?? 'Tersedia';

        $pengalaman =
            $profile?->pengalaman
            ?? '-';

        $bergabung = '0 Hari';

        $tanggalGabung =
            $profile?->created_at
            ?? $user->created_at;

        if ($tanggalGabung) {

            $totalHari =
                (int) floor(
                    $tanggalGabung->diffInDays(now())
                );

            if ($totalHari < 1) {

                $bergabung = '1 Hari';

            } elseif ($totalHari < 30) {

                $bergabung =
                    $totalHari . ' Hari';

            } elseif ($totalHari < 365) {

                $totalBulan =
                    (int) floor($totalHari / 30);

                $bergabung =
                    $totalBulan . ' Bulan';

            } else {

                $totalTahun =
                    (int) floor($totalHari / 365);

                $bergabung =
                    $totalTahun . ' Tahun';
            }
        }

        $totalOrder = Order::where(
            'id_teknisi',
            $user->id_user
        )->count();

        $orderSelesai = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();

        $rating = Review::whereHas(
            'order',
            function ($query) use ($user) {

                $query->where(
                    'id_teknisi',
                    $user->id_user
                );

            }
        )->avg('rating');

        $rating = $rating ?? 0;

        $reviews = Review::with([
            'order.pelanggan',
        ])
            ->whereHas(
                'order',
                function ($query) use ($user) {

                    $query->where(
                        'id_teknisi',
                        $user->id_user
                    );

                }
            )
            ->latest()
            ->take(5)
            ->get();

        return view(
            'dashboard.profil-teknisi',
            compact(
                'user',
                'profile',

                'nama',
                'email',
                'noHp',
                'alamat',

                'kategori',
                'namaKategori',
                'keahlian',

                'ktp',
                'fotoDiri',
                'portofolio',

                'statusVerifikasi',
                'statusKetersediaan',

                'pengalaman',
                'bergabung',

                'totalOrder',
                'orderSelesai',
                'rating',

                'reviews'
            )
        );
    }

    public function updateProfilTeknisi(Request $request)
    {
        $user = Auth::user();

        $request->validate([

            'nama' => [
                'required',
                'string',
                'max:100',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                'unique:users,email,' .
                    $user->id_user .
                    ',id_user',
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20',
            ],

            'alamat' => [
                'required',
                'string',
                'max:255',
            ],

            'id_kategori' => [
                'required',
                'exists:categories,id_kategori',
            ],

            'id_sub_kategori' => [
                'required',
                'exists:sub_categories,id_sub_kategori',
            ],

            'pengalaman' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'status_ketersediaan' => [
                'required',
                'in:Tersedia,Tidak Tersedia',
            ],

            'ktp' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

            'foto_diri' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:5120',
            ],

            'portofolio' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:5120',
            ],

        ]);

        $profile = ProfileTeknisi::firstOrNew([
            'id_user' => $user->id_user,
        ]);

        $dataVerifikasiBerubah = false;


        if (
            (string) $profile->id_kategori !==
            (string) $request->id_kategori
        ) {

            $dataVerifikasiBerubah = true;
        }


        if (
            (string) $profile->id_sub_kategori !==
            (string) $request->id_sub_kategori
        ) {

            $dataVerifikasiBerubah = true;
        }


        if ($request->hasFile('ktp')) {

            $dataVerifikasiBerubah = true;
        }


        if ($request->hasFile('foto_diri')) {

            $dataVerifikasiBerubah = true;
        }


        if ($request->hasFile('portofolio')) {

            $dataVerifikasiBerubah = true;
        }


        $user->nama =
            $request->nama;

        $user->email =
            $request->email;

        $user->no_hp =
            $request->no_hp;

        $user->alamat =
            $request->alamat;

        $user->save();

        $profile->id_kategori =
            $request->id_kategori;

        $profile->id_sub_kategori =
            $request->id_sub_kategori;

        $profile->pengalaman =
            $request->pengalaman;

        $profile->status_ketersediaan =
            $request->status_ketersediaan;


        if ($dataVerifikasiBerubah) {

            $profile->status_verifikasi =
                'Menunggu';
        }


        if ($request->hasFile('ktp')) {

            if (
                $profile->ktp &&
                Storage::disk('public')->exists(
                    $profile->ktp
                )
            ) {

                Storage::disk('public')->delete(
                    $profile->ktp
                );
            }


            $profile->ktp =
                $request
                    ->file('ktp')
                    ->store(
                        'dokumen-teknisi/ktp',
                        'public'
                    );
        }

        if ($request->hasFile('foto_diri')) {

            if (
                $profile->foto_diri &&
                Storage::disk('public')->exists(
                    $profile->foto_diri
                )
            ) {

                Storage::disk('public')->delete(
                    $profile->foto_diri
                );
            }


            $profile->foto_diri =
                $request
                    ->file('foto_diri')
                    ->store(
                        'dokumen-teknisi/foto-diri',
                        'public'
                    );
        }

        if ($request->hasFile('portofolio')) {

            if (
                $profile->portofolio &&
                Storage::disk('public')->exists(
                    $profile->portofolio
                )
            ) {

                Storage::disk('public')->delete(
                    $profile->portofolio
                );
            }


            $profile->portofolio =
                $request
                    ->file('portofolio')
                    ->store(
                        'dokumen-teknisi/portofolio',
                        'public'
                    );
        }

        $profile->save();


        if ($dataVerifikasiBerubah) {

            return redirect()
                ->route(
                    'dashboard.teknisi.profil'
                )
                ->with(
                    'success',
                    'Profil berhasil diperbarui. Karena data keahlian atau dokumen berubah, profil menunggu verifikasi ulang dari Admin.'
                );
        }


        return redirect()
            ->route(
                'dashboard.teknisi.profil'
            )
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }

    public function pesanLayanan()
    {
        $kategori = Category::with(
            'subCategories'
        )->get();

        return view(
            'dashboard.pesan-layanan',
            compact('kategori')
        );
    }


    public function riwayatOrder()
    {
        $orders = Order::with([
            'subCategory.category',
            'teknisi',
            'payment',
            'review',
        ])
            ->where(
                'id_pelanggan',
                Auth::user()->id_user
            )
            ->latest()
            ->get();

        return view(
            'dashboard.riwayat-order',
            compact('orders')
        );
    }

    public function riwayatOrderTeknisi()
    {
        $user = Auth::user();

        $orders = Order::with([
            'pelanggan',
            'subCategory.category',
        ])
            ->latest()
            ->get()
            ->filter(function ($order) use ($user) {
                if ((int) $order->id_teknisi === (int) $user->id_user) {
                    return true;
                }
                $excluded = $order->excluded_teknisi_ids ?? [];
                if (is_array($excluded) && in_array((int) $user->id_user, array_map('intval', $excluded))) {
                    return true;
                }
                return false;
            });

        return view(
            'dashboard.riwayat-order-teknisi',
            compact('orders')
        );
    }

    public function detailOrder($id)
    {
        Order::releaseExpiredOrders();

        $user = Auth::user();

        $order = Order::with([
            'subCategory.category',
            'teknisi',
            'pelanggan',
            'review',
            'payment',
        ])
            ->where('id_order', $id)
            ->firstOrFail();


        if ($user->role_user === 'pelanggan') {

            if ((int) $order->id_pelanggan !== (int) $user->id_user) {
                abort(403);
            }

        } elseif ($user->role_user === 'teknisi') {

            $excluded = $order->excluded_teknisi_ids ?? [];
            $isExcluded = is_array($excluded) && in_array((int) $user->id_user, array_map('intval', $excluded));

            if ((int) $order->id_teknisi !== (int) $user->id_user && !$isExcluded) {
                abort(403);
            }

        } elseif ($user->role_user === 'admin') {


        } else {

            abort(403);
        }

        return view(
            'dashboard.detail-order',
            compact('order')
        );
    }

    public function profil()
    {
        return view(
            'dashboard.profil'
        );
    }

    public function pembayaranQris($id)
    {
        $order = Order::with([
            'subCategory.category',
            'teknisi',
        ])
            ->where(
                'id_pelanggan',
                Auth::user()->id_user
            )
            ->where(
                'metode_pembayaran',
                'qris'
            )
            ->findOrFail($id);

        return view(
            'dashboard.pembayaran-qris',
            compact('order')
        );
    }

    public function simulasiPembayaran($id)
    {
        $order = Order::where(
            'id_pelanggan',
            Auth::user()->id_user
        )
            ->where(
                'metode_pembayaran',
                'qris'
            )
            ->findOrFail($id);


        $order->update([
            'status' => 'Menunggu',
        ]);


        return redirect()
            ->route(
                'dashboard.riwayat-order'
            )
            ->with(
                'success',
                'Pembayaran QRIS berhasil disimulasikan. Pesanan Anda sedang menunggu teknisi.'
            );
    }


    public function updateProfil(Request $request)
    {
        $user = Auth::user();


        $request->validate([

            'nama' =>
                'required|string|max:100',

            'email' =>
                'required|email|max:150',

            'no_hp' =>
                'required|string|max:20',

            'alamat' =>
                'required|string|max:255',

        ]);


        $user->nama =
            $request->nama;

        $user->email =
            $request->email;

        $user->no_hp =
            $request->no_hp;

        $user->alamat =
            $request->alamat;

        $user->save();


        return redirect()
            ->route(
                'dashboard.profil'
            )
            ->with(
                'success',
                'Profil berhasil diperbarui.'
            );
    }
}