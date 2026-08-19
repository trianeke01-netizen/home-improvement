@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    {{-- ========================= --}}
    {{-- STATISTIK --}}
    {{-- ========================= --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- TOTAL ORDER --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">
                        Total Order
                    </p>

                    <h2 class="text-4xl font-bold text-slate-800 mt-2">

                        {{ $totalOrder }}

                    </h2>

                </div>

                <div
                    class="w-14 h-14 rounded-xl
                           bg-sky-100
                           flex items-center justify-center">

                    <svg class="w-8 h-8 text-sky-600"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <rect
                            x="4"
                            y="5"
                            width="16"
                            height="15"
                            rx="2"/>

                        <path
                            d="M9 3v4M15 3v4M4 10h16"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- ORDER BERJALAN --}}

        <div
            class="rounded-2xl
                   p-5
                   bg-gradient-to-r
                   from-sky-500
                   to-blue-600
                   text-white
                   shadow-lg">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-sky-100 text-sm">
                        Sedang Berjalan
                    </p>

                    <h2 class="text-4xl font-bold mt-2">

                        {{ $sedangBerjalan }}

                    </h2>

                </div>

                <div
                    class="w-14 h-14
                           rounded-xl
                           bg-white/20
                           flex items-center justify-center">

                    <svg class="w-7 h-7"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path
                            d="M12 8v4l3 3"/>

                        <circle
                            cx="12"
                            cy="12"
                            r="9"/>

                    </svg>

                </div>

            </div>

        </div>


        {{-- SELESAI --}}

        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">

            <div class="flex justify-between items-center">

                <div>

                    <p class="text-slate-500 text-sm">

                        Selesai

                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">

                        {{ $selesai }}

                    </h2>

                </div>

                <div
                    class="w-14 h-14
                           rounded-xl
                           bg-green-100
                           flex items-center justify-center">

                    <svg class="w-8 h-8 text-green-600"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         viewBox="0 0 24 24">

                        <path
                            d="M5 13l4 4L19 7"/>

                    </svg>

                </div>

            </div>

        </div>

    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold text-slate-800">
                Order Aktif
            </h2>

        </div>

        @forelse($orderAktif as $order)

            @php

                $steps = [
                    'Menunggu' => 1,
                    'Dikonfirmasi' => 2,
                    'Diproses' => 3,
                    'Selesai' => 4,
                ];

                $current = $steps[$order->status] ?? 1;

            @endphp

            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                {{-- HEADER CARD --}}

                <div class="bg-sky-50 px-7 py-6 flex justify-between items-start">

                    <div>

                        <h3 class="text-3xl font-bold text-slate-800">

                            {{ $order->subCategory->category->nama_kategori }}

                        </h3>

                        <p class="text-slate-500 text-xl mt-1">

                            {{ $order->subCategory->nama_sub_kategori }}

                        </p>

                    </div>

                    <span
                        class="px-5 py-2 rounded-full
                               text-sm font-semibold

                            @if($order->status=='Menunggu')
                                bg-yellow-100 text-yellow-700
                            @elseif($order->status=='Dikonfirmasi')
                                bg-blue-100 text-blue-700
                            @elseif($order->status=='Diproses')
                                bg-sky-100 text-sky-700
                            @else
                                bg-green-100 text-green-700
                            @endif">

                        {{ $order->status }}

                    </span>

                </div>

                {{-- BODY --}}

                <div class="p-7">

                    <div class="grid md:grid-cols-3 gap-8">

                        <div>

                            <p class="text-slate-400 text-sm">

                                Jadwal

                            </p>

                            <h4 class="font-bold text-lg text-slate-800 mt-1">

                                {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}

                            </h4>

                            <p class="text-slate-500">

                                {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }}

                            </p>

                        </div>

                        <div>

                            <p class="text-slate-400 text-sm">

                                Total Biaya

                            </p>

                            <h4 class="font-bold text-3xl text-sky-600 mt-1">

                                Rp {{ number_format($order->total_harga,0,',','.') }}

                            </h4>

                        </div>

                        <div>

                            <p class="text-slate-400 text-sm">

                                Teknisi Terhubung

                            </p>

                            <h4 class="font-bold text-lg mt-1">

                                {{ $order->teknisi->nama ?? 'Belum ada teknisi' }}

                            </h4>

                            @if($order->teknisi)
                                <div class="mt-2 flex flex-wrap gap-2">
                                    <a
                                        href="{{ $order->teknisi->getWhatsappLinkWithMessage('Halo ' . $order->teknisi->nama . ', saya pelanggan order #' . $order->id_order . ' (' . $order->subCategory->nama_sub_kategori . ') di Home Improvement.') }}"
                                        target="_blank"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition border border-emerald-200"
                                    >
                                        💬 WhatsApp
                                    </a>

                                    <a
                                        href="tel:{{ $order->teknisi->no_hp }}"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold transition"
                                    >
                                        📞 Telepon
                                    </a>
                                </div>
                            @endif

                        </div>

                    </div>

                    {{-- PROGRESS --}}

                    <div class="mt-8">

                        <div class="flex justify-between text-sm font-medium text-slate-500 mb-3">

                            <span>Dipesan</span>

                            <span>Dikonfirmasi</span>

                            <span>Dikerjakan</span>

                            <span>Selesai</span>

                        </div>

                        <div class="grid grid-cols-4 gap-3">

                            <div class="h-2 rounded-full {{ $current>=1 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>

                            <div class="h-2 rounded-full {{ $current>=2 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>

                            <div class="h-2 rounded-full {{ $current>=3 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>

                            <div class="h-2 rounded-full {{ $current>=4 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center">

                <div class="text-5xl mb-3">
                    📦
                </div>

                <h3 class="text-xl font-bold text-slate-700">

                    Belum Ada Order Aktif

                </h3>

                <p class="text-slate-500 mt-2">

                    Silakan lakukan pemesanan layanan terlebih dahulu.

                </p>

            </div>

        @endforelse

    </div>

    <div class="mt-8">
        <div class="flex items-center justify-between mb-5">

            <h2 class="text-2xl font-bold text-slate-800">
                Riwayat Order
            </h2>
        </div>

        <div class="space-y-5">

            @forelse($riwayatOrder as $order)

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

                    {{-- HEADER CARD: KATEGORI & STATUS --}}
                    <div class="bg-gradient-to-r from-sky-50 to-blue-50 px-5 sm:px-6 py-5 flex items-start justify-between gap-4">

                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-slate-800">
                                {{ $order->subCategory->category->nama_kategori ?? 'Layanan' }}
                            </h3>

                            <p class="text-sm text-slate-500 mt-1">
                                {{ $order->subCategory->nama_sub_kategori ?? '-' }}
                            </p>
                        </div>

                        <span
                            class="px-4 py-2 rounded-full text-xs font-semibold shrink-0
                            @if($order->status=='Menunggu')
                                bg-amber-100 text-amber-700
                            @elseif($order->status=='Dikonfirmasi')
                                bg-blue-100 text-blue-700
                            @elseif($order->status=='Diproses' || $order->status=='Dikerjakan')
                                bg-sky-100 text-sky-700
                            @elseif($order->status=='Selesai')
                                bg-emerald-100 text-emerald-700
                            @else
                                bg-red-100 text-red-700
                            @endif">
                            {{ $order->status }}
                        </span>

                    </div>

                    {{-- BODY CARD: JADWAL, TOTAL BIAYA, TEKNISI --}}
                    <div class="p-5 sm:p-6">

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 text-sm">

                            <div>
                                <p class="text-xs text-slate-400 font-medium">Jadwal</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}
                                </p>
                                <p class="text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400 font-medium">Total Biaya</p>
                                <p class="font-bold text-sky-600 text-xl mt-1">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs text-slate-400 font-medium">Teknisi</p>
                                <p class="font-semibold text-slate-800 mt-1">
                                    {{ $order->teknisi->nama ?? 'Belum ada teknisi' }}
                                </p>
                            </div>

                        </div>

                        {{-- FOOTER CARD: TOMBOL LIHAT DETAIL --}}
                        <div class="mt-6 pt-5 border-t border-slate-100 flex justify-end">
                            <a
                                href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition shadow-sm"
                            >
                                Lihat Detail &rsaquo;
                            </a>
                        </div>

                    </div>

                </div>

            @empty

                <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center">

                    <div class="text-5xl mb-3">
                        📋
                    </div>

                    <h3 class="text-xl font-bold text-slate-700">

                        Belum Ada Riwayat Order

                    </h3>

                    <p class="text-slate-500 mt-2">

                        Riwayat pesanan Anda akan muncul di sini.

                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- ===================================================== --}}
    {{-- BUTTON --}}
    {{-- ===================================================== --}}

    <div class="flex justify-end mt-8">

        <a href="{{ route('dashboard.pesan-layanan') }}"
           class="px-8 py-3 rounded-xl
                  bg-gradient-to-r
                  from-sky-500
                  to-blue-600
                  hover:from-sky-600
                  hover:to-blue-700
                  text-white
                  font-semibold
                  shadow-md
                  transition">

            Pesan Layanan Baru
        </a>

    </div>

</div>

@endsection