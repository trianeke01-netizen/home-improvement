@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA DASHBOARD
    |--------------------------------------------------------------------------
    | Nilai Total Pengguna dan Total Teknisi dihitung langsung dari database
    | agar tampilan tetap sinkron dengan data user yang sebenarnya.
    |
    | Data lainnya tetap menggunakan variabel dari AdminController.
    |--------------------------------------------------------------------------
    */

    $jumlahPengguna = \App\Models\User::count();

    $jumlahTeknisi = \App\Models\User::where(
        'role_user',
        'teknisi'
    )->count();

    $jumlahMenunggu = \App\Models\ProfileTeknisi::where(
        'status_verifikasi',
        'Menunggu'
    )->count();

    $dataTeknisi = $teknisiPending ?? collect();
    $dataKategori = $kategoriTerpopuler ?? collect();
    $dataTransaksi = $pesananTerbaru ?? collect();

    $maxOrder = collect($dataKategori)->max('orders_count') ?? 0;
    $maxOrder = $maxOrder > 0 ? $maxOrder : 1;
@endphp


<style>
    .admin-dashboard {
        width: 100%;
        max-width: 1180px;
        margin: 0 auto;
    }

    .admin-dashboard * {
        box-sizing: border-box;
    }

    .admin-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 18px;
    }

    .admin-stat {
        min-height: 126px;
    }

    .admin-title {
        font-size: 18px;
        font-weight: 700;
        color: #0f172a;
    }

    .admin-progress {
        height: 6px;
        width: 100%;
        background: #e5e7eb;
        border-radius: 999px;
        overflow: hidden;
    }

    .admin-progress > div {
        height: 100%;
        background: #111827;
        border-radius: 999px;
    }

    .admin-btn {
        min-height: 40px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: .2s;
        cursor: pointer;
    }

    .admin-btn-dark {
        background: #0f172a;
        color: white;
    }

    .admin-btn-dark:hover {
        background: #020617;
    }

    .admin-btn-light {
        background: white;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .admin-btn-light:hover {
        background: #f8fafc;
    }

    .admin-link {
        font-size: 12px;
        color: #64748b;
        transition: .2s;
        font-weight: 600;
    }

    .admin-link:hover {
        color: #0f172a;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-align: left;
        padding: 14px 16px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .admin-table td {
        color: #475569;
        font-size: 12px;
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .admin-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 10px;
        font-weight: 700;
        white-space: nowrap;
    }

    .admin-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
        border-radius: 14px;
        padding: 14px 16px;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .admin-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        border-radius: 14px;
        padding: 14px 16px;
        font-size: 13px;
        margin-bottom: 18px;
    }

    .admin-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .admin-dashboard {
            max-width: 100%;
        }

        .admin-table {
            min-width: 760px;
        }
    }
</style>


