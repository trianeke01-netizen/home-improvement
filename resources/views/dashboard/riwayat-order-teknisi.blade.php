@extends('layouts.dashboard')

@section('title', 'Riwayat Order')

@section('content')

<div class="space-y-8">

    @if(session('success'))

        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-green-600 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>

                </svg>

                <span class="font-medium text-green-700">
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- EMPTY STATE --}}
    {{-- ========================================================= --}}

    @if($orders->isEmpty())

        <div
            class="bg-white
                   rounded-3xl
                   border border-slate-200
                   shadow-sm
                   p-12 md:p-16
                   text-center">

            {{-- Icon --}}
            <div
                class="w-24 h-24
                       rounded-full
                       bg-sky-100
                       flex items-center justify-center
                       mx-auto mb-6">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-12 h-12 text-sky-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/>

                </svg>

            </div>
            <h2 class="text-2xl font-bold text-slate-800">
                Belum Ada Riwayat Order
            </h2>
        </div>


    {{-- ========================================================= --}}
    {{-- LIST ORDER --}}
    {{-- ========================================================= --}}

    @else

        <div class="space-y-5">

            @foreach($orders as $order)

                <div
                    class="bg-white
                           rounded-3xl
                           border border-slate-200
                           shadow-sm
                           overflow-hidden">


                    {{-- ================================================= --}}
                    {{-- HEADER CARD --}}
                    {{-- ================================================= --}}

                    <div
                        class="bg-gradient-to-r
                               from-sky-50
                               to-blue-50
                               px-6 py-5">

                        <div
                            class="flex flex-col
                                   sm:flex-row
                                   sm:items-start
                                   sm:justify-between
                                   gap-4">


                            {{-- KATEGORI --}}
                            <div>

                                <h2
                                    class="text-xl font-bold
                                           text-slate-800">

                                    {{ optional(optional($order->subCategory)->category)->nama_kategori
                                        ?? 'Kategori Layanan' }}

                                </h2>


                                <p class="text-slate-500 mt-1">

                                    {{ optional($order->subCategory)->nama_sub_kategori
                                        ?? 'Layanan' }}

                                </p>

                            </div>


                            {{-- ================================================= --}}
                            {{-- STATUS --}}
                            {{-- ================================================= --}}

                            @php
                                $isMyObstacle = $order->alasan_batal_teknisi && (
                                    (int)$order->id_teknisi !== (int)auth()->user()->id_user || 
                                    $order->status === 'Pengajuan_Batal'
                                );
                            @endphp

                            @if($order->status === 'Pengajuan_Batal')
                                <span class="inline-flex w-fit px-4 py-2 rounded-full bg-rose-100 text-rose-700 text-sm font-semibold animate-pulse">
                                    🚨 Kendala Diajukan (Menunggu Admin)
                                </span>
                            @elseif($isMyObstacle)
                                <span class="inline-flex w-fit px-4 py-2 rounded-full bg-amber-100 text-amber-800 text-sm font-semibold">
                                    🚨 Kendala Disetujui Admin (Dialihkan)
                                </span>
                            @else
                                @switch($order->status)

                                    @case('Menunggu')

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-amber-100
                                                   text-amber-700
                                                   text-sm
                                                   font-semibold">

                                            Dipesan

                                        </span>

                                        @break


                                    @case('Dikonfirmasi')

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-blue-100
                                                   text-blue-700
                                                   text-sm
                                                   font-semibold">

                                            Dikonfirmasi

                                        </span>

                                        @break


                                    @case('Diproses')

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-sky-100
                                                   text-sky-700
                                                   text-sm
                                                   font-semibold">

                                            Dikerjakan

                                        </span>

                                        @break


                                    @case('Selesai')

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-emerald-100
                                                   text-emerald-700
                                                   text-sm
                                                   font-semibold">

                                            Selesai

                                        </span>

                                        @break


                                    @case('Dibatalkan')

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-red-100
                                                   text-red-700
                                                   text-sm
                                                   font-semibold">

                                            Dibatalkan

                                        </span>

                                        @break


                                    @default

                                        <span
                                            class="inline-flex
                                                   w-fit
                                                   px-4 py-2
                                                   rounded-full
                                                   bg-slate-100
                                                   text-slate-600
                                                   text-sm
                                                   font-semibold">

                                            {{ $order->status }}

                                        </span>

                                @endswitch
                            @endif

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- BODY CARD --}}
                    {{-- ================================================= --}}

                    <div class="p-6">


                        <div
                            class="grid
                                   grid-cols-1
                                   sm:grid-cols-2
                                   md:grid-cols-3
                                   gap-6">


                            {{-- ================================================= --}}
                            {{-- JADWAL --}}
                            {{-- ================================================= --}}

                            <div>

                                <p class="text-sm text-slate-400">
                                    Jadwal
                                </p>

                                @if($order->jadwal)

                                    <h4
                                        class="mt-1
                                               font-semibold
                                               text-slate-800">

                                        {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}

                                    </h4>

                                    <p class="text-sm text-slate-500">

                                        {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }}

                                    </p>

                                @else

                                    <h4
                                        class="mt-1
                                               font-semibold
                                               text-slate-500">

                                        Belum ditentukan

                                    </h4>

                                @endif

                            </div>


                            {{-- ================================================= --}}
                            {{-- TOTAL BIAYA --}}
                            {{-- ================================================= --}}

                            <div>

                                <p class="text-sm text-slate-400">
                                    Total Biaya
                                </p>

                                <h4
                                    class="mt-1
                                           text-xl
                                           font-bold
                                           text-sky-600">

                                    Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}

                                </h4>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PELANGGAN --}}
                            {{-- ================================================= --}}

                            <div>

                                <p class="text-sm text-slate-400">
                                    Pelanggan
                                </p>

                                <h4
                                    class="mt-1
                                           font-semibold
                                           text-slate-800">

                                    {{ optional($order->pelanggan)->nama
                                        ?? 'Tidak diketahui' }}

                                </h4>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ALAMAT --}}
                        {{-- ================================================= --}}

                        @if($order->alamat)

                            <div
                                class="mt-6
                                       pt-5
                                       border-t
                                       border-slate-100">

                                <p class="text-sm text-slate-400">
                                    Alamat
                                </p>

                                <p
                                    class="mt-1
                                           text-sm
                                           text-slate-600">

                                    {{ $order->alamat }}

                                </p>

                            </div>

                        @endif

                        @if($order->foto_bukti)
                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center gap-3">
                                <span class="text-xs font-semibold text-emerald-700">📸 Bukti Foto Perbaikan:</span>
                                <a href="{{ asset('storage/' . $order->foto_bukti) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->foto_bukti) }}" alt="Bukti Foto" class="w-14 h-14 object-cover rounded-xl border-2 border-emerald-500 hover:opacity-80 transition">
                                </a>
                            </div>
                        @endif

                        @if($order->alasan_batal_teknisi)
                            <div class="mt-6 rounded-2xl border border-amber-200/90 bg-gradient-to-br from-amber-50/90 via-orange-50/60 to-amber-50/90 p-5 shadow-xs">
                                {{-- Header Title & Time --}}
                                <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-amber-200/60">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-xl bg-amber-100 border border-amber-200 flex items-center justify-center shrink-0">
                                            <svg class="w-4 h-4 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                            </svg>
                                        </div>
                                        <h4 class="font-bold text-amber-900 text-sm sm:text-base">Laporan Kendala Teknisi</h4>
                                    </div>

                                    @if($order->waktu_pengajuan_batal)
                                        <span class="text-xs font-semibold px-3 py-1 rounded-full bg-amber-100/80 text-amber-800 border border-amber-200/60">
                                            🕒 {{ \Carbon\Carbon::parse($order->waktu_pengajuan_batal)->translatedFormat('d M Y, H:i') }} WIB
                                        </span>
                                    @endif
                                </div>

                                {{-- Details Content --}}
                                <div class="mt-3.5 space-y-3 text-xs sm:text-sm">
                                    <div>
                                        <span class="text-slate-500 block text-xs font-medium uppercase tracking-wider mb-1">Alasan Utama</span>
                                        <span class="inline-block px-3 py-1 rounded-xl bg-amber-200/60 text-amber-900 font-semibold border border-amber-300/50">
                                            {{ $order->alasan_batal_teknisi }}
                                        </span>
                                    </div>

                                    <div>
                                        <span class="text-slate-500 block text-xs font-medium uppercase tracking-wider mb-1">Catatan Penjelasan</span>
                                        <div class="p-3 rounded-xl bg-white/90 border border-amber-200/50 text-slate-800 font-medium leading-relaxed shadow-2xs">
                                            {{ $order->catatan_batal_teknisi }}
                                        </div>
                                    </div>

                                    @if($order->foto_kendala)
                                        <div class="pt-2 border-t border-amber-200/50">
                                            <span class="text-slate-500 block text-xs font-medium uppercase tracking-wider mb-2">Foto Bukti Kendala</span>
                                            <a href="{{ asset('storage/' . $order->foto_kendala) }}" target="_blank" class="inline-flex items-center gap-3 p-2 rounded-xl bg-white/90 border border-amber-200/60 hover:border-amber-400 transition group shadow-2xs">
                                                <img src="{{ asset('storage/' . $order->foto_kendala) }}" alt="Foto Kendala" class="w-14 h-14 object-cover rounded-lg border border-amber-200 group-hover:scale-105 transition shrink-0">
                                                <div class="pr-2">
                                                    <span class="text-xs font-bold text-amber-900 block group-hover:text-amber-600 transition">Lihat Foto Lengkap ↗</span>
                                                    <span class="text-[11px] text-slate-400">Klik untuk melebarkan gambar</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- ================================================= --}}
                        {{-- BUTTON DETAIL --}}
                        {{-- ================================================= --}}

                        <div class="mt-6 flex justify-end">

                            <a
                                href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                class="inline-flex
                                       items-center
                                       gap-2
                                       rounded-xl
                                       bg-sky-600
                                       hover:bg-sky-700
                                       px-5 py-3
                                       text-sm
                                       font-semibold
                                       text-white
                                       transition
                                       cursor-pointer">

                                Lihat Detail


                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-4 h-4"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5l7 7-7 7"/>

                                </svg>

                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection