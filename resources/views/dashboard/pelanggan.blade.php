@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

    {{-- ========================= --}}
    {{-- STATISTIK --}}
    {{-- ========================= --}}

    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- TOTAL ORDER --}}
        <a href="{{ route('dashboard.riwayat-order') }}" class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-sky-300 transition cursor-pointer block group">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-sky-600 transition">
                        Total Order
                    </p>
                    <h2 class="text-4xl font-extrabold text-slate-800 mt-2">
                        {{ $totalOrder }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-7 h-7 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="4" y="5" width="16" height="15" rx="2"/>
                        <path d="M9 3v4M15 3v4M4 10h16"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- ORDER BERJALAN --}}
        <a href="{{ route('dashboard.riwayat-order') }}" class="rounded-3xl p-6 bg-gradient-to-r from-sky-500 to-blue-600 text-white shadow-md hover:shadow-lg hover:from-sky-600 hover:to-blue-700 transition cursor-pointer block group">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-sky-100">
                        Sedang Berjalan
                    </p>
                    <h2 class="text-4xl font-extrabold mt-2">
                        {{ $sedangBerjalan }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M12 8v4l3 3"/>
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
            </div>
        </a>

        {{-- SELESAI --}}
        <a href="{{ route('dashboard.riwayat-order') }}" class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md hover:border-emerald-300 transition cursor-pointer block group">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-emerald-600 transition">
                        Selesai
                    </p>
                    <h2 class="text-4xl font-extrabold text-emerald-600 mt-2">
                        {{ $selesai }}
                    </h2>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
        </a>

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

                <div class="p-5 sm:p-7">

                    {{-- GRID INFO ORDER (3 KOLOM) --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                        {{-- 1. JADWAL --}}
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Jadwal</p>
                            <h4 class="font-bold text-base sm:text-lg text-slate-800 mt-1">
                                {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}
                            </h4>
                            <p class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }}
                            </p>
                        </div>

                        {{-- 2. TOTAL BIAYA --}}
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Total Biaya</p>
                            <h4 class="font-bold text-2xl sm:text-3xl text-sky-600 mt-1">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </h4>
                        </div>

                        {{-- 3. TEKNISI TERHUBUNG --}}
                        <div>
                            <p class="text-xs text-slate-400 font-medium">Teknisi Terhubung</p>
                            <h4 class="font-bold text-base sm:text-lg text-slate-800 mt-1">
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

                            @if(!$order->teknisi && !empty($order->excluded_teknisi_ids))
                                <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 p-2 rounded-lg font-medium mt-2">
                                    🚨 <strong>Mencari Teknisi Pengganti:</strong> Teknisi sebelumnya tidak merespons dalam 1 jam. Pesanan dialihkan untuk mencari teknisi pengganti.
                                </p>
                            @endif
                        </div>

                    </div> {{-- END GRID 3 KOLOM --}}

                    {{-- PROGRESS STEPPER (BARIS FULL-WIDTH TERPISAH) --}}
                    <div class="mt-8 pt-6 border-t border-slate-100">

                        <div class="flex justify-between text-xs sm:text-sm font-semibold text-slate-600 mb-3">
                            <span class="{{ $current >= 1 ? 'text-sky-600 font-bold' : 'text-slate-400' }}">Dipesan</span>
                            <span class="{{ $current >= 2 ? 'text-sky-600 font-bold' : 'text-slate-400' }}">Dikonfirmasi</span>
                            <span class="{{ $current >= 3 ? 'text-sky-600 font-bold' : 'text-slate-400' }}">Dikerjakan</span>
                            <span class="{{ $current >= 4 ? 'text-emerald-600 font-bold' : 'text-slate-400' }}">Selesai</span>
                        </div>

                        <div class="grid grid-cols-4 gap-2 sm:gap-3">
                            <div class="h-2 rounded-full {{ $current >= 1 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>
                            <div class="h-2 rounded-full {{ $current >= 2 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>
                            <div class="h-2 rounded-full {{ $current >= 3 ? 'bg-sky-500' : 'bg-slate-200' }}"></div>
                            <div class="h-2 rounded-full {{ $current >= 4 ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                        </div>

                    </div>

                    {{-- FOOTER CARD: TOMBOL AKSI (BARIS HAK CIPTA & AKSI TERPISAH) --}}
                    <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end items-center gap-3">
                        @if(in_array($order->status, ['Menunggu', 'Dikonfirmasi']))
                            <form
                                action="{{ route('order.batalkan', $order->id_order) }}"
                                method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                class="w-full sm:w-auto"
                            >
                                @csrf
                                <button
                                    type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 rounded-xl border border-red-200 bg-red-50 hover:bg-red-100 px-4 py-2.5 text-xs font-semibold text-red-600 cursor-pointer transition"
                                >
                                    ✕ Batalkan Pesanan
                                </button>
                            </form>
                        @endif

                        @php
                            $isPaid = $order->payment && in_array($order->payment->transaction_status, ['settlement', 'capture']);
                            $isUnpaidOnline = in_array($order->metode_pembayaran, ['qris', 'online']) && !$isPaid && !in_array($order->status, ['Dibatalkan', 'Ditolak', 'Selesai']);
                        @endphp

                        @if($isUnpaidOnline)
                            <a
                                href="{{ route('dashboard.pembayaran-midtrans', $order->id_order) }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 text-xs font-bold transition shadow-sm animate-pulse"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="5" width="18" height="14" rx="2"/>
                                    <path stroke-linecap="round" d="M3 10h18"/>
                                </svg>
                                💳 Lanjutkan Pembayaran
                            </a>
                        @endif

                        @if($order->status === 'Selesai')
                            @if($order->review)
                                <span class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    Sudah Dinilai
                                </span>
                            @else
                                <a
                                    href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm"
                                >
                                    ⭐ Beri Nilai
                                </a>
                            @endif
                        @endif

                        <a
                            href="{{ route('dashboard.detail-order', $order->id_order) }}"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition shadow-sm"
                        >
                            Lihat Detail &rsaquo;
                        </a>
                    </div>

                </div>

            </div>

        @empty

            <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-10 text-center">

                <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-16.5 0l1.28-3.073A2.25 2.25 0 0110.61 3h2.78a2.25 2.25 0 012.08 1.427L20.25 7.5" />
                    </svg>
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

                        {{-- FOOTER CARD: TOMBOL AKSI --}}
                        <div class="mt-6 pt-5 border-t border-slate-100 flex flex-col-reverse sm:flex-row sm:justify-end items-center gap-3">
                            @php
                                $isPaid = $order->payment && in_array($order->payment->transaction_status, ['settlement', 'capture']);
                                $isUnpaidOnline = in_array($order->metode_pembayaran, ['qris', 'online']) && !$isPaid && !in_array($order->status, ['Dibatalkan', 'Ditolak', 'Selesai']);
                            @endphp

                            @if($isUnpaidOnline)
                                <a
                                    href="{{ route('dashboard.pembayaran-midtrans', $order->id_order) }}"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 text-xs font-bold transition shadow-sm animate-pulse"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path stroke-linecap="round" d="M3 10h18"/>
                                    </svg>
                                    💳 Lanjutkan Pembayaran
                                </a>
                            @endif

                            @if($order->status === 'Selesai')
                                @if($order->review)
                                    <span class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                        Sudah Dinilai
                                    </span>
                                @else
                                    <a
                                        href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                        class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold transition shadow-sm"
                                    >
                                        ⭐ Beri Nilai
                                    </a>
                                @endif
                            @endif

                            <a
                                href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition shadow-sm"
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