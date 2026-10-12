@extends('layouts.dashboard')

@section('title', 'Dashboard Teknisi')

@section('content')

<div class="space-y-5">

    {{-- BANNER VERIFIKASI AKUN TEKNISI --}}
    @php
        $statusVerifikasi = Auth::user()->profileTeknisi->status_verifikasi ?? 'Menunggu';
    @endphp

    @if($statusVerifikasi === 'Menunggu')
        <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-amber-800 text-base">Akun Menunggu Verifikasi Admin</h3>
                <p class="text-xs text-amber-700 mt-1">
                    Dokumen KTP dan portofolio Anda sedang ditinjau oleh Admin. Setelah disetujui, Anda dapat mulai menerima order dari pelanggan.
                </p>
            </div>
        </div>
    @elseif($statusVerifikasi === 'Ditolak')
        <div class="rounded-2xl border border-red-200 bg-red-50 p-5 flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-bold shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h3 class="font-bold text-red-800 text-base">Verifikasi Akun Ditolak</h3>
                <p class="text-xs text-red-700 mt-1">
                    Maaf, verifikasi pendaftaran akun Anda ditolak oleh Admin. Silakan hubungi Admin untuk informasi lebih lanjut.
                </p>
            </div>
        </div>
    @endif

    {{-- ========================================================= --}}
    {{-- STATISTIK TEKNISI --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">

        {{-- TOTAL PENDAPATAN TEKNISI (CLICKABLE FOR BREAKDOWN) --}}
        <div onclick="openModalRincianPendapatan()"
             class="bg-slate-900 rounded-2xl p-4 sm:p-5 shadow-xs text-white flex flex-col justify-between cursor-pointer hover:shadow-md hover:scale-[1.02] transition duration-200 border border-slate-800 group relative overflow-hidden"
             style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%); color: #ffffff;">
            <div class="flex items-center justify-between gap-2">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-300">
                    Total Pendapatan
                </span>
                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center text-emerald-400 group-hover:bg-emerald-500 group-hover:text-white transition shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
            </div>
            <div class="mt-3">
                <p class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight" style="color: #ffffff !important;">
                    Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                </p>
            </div>
        </div>

        {{-- TOTAL ORDER --}}
        <a href="{{ route('dashboard.teknisi.riwayat-order') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs hover:shadow-md hover:border-sky-300 transition cursor-pointer block group">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-sky-600 transition">
                        Total Order
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ $totalOrder ?? 0 }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-sky-50 flex items-center justify-center text-sky-600 shrink-0 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
            </div>
        </a>

        {{-- RATING --}}
        <div class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                        Rating Teknisi
                    </p>
                    <div class="mt-2 flex items-center gap-1.5">
                        <p class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                            {{ number_format($rating ?? 0, 1) }}
                        </p>
                        <span class="text-amber-400 text-lg">★</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 17.32l-5.8 3.05 1.11-6.47-4.7-4.58 6.49-.94L12 2.5z"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- ORDER SELESAI --}}
        <a href="{{ route('dashboard.teknisi.riwayat-order') }}" class="bg-white border border-slate-200 rounded-2xl p-4 sm:p-5 shadow-xs hover:shadow-md hover:border-emerald-300 transition cursor-pointer block group">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-emerald-600 transition">
                        Order Selesai
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-extrabold text-slate-900">
                        {{ $orderSelesai ?? 0 }}
                    </p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600 shrink-0 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- JARAK ANTARA STATISTIK DAN ORDER MASUK --}}
    {{-- ========================================================= --}}

    <div class="h-2 sm:h-2"></div>


    {{-- ========================================================= --}}
    {{-- ORDER MASUK --}}
    {{-- ========================================================= --}}

    <section id="order-masuk">

        <div class="mb-4">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                <div>
                    <h2 class="text-2xl font-bold text-slate-900">
                        Order Masuk
                    </h2>
                </div>

                @if(isset($orderMasuk) && $orderMasuk->count() > 0)

                    <span class="self-start px-3 py-1.5 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold">
                        {{ $orderMasuk->count() }} baru
                    </span>

                @endif

            </div>

        </div>


        {{-- JIKA ADA ORDER MASUK --}}
        @if(isset($orderMasuk) && $orderMasuk->count() > 0)

            @php
                $adaOrderBerjalan = isset($orderDikerjakan) && $orderDikerjakan->filter(function($o) {
                    return in_array($o->status, ['Dikonfirmasi', 'Dikerjakan', 'Diproses']) && empty($o->waktu_pengajuan_batal);
                })->count() > 0;
            @endphp

            @if($adaOrderBerjalan)
                <div class="mb-4 p-4 bg-amber-50 border border-amber-200 text-amber-900 rounded-2xl text-xs sm:text-sm flex items-center gap-3">
                    <span class="text-xl">⚠️</span>
                    <div>
                        <strong class="font-bold">Order Berjalan Aktif:</strong> Anda saat ini memiliki pesanan yang sedang berlangsung. Selesaikan pesanan tersebut terlebih dahulu untuk dapat menerima pesanan baru.
                    </div>
                </div>
            @endif

            <div class="space-y-4">

                @foreach($orderMasuk as $order)

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6 hover:border-blue-200 transition">

                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

                            {{-- INFORMASI ORDER --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">

                                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">
                                        {{ $order->subCategory->nama_sub_kategori ?? 'Layanan' }}
                                    </h3>

                                    <span class="self-start px-2.5 py-1 rounded-full bg-amber-50 text-amber-600 text-xs font-semibold">
                                        Menunggu
                                    </span>

                                </div>


                                <div class="mt-3 space-y-1.5">

                                    <p class="text-sm text-slate-500">
                                        Pelanggan:
                                        <span class="font-medium text-slate-700">
                                            {{ $order->pelanggan->nama ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        Alamat:
                                        <span class="font-medium text-slate-700">
                                            {{ $order->alamat ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-400">
                                        Jadwal:
                                        {{ $order->jadwal
                                            ? \Carbon\Carbon::parse($order->jadwal)->format('d M Y, H:i')
                                            : '-' }}
                                    </p>

                                </div>

                            </div>


                            {{-- TOTAL --}}
                            <div class="lg:text-right shrink-0">

                                <p class="text-xs text-slate-400">
                                    Total
                                </p>

                                <p class="mt-1 text-lg sm:text-xl font-bold text-blue-600">
                                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>


                        {{-- DESKRIPSI --}}
                        @if($order->deskripsi_kerusakan)

                            <div class="mt-5 pt-4 border-t border-gray-100">

                                <p class="text-xs text-slate-400">
                                    Deskripsi Kerusakan
                                </p>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $order->deskripsi_kerusakan }}
                                </p>

                            </div>

                        @endif


                        {{-- TOMBOL --}}
                        <div class="mt-5 flex flex-col sm:flex-row gap-3">

                            {{-- TOLAK --}}
                            <form
                                action="{{ route('order.tolak', $order->id_order) }}"
                                method="POST"
                                class="flex-1"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm font-semibold text-slate-600 hover:bg-gray-50 transition"
                                >
                                    Tolak
                                </button>
                            </form>


                            {{-- TERIMA --}}
                            @if($adaOrderBerjalan)
                                <button
                                    type="button"
                                    onclick="alert('Anda tidak dapat menerima pesanan baru karena masih memiliki pesanan yang sedang berlangsung! Selesaikan pesanan aktif terlebih dahulu.')"
                                    class="flex-1 px-4 py-2.5 rounded-xl bg-slate-300 text-slate-500 text-sm font-semibold cursor-not-allowed transition"
                                    title="Selesaikan orderan aktif terlebih dahulu"
                                >
                                    Terima (Ada Order Aktif)
                                </button>
                            @else
                                <form
                                    action="{{ route('order.terima', $order->id_order) }}"
                                    method="POST"
                                    class="flex-1"
                                >
                                    @csrf

                                    <button
                                        type="submit"
                                        class="w-full px-4 py-2.5 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-blue-600 transition"
                                    >
                                        Terima
                                    </button>
                                </form>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>


        {{-- JIKA TIDAK ADA ORDER MASUK ATAU SEDANG MEMILIKI ORDER AKTIF --}}
        @else

            @php
                $adaOrderBerjalan = isset($orderDikerjakan) && $orderDikerjakan->filter(function($o) {
                    return in_array($o->status, ['Dikonfirmasi', 'Dikerjakan', 'Diproses']) && empty($o->waktu_pengajuan_batal);
                })->count() > 0;
            @endphp

            @if($adaOrderBerjalan)
                <div class="bg-amber-50/80 border border-amber-200/80 rounded-2xl min-h-[160px] flex flex-col items-center justify-center text-center px-6 py-8">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl mb-2">
                        ⚡
                    </div>
                    <h3 class="text-base font-bold text-amber-900">
                        Anda Sedang Memiliki Pesanan Aktif
                    </h3>
                    <p class="mt-1 text-xs text-amber-700 max-w-md">
                        Selesaikan pesanan yang sedang berjalan di bawah ini terlebih dahulu agar Anda dapat menerima pesanan baru berikutnya.
                    </p>
                </div>
            @else
                <div class="bg-white border border-gray-200 rounded-2xl min-h-[250px] flex flex-col items-center justify-center text-center px-6 py-10">

                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500">

                        <svg width="28" height="28" viewBox="0 0 24 24" fill="none">

                            <rect
                                x="5"
                                y="3"
                                width="14"
                                height="18"
                                rx="2"
                                stroke="currentColor"
                                stroke-width="2"
                            />

                            <path
                                d="M9 9h6M9 13h6M9 17h4"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                            />

                        </svg>

                    </div>
                    <h3 class="mt-4 text-base font-semibold text-slate-700">
                        Belum ada order masuk
                    </h3>
                </div>
            @endif

        @endif

    </section>
    <div class="h-6 sm:h-6"></div>
    <section id="sedang-dikerjakan">

        <div class="mb-4">
            <h2 class="text-2xl font-bold text-slate-900">
                Sedang Dikerjakan
            </h2>
        </div>


        {{-- ADA ORDER YANG DITERIMA --}}
        @if(isset($orderDikerjakan) && $orderDikerjakan->count() > 0)

            <div class="space-y-4">

                @foreach($orderDikerjakan as $order)

                    <div class="bg-white border border-gray-200 rounded-2xl p-5 sm:p-6">

                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-5">

                            {{-- INFORMASI --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">

                                    <h3 class="font-bold text-slate-900 text-base sm:text-lg">
                                        {{ $order->subCategory->nama_sub_kategori ?? 'Layanan' }}
                                    </h3>


                                    {{-- STATUS DIKONFIRMASI --}}
                                    @if($order->status === 'Dikonfirmasi')

                                        <span class="self-start px-2.5 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold">
                                            Dikonfirmasi
                                        </span>


                                    {{-- STATUS DIKERJAKAN --}}
                                    @elseif($order->status === 'Dikerjakan')

                                        <span class="self-start px-2.5 py-1 rounded-full bg-green-50 text-green-600 text-xs font-semibold">
                                            Dikerjakan
                                        </span>

                                    {{-- STATUS PENGAJUAN BATAL --}}
                                    @elseif($order->status === 'Pengajuan_Batal')

                                        <span class="self-start px-2.5 py-1 rounded-full bg-red-50 text-red-600 text-xs font-bold border border-red-200">
                                            🚨 Menunggu Verifikasi Batal Admin
                                        </span>

                                    @endif

                                </div>


                                <div class="mt-3 space-y-1.5">

                                    <p class="text-sm text-slate-500">
                                        Pelanggan:
                                        <span class="font-medium text-slate-700">
                                            {{ $order->pelanggan->nama ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        No. HP Pelanggan:
                                        <span class="font-medium text-slate-700">
                                            {{ $order->pelanggan->no_hp ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        Alamat:
                                        <span class="font-medium text-slate-700">
                                            {{ $order->alamat ?? '-' }}
                                        </span>
                                    </p>

                                    <p class="text-sm text-slate-400">
                                        Jadwal:
                                        {{ $order->jadwal
                                            ? \Carbon\Carbon::parse($order->jadwal)->format('d M Y, H:i')
                                            : '-' }}
                                    </p>

                                    @if($order->pelanggan)
                                        <div class="pt-2 flex flex-wrap gap-2">
                                            <a
                                                href="{{ $order->pelanggan->getWhatsappLinkWithMessage('Halo ' . $order->pelanggan->nama . ', saya teknisi dari Home Improvement untuk order #' . $order->id_order . ' (' . $order->subCategory->nama_sub_kategori . ').') }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition border border-emerald-200"
                                            >
                                                💬 Hubungi Pelanggan via WhatsApp
                                            </a>
                                            <a
                                                href="tel:{{ $order->pelanggan->no_hp }}"
                                                class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold transition"
                                            >
                                                📞 Telepon Pelanggan
                                            </a>
                                        </div>
                                    @endif

                                </div>

                            </div>


                            {{-- TOTAL --}}
                            <div class="lg:text-right shrink-0">

                                <p class="text-xs text-slate-400">
                                    Total
                                </p>

                                <p class="mt-1 text-lg sm:text-xl font-bold text-blue-600">
                                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                </p>

                            </div>

                        </div>

                        {{-- BANNER JIKA DALAM STATS PENGAJUAN BATAL --}}
                        @if($order->status === 'Pengajuan_Batal')
                            <div class="mt-4 p-4 rounded-2xl bg-red-50 border border-red-200 text-xs text-red-800 space-y-1">
                                <div class="font-bold text-sm flex items-center gap-2">
                                    <span>🚨 Pengajuan Pembatalan Terkirim ke Admin</span>
                                </div>
                                <p><strong>Alasan Kendala:</strong> {{ $order->alasan_batal_teknisi ?? '-' }}</p>
                                <p><strong>Catatan:</strong> {{ $order->catatan_batal_teknisi ?? '-' }}</p>
                                <p class="text-[11px] text-red-600 mt-1 italic">
                                    Admin sedang meninjau laporan kendala Anda. Jika disetujui, sistem akan otomatis mengalihkan pesanan ke teknisi lain.
                                </p>
                            </div>
                        @endif


                        {{-- ================================================= --}}
                        {{-- DIKONFIRMASI → MULAI DIKERJAKAN (SUDAH DI LOKASI) --}}
                        {{-- ================================================= --}}

                        @if($order->status === 'Dikonfirmasi')

                            @php
                                $waktuDiterima = $order->waktu_diterima ?? $order->created_at;
                                $batasWaktu = \Carbon\Carbon::parse($waktuDiterima)->addMinutes(60);
                                $sisaDetikTotal = max(0, (int) floor(now()->diffInSeconds($batasWaktu, false)));
                                $jamSisa = floor($sisaDetikTotal / 3600);
                                $menitSisa = floor(($sisaDetikTotal % 3600) / 60);
                                $detikSisa = $sisaDetikTotal % 60;
                            @endphp

                            <div class="mt-4 p-4 rounded-2xl border border-amber-200 bg-amber-50/80 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-amber-900">
                                <div class="flex items-center gap-2.5">
                                    <span class="text-xl">⏱️</span>
                                    <div>
                                        <span class="font-bold text-amber-900 text-sm">Batas Waktu Tiba di Lokasi (1 Jam):</span>
                                        <p class="text-xs text-amber-700 mt-0.5">Klik tombol di bawah setelah Anda tiba di lokasi pelanggan.</p>
                                    </div>
                                </div>
                                <div class="text-left sm:text-right shrink-0">
                                    <span class="inline-block px-3.5 py-1.5 rounded-xl bg-amber-200/90 font-mono font-bold text-amber-950 text-xs shadow-2xs" id="countdown-{{ $order->id_order }}">
                                        {{ sprintf('%02d Jam %02d Menit %02d Detik', $jamSisa, $menitSisa, $detikSisa) }}
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <form
                                    action="{{ route('order.mulai', $order->id_order) }}"
                                    method="POST"
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-blue-600 transition flex items-center justify-center gap-2 shadow-xs"
                                    >
                                        📍 Mulai Dikerjakan (Sudah di Lokasi)
                                    </button>
                                </form>

                                <button
                                    type="button"
                                    onclick="openModalKendala('{{ $order->id_order }}')"
                                    class="w-full px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 text-sm font-semibold transition flex items-center justify-center gap-2"
                                >
                                    🚨 Laporkan Kendala / Minta Batal
                                </button>
                            </div>

                            <script>
                                (function() {
                                    let sisaDetik = {{ (int) $sisaDetikTotal }};
                                    const countdownEl = document.getElementById('countdown-{{ $order->id_order }}');
                                    if (!countdownEl) return;

                                    function updateTimerText() {
                                        if (sisaDetik <= 0) {
                                            countdownEl.innerText = "00 Jam 00 Menit 00 Detik (Waktu Habis)";
                                            countdownEl.className = "inline-block px-3.5 py-1.5 rounded-xl bg-red-600 font-mono font-bold text-white text-xs shadow-xs";
                                            return true;
                                        }
                                        let h = Math.floor(sisaDetik / 3600);
                                        let m = Math.floor((sisaDetik % 3600) / 60);
                                        let s = Math.floor(sisaDetik % 60);

                                        let textH = String(h).padStart(2, '0') + ' Jam ';
                                        let textM = String(m).padStart(2, '0') + ' Menit ';
                                        let textS = String(s).padStart(2, '0') + ' Detik';

                                        countdownEl.innerText = textH + textM + textS;
                                        return false;
                                    }

                                    updateTimerText();
                                    const timerInterval = setInterval(function() {
                                        sisaDetik--;
                                        if (updateTimerText()) {
                                            clearInterval(timerInterval);
                                        }
                                    }, 1000);
                                })();
                            </script>

                        {{-- ================================================= --}}
                        {{-- DIKERJAKAN → SELESAI (DENGAN BUKTI FOTO) --}}
                        {{-- ================================================= --}}

                        @elseif($order->status === 'Dikerjakan')

                            <form
                                action="{{ route('order.selesai', $order->id_order) }}"
                                method="POST"
                                enctype="multipart/form-data"
                                class="mt-4 space-y-3"
                            >

                                @csrf

                                <div class="p-4 rounded-xl border border-blue-200 bg-blue-50/50">
                                    <label class="block text-xs font-bold text-slate-800 mb-1">
                                        📸 Upload Bukti Foto Hasil Perbaikan (Wajib)
                                    </label>
                                    <p class="text-[11px] text-slate-500 mb-2">
                                        Lampirkan bukti foto perbaikan agar pesanan dapat diselesaikan.
                                    </p>
                                    <input
                                        type="file"
                                        name="foto_bukti"
                                        accept="image/*"
                                        required
                                        class="block w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-900 file:text-white hover:file:bg-blue-600 file:cursor-pointer cursor-pointer bg-white rounded-xl border border-slate-200 p-1"
                                    >
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3">
                                    <button
                                        type="submit"
                                        class="flex-1 px-4 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-emerald-600 transition flex items-center justify-center gap-2"
                                    >
                                        ✅ Tandai Selesai & Kirim Bukti
                                    </button>

                                    <button
                                        type="button"
                                        onclick="openModalKendala('{{ $order->id_order }}')"
                                        class="px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 text-sm font-semibold transition flex items-center justify-center gap-2"
                                    >
                                        🚨 Minta Batal
                                    </button>
                                </div>

                            </form>

                        @endif

                        {{-- MODAL POPUP LAPORKAN KENDALA --}}
                        <div id="modalLaporkanKendala-{{ $order->id_order }}" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
                            <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100">
                                <form action="{{ route('order.ajukan-batal', $order->id_order) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="bg-red-600 text-white p-5 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <span class="text-2xl">🚨</span>
                                            <div>
                                                <h3 class="text-base font-bold">Laporkan Kendala / Minta Batal</h3>
                                                <p class="text-xs text-red-100">Order #{{ $order->id_order }} - {{ $order->subCategory->nama_sub_kategori ?? 'Layanan' }}</p>
                                            </div>
                                        </div>
                                        <button type="button" onclick="closeModalKendala('{{ $order->id_order }}')" class="text-white hover:text-red-200">✕</button>
                                    </div>

                                    <div class="p-5 space-y-4 text-xs">
                                        <div>
                                            <label class="block font-bold text-slate-800 mb-1">Alasan Utama Kendala / Pembatalan *</label>
                                            <select name="alasan_batal_teknisi" required class="w-full rounded-xl border border-slate-300 p-2.5 text-slate-800 text-xs focus:ring-red-500 focus:border-red-500">
                                                <option value="">-- Pilih Alasan Utama --</option>
                                                <option value="Terlambat >1 Jam / Macet Parah">Terlambat >1 Jam / Terjebak Macet Parah</option>
                                                <option value="Ban Bocor / Kendaraan Mogok">Ban Bocor / Kendaraan Mogok</option>
                                                <option value="Sakit Mendadak / Hal Darurat">Sakit Mendadak / Hal Darurat Keluarga</option>
                                                <option value="Peralatan Perbaikan Rusak/Kurang">Peralatan Perbaikan Rusak / Tidak Lengkap</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block font-bold text-slate-800 mb-1">Penjelasan Catatan Kendala *</label>
                                            <textarea name="catatan_batal_teknisi" rows="3" required placeholder="Jelaskan secara singkat kendala yang dialami agar Admin dapat memverifikasi..." class="w-full rounded-xl border border-slate-300 p-2.5 text-slate-800 text-xs focus:ring-red-500 focus:border-red-500"></textarea>
                                        </div>

                                        <div>
                                            <label class="block font-bold text-slate-800 mb-1">Upload Foto Bukti Kendala (Opsional)</label>
                                            <input type="file" name="foto_kendala" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 bg-white border border-slate-200 rounded-xl p-1 cursor-pointer">
                                        </div>
                                    </div>

                                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex items-center justify-end gap-3">
                                        <button type="button" onclick="closeModalKendala('{{ $order->id_order }}')" class="px-4 py-2 rounded-xl bg-slate-200 text-slate-700 text-xs font-semibold hover:bg-slate-300">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-5 py-2 rounded-xl bg-red-600 text-white text-xs font-bold hover:bg-red-700 shadow-md">
                                            Kirim Pengajuan ke Admin
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>

                @endforeach

            </div>


        {{-- TIDAK ADA PEKERJAAN --}}
        @else

            <div class="bg-white border border-gray-200 rounded-2xl min-h-[200px] flex flex-col items-center justify-center text-center px-6">

                <div class="w-16 h-16 rounded-2xl bg-green-50 flex items-center justify-center text-green-500">

                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none">

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                            stroke="currentColor"
                            stroke-width="2"
                        />

                        <path
                            d="M8 12l2.5 2.5L16 9"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        />

                    </svg>

                </div>


                <h3 class="mt-4 text-base font-semibold text-slate-700">
                    Tidak ada pekerjaan aktif
                </h3>


                <p class="mt-2 text-sm text-slate-400">
                    Order yang sudah diterima akan muncul di sini.
                </p>

            </div>

        @endif

    </section>

</div>

{{-- ========================================================= --}}
{{-- MODAL POPUP RINCIAN PENDAPATAN TEKNISI --}}
{{-- ========================================================= --}}
<div id="modalRincianPendapatan" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 transition-all duration-300">
    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100 animate-in fade-in zoom-in duration-200">

        {{-- MODAL HEADER --}}
        <div class="bg-slate-900 text-white p-5 flex items-center justify-between" style="background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 flex items-center justify-center font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-9h6a2 2 0 010 4H9a2 2 0 000 4h6" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white">Rincian Pendapatan Order</h3>
                    <p class="text-xs text-slate-300 mt-0.5">Total Cair: <span class="text-emerald-400 font-extrabold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span></p>
                </div>
            </div>
            <button type="button" onclick="closeModalRincianPendapatan()" class="w-8 h-8 rounded-full bg-white/10 text-slate-300 hover:text-white hover:bg-white/20 flex items-center justify-center transition cursor-pointer">
                ✕
            </button>
        </div>

        {{-- MODAL BODY LIST --}}
        <div class="p-5 max-h-[60vh] overflow-y-auto space-y-3">
            @forelse($rincianPendapatan as $order)
                <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/70 hover:border-emerald-300 hover:bg-emerald-50/30 transition flex items-center justify-between gap-3">
                    <div class="min-w-0 flex-1">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900 text-sm truncate">
                                {{ $order->subCategory->nama_sub_kategori ?? 'Layanan Perbaikan' }}
                            </span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 shrink-0">
                                #{{ $order->id_order }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-500 mt-1">
                            Pelanggan: <span class="font-medium text-slate-700">{{ $order->pelanggan->nama ?? '-' }}</span>
                        </p>
                        <p class="text-[11px] text-slate-400 mt-0.5">
                            Selesai: {{ \Carbon\Carbon::parse($order->updated_at ?? $order->created_at)->format('d M Y, H:i') }} WIB
                        </p>
                    </div>

                    <div class="text-right shrink-0">
                        <span class="font-extrabold text-emerald-600 text-base block">
                            + Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                        <a href="{{ route('dashboard.detail-order', $order->id_order) }}" class="inline-flex items-center gap-1 text-[11px] font-bold text-sky-600 hover:text-sky-700 hover:underline mt-1">
                            Detail Order →
                        </a>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-9h6a2 2 0 010 4H9a2 2 0 000 4h6" />
                        </svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Belum Ada Pendapatan</p>
                    <p class="text-xs text-slate-400 mt-1">Order berstatus "Selesai" akan masuk secara otomatis di sini.</p>
                </div>
            @endforelse
        </div>

        {{-- MODAL FOOTER --}}
        <div class="p-4 bg-slate-50 border-t border-slate-100 text-right">
            <button type="button" onclick="closeModalRincianPendapatan()" class="px-5 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition cursor-pointer">
                Tutup
            </button>
        </div>
    </div>
</div>

<script>
    function openModalRincianPendapatan() {
        const modal = document.getElementById('modalRincianPendapatan');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModalRincianPendapatan() {
        const modal = document.getElementById('modalRincianPendapatan');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function openModalKendala(idOrder) {
        const modal = document.getElementById('modalLaporkanKendala-' + idOrder);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModalKendala(idOrder) {
        const modal = document.getElementById('modalLaporkanKendala-' + idOrder);
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>

@endsection