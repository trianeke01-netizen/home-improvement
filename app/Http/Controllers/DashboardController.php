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
    /*
    |--------------------------------------------------------------------------
    | REDIRECT DASHBOARD SESUAI ROLE
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function pelanggan()
    {
        $userId = Auth::user()->id_user;


        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER
        |--------------------------------------------------------------------------
        */

        $totalOrder = Order::where(
            'id_pelanggan',
            $userId
        )->count();


        /*
        |--------------------------------------------------------------------------
        | ORDER SEDANG BERJALAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | ORDER SELESAI
        |--------------------------------------------------------------------------
        */

        $selesai = Order::where(
            'id_pelanggan',
            $userId
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ORDER AKTIF
        |--------------------------------------------------------------------------
        */

        $orderAktif = Order::with([
            'subCategory.category',
            'teknisi',
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


        /*
        |--------------------------------------------------------------------------
        | RIWAYAT ORDER
        |--------------------------------------------------------------------------
        */

        $riwayatOrder = Order::with([
            'subCategory.category',
            'teknisi',
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


        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD TEKNISI
    |--------------------------------------------------------------------------
    */

    public function teknisi()
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | PROFILE TEKNISI
        |--------------------------------------------------------------------------
        */

        $profile = $user->profileTeknisi;


        /*
        |--------------------------------------------------------------------------
        | CEK STATUS VERIFIKASI TEKNISI
        |--------------------------------------------------------------------------
        |
        | Hanya teknisi yang sudah disetujui Admin
        | yang dapat melihat order masuk.
        |
        */

        $sudahDiverifikasi =
            $profile &&
            $profile->status_verifikasi === 'Disetujui';


        /*
        |--------------------------------------------------------------------------
        | SUBKATEGORI KEAHLIAN
        |--------------------------------------------------------------------------
        */

        $subKategoriId = $profile?->id_sub_kategori;


        /*
        |--------------------------------------------------------------------------
        | ORDER MASUK
        |--------------------------------------------------------------------------
        */

        if ($sudahDiverifikasi && $subKategoriId) {

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
                ->get();

        } else {

            /*
            |--------------------------------------------------------------------------
            | BELUM DIVERIFIKASI
            |--------------------------------------------------------------------------
            |
            | Tidak mendapatkan order masuk.
            |
            */

            $orderMasuk = collect();
        }


        /*
        |--------------------------------------------------------------------------
        | ORDER SEDANG DIKERJAKAN
        |--------------------------------------------------------------------------
        */

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
            ])
            ->latest()
            ->get();


        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER
        |--------------------------------------------------------------------------
        */

        $totalOrder = Order::where(
            'id_teknisi',
            $user->id_user
        )->count();


        /*
        |--------------------------------------------------------------------------
        | ORDER HARI INI
        |--------------------------------------------------------------------------
        */

        $orderHariIni = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->whereDate(
                'created_at',
                today()
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | ORDER SELESAI
        |--------------------------------------------------------------------------
        */

        $orderSelesai = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RATING
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | VIEW DASHBOARD TEKNISI
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.teknisi',
            compact(
                'orderMasuk',
                'orderDikerjakan',
                'totalOrder',
                'orderHariIni',
                'orderSelesai',
                'rating'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        /*
        |--------------------------------------------------------------------------
        | TOTAL PENGGUNA
        |--------------------------------------------------------------------------
        */

        $totalPengguna = \App\Models\User::count();


        /*
        |--------------------------------------------------------------------------
        | TOTAL TEKNISI
        |--------------------------------------------------------------------------
        */

        $totalTeknisi = \App\Models\User::where(
            'role_user',
            'teknisi'
        )->count();


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
        | TEKNISI MENUNGGU VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $menungguVerifikasi = ProfileTeknisi::where(
            'status_verifikasi',
            'Menunggu'
        )->count();


        /*
        |--------------------------------------------------------------------------
        | DATA TEKNISI MENUNGGU VERIFIKASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | STATISTIK LAYANAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI TERBARU
        |--------------------------------------------------------------------------
        */

        $transaksiTerbaru = Order::with([
            'pelanggan',
            'subCategory.category',
        ])
            ->latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VIEW ADMIN
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | PROFIL TEKNISI
    |--------------------------------------------------------------------------
    */

    public function profilTeknisi()
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | AMBIL PROFILE TEKNISI
        |--------------------------------------------------------------------------
        */

        $profile = ProfileTeknisi::with([
            'category',
            'subCategory',
        ])
            ->where(
                'id_user',
                $user->id_user
            )
            ->first();


        /*
        |--------------------------------------------------------------------------
        | DATA USER
        |--------------------------------------------------------------------------
        */

        $nama = $user->nama ?? '-';

        $email = $user->email ?? '-';

        $noHp = $user->no_hp ?? '-';

        $alamat = $user->alamat ?? '-';


        /*
        |--------------------------------------------------------------------------
        | KATEGORI TEKNISI
        |--------------------------------------------------------------------------
        |
        | Nama kategori teknisi disimpan di variabel
        | $namaKategori supaya tidak bentrok dengan
        | $kategori yang digunakan untuk dropdown.
        |
        */

        $namaKategori =
            $profile?->category?->nama_kategori
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | KEAHLIAN
        |--------------------------------------------------------------------------
        */

        $keahlian =
            $profile?->subCategory?->nama_sub_kategori
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | DATA KATEGORI UNTUK FORM EDIT
        |--------------------------------------------------------------------------
        |
        | $kategori sekarang adalah Collection.
        | Ini yang digunakan oleh @foreach di Blade.
        |
        */

        $kategori = Category::with(
            'subCategories'
        )
            ->orderBy(
                'nama_kategori'
            )
            ->get();


        /*
        |--------------------------------------------------------------------------
        | DOKUMEN
        |--------------------------------------------------------------------------
        */

        $ktp = $profile?->ktp;

        $fotoDiri = $profile?->foto_diri;

        $portofolio = $profile?->portofolio;


        /*
        |--------------------------------------------------------------------------
        | STATUS VERIFIKASI
        |--------------------------------------------------------------------------
        */

        $statusVerifikasi =
            $profile?->status_verifikasi
            ?? 'Menunggu';


        /*
        |--------------------------------------------------------------------------
        | STATUS KETERSEDIAAN
        |--------------------------------------------------------------------------
        */

        $statusKetersediaan =
            $profile?->status_ketersediaan
            ?? 'Tersedia';


        /*
        |--------------------------------------------------------------------------
        | PENGALAMAN
        |--------------------------------------------------------------------------
        */

        $pengalaman =
            $profile?->pengalaman
            ?? '-';


        /*
        |--------------------------------------------------------------------------
        | LAMA BERGABUNG
        |--------------------------------------------------------------------------
        |
        | PENTING: diffInDays() / diffInMonths() / diffInYears()
        | pada Carbon versi baru (Carbon 3 / Laravel 11) secara
        | default mengembalikan nilai FLOAT (mis. 2.9850691564352),
        | bukan integer. Makanya harus dibulatkan ke bawah dengan
        | (int) atau floor() supaya hasilnya bulat dan rapi.
        |
        | Ditambahkan juga penyesuaian otomatis ke satuan
        | hari / bulan / tahun supaya tampilannya enak dibaca.
        |
        */

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


        /*
        |--------------------------------------------------------------------------
        | TOTAL ORDER
        |--------------------------------------------------------------------------
        */

        $totalOrder = Order::where(
            'id_teknisi',
            $user->id_user
        )->count();


        /*
        |--------------------------------------------------------------------------
        | ORDER SELESAI
        |--------------------------------------------------------------------------
        */

        $orderSelesai = Order::where(
            'id_teknisi',
            $user->id_user
        )
            ->where(
                'status',
                'Selesai'
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | RATING
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | ULASAN
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | VIEW PROFIL TEKNISI
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL TEKNISI
    |--------------------------------------------------------------------------
    */

    public function updateProfilTeknisi(Request $request)
    {
        $user = Auth::user();


        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | AMBIL PROFILE
        |--------------------------------------------------------------------------
        */

        $profile = ProfileTeknisi::firstOrNew([
            'id_user' => $user->id_user,
        ]);


        /*
        |--------------------------------------------------------------------------
        | CEK PERUBAHAN DATA YANG BERHUBUNGAN DENGAN VERIFIKASI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | UPDATE DATA USER
        |--------------------------------------------------------------------------
        */

        $user->nama =
            $request->nama;

        $user->email =
            $request->email;

        $user->no_hp =
            $request->no_hp;

        $user->alamat =
            $request->alamat;

        $user->save();


        /*
        |--------------------------------------------------------------------------
        | UPDATE PROFILE
        |--------------------------------------------------------------------------
        */

        $profile->id_kategori =
            $request->id_kategori;

        $profile->id_sub_kategori =
            $request->id_sub_kategori;

        $profile->pengalaman =
            $request->pengalaman;

        $profile->status_ketersediaan =
            $request->status_ketersediaan;


        /*
        |--------------------------------------------------------------------------
        | JIKA DATA VERIFIKASI BERUBAH
        |--------------------------------------------------------------------------
        |
        | Admin harus memverifikasi ulang.
        |
        */

        if ($dataVerifikasiBerubah) {

            $profile->status_verifikasi =
                'Menunggu';
        }


        /*
        |--------------------------------------------------------------------------
        | UPLOAD KTP
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | UPLOAD FOTO DIRI
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | UPLOAD PORTOFOLIO
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | SIMPAN PROFILE
        |--------------------------------------------------------------------------
        */

        $profile->save();


        /*
        |--------------------------------------------------------------------------
        | PESAN BERHASIL
        |--------------------------------------------------------------------------
        */

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


    /*
    |--------------------------------------------------------------------------
    | PESAN LAYANAN
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT ORDER PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function riwayatOrder()
    {
        $orders = Order::with([
            'subCategory.category',
            'teknisi',
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


    /*
    |--------------------------------------------------------------------------
    | RIWAYAT ORDER TEKNISI
    |--------------------------------------------------------------------------
    */

    public function riwayatOrderTeknisi()
    {
        $user = Auth::user();

        $orders = Order::with([
            'pelanggan',
            'subCategory.category',
        ])
            ->where(
                'id_teknisi',
                $user->id_user
            )
            ->latest()
            ->get();

        return view(
            'dashboard.riwayat-order-teknisi',
            compact('orders')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DETAIL ORDER
    |--------------------------------------------------------------------------
    */

    public function detailOrder($id)
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | AMBIL ORDER
        |--------------------------------------------------------------------------
        */

        $order = Order::with([
            'subCategory.category',
            'teknisi',
            'pelanggan',
            'review',
        ])
            ->where('id_order', $id)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | CEK HAK AKSES
        |--------------------------------------------------------------------------
        */

        if ($user->role_user === 'pelanggan') {

            if ((int) $order->id_pelanggan !== (int) $user->id_user) {
                abort(403);
            }

        } elseif ($user->role_user === 'teknisi') {

            if ((int) $order->id_teknisi !== (int) $user->id_user) {
                abort(403);
            }

        } else {

            abort(403);
        }


        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN DETAIL
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard.detail-order',
            compact('order')
        );
    }


        /*
    |--------------------------------------------------------------------------
    | PROFIL PELANGGAN
    |--------------------------------------------------------------------------
    */

    public function profil()
    {
        return view(
            'dashboard.profil'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PEMBAYARAN QRIS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | SIMULASI PEMBAYARAN QRIS
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL PELANGGAN
    |--------------------------------------------------------------------------
    */

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