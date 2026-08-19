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
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg shrink-0">
                ⚠️
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
            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-700 flex items-center justify-center font-bold text-lg shrink-0">
                ❌
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
    {{-- STATISTIK --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- TOTAL ORDER --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-semibold text-slate-400">
                        Total Order
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $totalOrder ?? 0 }}
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-500 shrink-0">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
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
                            d="M9 3.5V2h6v1.5"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                        <path
                            d="M9 9h6M9 13h6M9 17h4"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>
                </div>

            </div>
        </div>


        {{-- ORDER HARI INI --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-semibold text-slate-400">
                        Order Hari Ini
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $orderHariIni ?? 0 }}
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 shrink-0">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
                        <rect
                            x="3"
                            y="5"
                            width="18"
                            height="16"
                            rx="2"
                            stroke="currentColor"
                            stroke-width="2"
                        />
                        <path
                            d="M16 3v4M8 3v4M3 10h18"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                        />
                    </svg>
                </div>

            </div>
        </div>


        {{-- RATING --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-semibold text-slate-400">
                        Rating
                    </p>

                    <div class="mt-4 flex items-center gap-2">
                        <p class="text-3xl font-bold text-slate-900">
                            {{ number_format($rating ?? 0, 1) }}
                        </p>

                        <span class="text-slate-400 text-lg">
                            ★
                        </span>
                    </div>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 shrink-0">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.5l2.9 5.88 6.49.94-4.7 4.58 1.11 6.47L12 17.32l-5.8 3.05 1.11-6.47-4.7-4.58 6.49-.94L12 2.5z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- ORDER SELESAI --}}
        <div class="bg-white border border-gray-200 rounded-2xl p-6">
            <div class="flex items-start justify-between gap-4">

                <div>
                    <p class="text-sm font-semibold text-slate-400">
                        Order Selesai
                    </p>

                    <p class="mt-4 text-3xl font-bold text-slate-900">
                        {{ $orderSelesai ?? 0 }}
                    </p>
                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-500 shrink-0">
                    <svg width="25" height="25" viewBox="0 0 24 24" fill="none">
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

            </div>
        </div>

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

                        </div>

                    </div>

                @endforeach

            </div>


        {{-- JIKA TIDAK ADA ORDER --}}
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


                        {{-- ================================================= --}}
                        {{-- DIKONFIRMASI → MULAI DIKERJAKAN (SUDAH DI LOKASI) --}}
                        {{-- ================================================= --}}

                        @if($order->status === 'Dikonfirmasi')

                            @php
                                $waktuDiterima = $order->waktu_diterima ?? $order->created_at;
                                $batasWaktu = \Carbon\Carbon::parse($waktuDiterima)->addMinutes(60);
                                $sisaDetik = max(0, now()->diffInSeconds($batasWaktu, false));
                                $menitSisa = floor($sisaDetik / 60);
                                $detikSisa = $sisaDetik % 60;
                            @endphp

                            <div class="mt-4 p-3.5 rounded-xl border border-amber-200 bg-amber-50 flex items-center justify-between text-xs text-amber-800">
                                <div class="flex items-center gap-2">
                                    <span class="text-base">⏱️</span>
                                    <div>
                                        <span class="font-bold">Batas Waktu Tiba di Lokasi (1 Jam):</span>
                                        <p class="text-[11px] text-amber-700">Klik tombol di bawah setelah Anda tiba di lokasi pelanggan.</p>
                                    </div>
                                </div>
                                <div class="text-right shrink-0">
                                    <span class="inline-block px-3 py-1 rounded-lg bg-amber-200/80 font-mono font-bold text-amber-900 text-xs shadow-2xs" id="countdown-{{ $order->id_order }}">
                                        {{ sprintf('%02d:%02d', $menitSisa, $detikSisa) }}
                                    </span>
                                </div>
                            </div>

                            <form
                                action="{{ route('order.mulai', $order->id_order) }}"
                                method="POST"
                                class="mt-4"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-blue-600 transition flex items-center justify-center gap-2"
                                >
                                    📍 Mulai Dikerjakan (Sudah di Lokasi)
                                </button>

                            </form>

                            <script>
                                (function() {
                                    let sisaDetik = {{ $sisaDetik }};
                                    const countdownEl = document.getElementById('countdown-{{ $order->id_order }}');
                                    if (!countdownEl) return;

                                    const timer = setInterval(function() {
                                        if (sisaDetik <= 0) {
                                            clearInterval(timer);
                                            countdownEl.innerText = "WAKTU HABIS";
                                            countdownEl.classList.remove('bg-amber-200/80', 'text-amber-900');
                                            countdownEl.classList.add('bg-red-600', 'text-white');
                                            return;
                                        }
                                        sisaDetik--;
                                        let m = Math.floor(sisaDetik / 60);
                                        let s = sisaDetik % 60;
                                        countdownEl.innerText = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
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

                                <button
                                    type="submit"
                                    class="w-full px-4 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-emerald-600 transition flex items-center justify-center gap-2"
                                >
                                    ✅ Tandai Selesai & Kirim Bukti
                                </button>

                            </form>

                        @endif

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

@endsection