<div class="admin-dashboard space-y-6">

    {{-- =========================================================
         NOTIFIKASI
         ========================================================= --}}

    @if(session('success'))
        <div class="admin-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="admin-error">
            {{ session('error') }}
        </div>
    @endif


    {{-- =========================================================
         HEADER
         ========================================================= --}}

    <div class="flex flex-col gap-2 sm:flex-row sm:items-end sm:justify-between">
        <div class="text-xs text-slate-400"></div>
    </div>


    {{-- =========================================================
         STATISTIK ATAS
         ========================================================= --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- TOTAL PENGGUNA --}}
        <div class="admin-card admin-stat p-5 shadow-sm">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Seluruh akun terdaftar
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $jumlahPengguna }}
                    </p>
                </div>

                <div class="admin-stat-icon bg-violet-50 text-violet-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"
                        />

                        <circle
                            cx="9"
                            cy="7"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- TOTAL TEKNISI --}}
        <div class="admin-card admin-stat p-5 shadow-sm">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Teknisi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $jumlahTeknisi }}
                    </p>
                </div>

                <div class="admin-stat-icon bg-sky-50 text-sky-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="7"
                            r="4"
                        />

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M5.5 21a6.5 6.5 0 0 1 13 0"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- ORDER BULAN INI --}}
        <div class="admin-card admin-stat p-5 shadow-sm">

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Order Bulan Ini
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $orderBulanIni ?? 0 }}
                    </p>
                </div>

                <div class="admin-stat-icon bg-blue-50 text-blue-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect
                            x="3"
                            y="4"
                            width="18"
                            height="17"
                            rx="2"
                        />

                        <path
                            stroke-linecap="round"
                            d="M8 2v4M16 2v4M3 10h18"
                        />
                    </svg>

                </div>

            </div>

        </div>


        {{-- MENUNGGU VERIFIKASI --}}
        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Menunggu']) }}"
            class="admin-card admin-stat p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Menunggu Verifikasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-amber-600">
                        {{ $jumlahMenunggu }}
                    </p>
                </div>

                <div class="admin-stat-icon bg-amber-50 text-amber-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>

                </div>

            </div>

        </a>

    </div>


    {{-- =========================================================
         VERIFIKASI TEKNISI & STATISTIK LAYANAN
         ========================================================= --}}

    <div class="grid grid-cols-1 gap-5 xl:grid-cols-2">

        {{-- =====================================================
             VERIFIKASI TEKNISI
             ===================================================== --}}

        <div>

            <div class="mb-3 flex items-center justify-between gap-3">

                <div>
                    <h2 class="admin-title">
                        Verifikasi Teknisi
                    </h2>
                </div>

                <a
                    href="{{ route('admin.teknisi.verifikasi') }}"
                    class="admin-link underline"
                >
                    Lihat semua
                </a>

            </div>


            <div class="admin-card overflow-hidden shadow-sm">

                @forelse($dataTeknisi->take(3) as $teknisi)

                    <div class="border-b border-slate-100 p-5 last:border-b-0">

                        <div class="flex flex-col gap-4">

                            <div class="flex items-center justify-between gap-4">

                                <div class="flex min-w-0 items-center gap-3">

                                    <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-full bg-violet-100 text-violet-600">

                                        @if(!empty($teknisi->foto_diri))

                                            <img
                                                src="{{ asset('storage/' . $teknisi->foto_diri) }}"
                                                alt="Foto {{ $teknisi->user->nama ?? 'Teknisi' }}"
                                                class="h-full w-full object-cover"
                                            >

                                        @else

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-6 w-6"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <circle
                                                    cx="12"
                                                    cy="8"
                                                    r="3.5"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6"
                                                />
                                            </svg>

                                        @endif

                                    </div>


                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-bold text-slate-900">
                                            {{ $teknisi->user->nama ?? 'Nama Teknisi' }}
                                        </p>

                                        <p class="mt-0.5 text-xs text-slate-400">
                                            {{ $teknisi->category->nama_kategori ?? 'Teknisi' }}
                                        </p>

                                        @if($teknisi->subCategory)

                                            <p class="mt-1 text-xs font-medium text-violet-600">
                                                {{ $teknisi->subCategory->nama_sub_kategori }}
                                            </p>

                                        @endif

                                    </div>

                                </div>


                                <span class="admin-status bg-amber-50 text-amber-700">
                                    Menunggu
                                </span>

                            </div>


                            <div class="grid grid-cols-2 gap-3">

                                <form
                                    action="{{ route(
                                        'admin.teknisi.update-verifikasi',
                                        $teknisi->id_profile
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status_verifikasi"
                                        value="Ditolak"
                                    >

                                    <button
                                        type="submit"
                                        class="admin-btn admin-btn-light w-full"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak teknisi ini?')"
                                    >
                                        Tolak
                                    </button>

                                </form>


                                <form
                                    action="{{ route(
                                        'admin.teknisi.update-verifikasi',
                                        $teknisi->id_profile
                                    ) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status_verifikasi"
                                        value="Disetujui"
                                    >

                                    <button
                                        type="submit"
                                        class="admin-btn admin-btn-dark w-full"
                                        onclick="return confirm('Apakah Anda yakin ingin menyetujui teknisi ini?')"
                                    >
                                        Verifikasi
                                    </button>

                                </form>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="p-10 text-center">

                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M9 12l2 2 4-4"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />
                            </svg>

                        </div>
                        <p class="mt-1 text-xs text-slate-400">
                            Semua pendaftaran teknisi sudah diproses.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>


      

    {{-- =========================================================
         TRANSAKSI TERBARU
         ========================================================= --}}

    <div>

        <div class="mb-3 flex items-end justify-between gap-3">

            <div>
                <h2 class="admin-title">
                    Transaksi Terbaru
                </h2>
            </div>

            <a
                href="{{ route('admin.orders') }}"
                class="admin-link underline"
            >
                Lihat semua
            </a>

        </div>


        <div class="admin-card overflow-hidden shadow-sm">

            <div class="overflow-x-auto">

                <table class="admin-table">

                    <thead>

                        <tr>

                            <th>
                                Pelanggan
                            </th>

                            <th>
                                Layanan
                            </th>

                            <th>
                                Total
                            </th>

                            <th>
                                Metode
                            </th>

                            <th>
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($dataTransaksi->take(5) as $order)

                            @php
                                $status =
                                    strtolower(
                                        $order->status ?? ''
                                    );
                            @endphp

                            <tr>

                                {{-- PELANGGAN --}}
                                <td>

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-500">

                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="1.8"
                                            >
                                                <circle
                                                    cx="12"
                                                    cy="8"
                                                    r="3.5"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M5 20c0-3.3 3.1-6 7-6s7 2.7 7 6"
                                                />
                                            </svg>

                                        </div>

                                        <span class="font-medium text-slate-800">
                                            {{ $order->pelanggan->nama ?? '-' }}
                                        </span>

                                    </div>

                                </td>


                                {{-- LAYANAN --}}
                                <td>
                                    {{
                                        $order->subCategory->nama_sub_kategori
                                        ?? 'Layanan'
                                    }}
                                </td>


                                {{-- TOTAL --}}
                                <td>

                                    <span class="font-semibold text-slate-700">
                                        Rp {{ number_format(
                                            $order->total_harga ?? 0,
                                            0,
                                            ',',
                                            '.'
                                        ) }}
                                    </span>

                                </td>


                                {{-- METODE --}}
                                <td>

                                    <span class="admin-status bg-slate-100 text-slate-600">
                                        {{ $order->metode_pembayaran ?? '-' }}
                                    </span>

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @if($status === 'selesai')

                                        <span class="admin-status bg-emerald-50 text-emerald-700">
                                            Selesai
                                        </span>

                                    @elseif(
                                        $status === 'dibatalkan'
                                        || $status === 'ditolak'
                                    )

                                        <span class="admin-status bg-red-50 text-red-700">
                                            {{ $order->status }}
                                        </span>

                                    @elseif(
                                        $status === 'dikerjakan'
                                        || $status === 'diproses'
                                    )

                                        <span class="admin-status bg-amber-50 text-amber-700">
                                            {{ $order->status }}
                                        </span>

                                    @elseif($status === 'dikonfirmasi')

                                        <span class="admin-status bg-blue-50 text-blue-700">
                                            {{ $order->status }}
                                        </span>

                                    @elseif($status === 'menunggu')

                                        <span class="admin-status bg-slate-100 text-slate-600">
                                            {{ $order->status }}
                                        </span>

                                    @else

                                        <span class="admin-status bg-slate-100 text-slate-600">
                                            {{ $order->status ?? '-' }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="5"
                                    class="py-12 text-center"
                                >

                                    <p class="text-sm font-semibold text-slate-700">
                                        Belum ada transaksi.
                                    </p>

                                    <p class="mt-1 text-xs text-slate-400">
                                        Transaksi akan muncul setelah pelanggan membuat order.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection