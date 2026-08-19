@extends('layouts.dashboard')

@section('title', 'Riwayat Order')

@section('content')

<div class="space-y-8">

    {{-- =========================================================
         PESAN SUKSES
         ========================================================= --}}
    @if(session('success'))

        <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-green-600 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />

                </svg>

                <span class="font-medium text-green-700">
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =========================================================
         PESAN ERROR
         ========================================================= --}}
    @if(session('error'))

        <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4">

            <div class="flex items-center gap-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-red-600 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />

                </svg>

                <span class="font-medium text-red-700">
                    {{ session('error') }}
                </span>

            </div>

        </div>

    @endif


    {{-- =========================================================
         JIKA BELUM ADA ORDER
         ========================================================= --}}
    @if($orders->isEmpty())

        <div
            class="
                bg-white
                rounded-3xl
                border
                border-slate-200
                shadow-sm
                p-10
                sm:p-16
                text-center
            "
        >

            <div
                class="
                    w-24
                    h-24
                    rounded-full
                    bg-sky-100
                    flex
                    items-center
                    justify-center
                    mx-auto
                    mb-6
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-12 h-12 text-sky-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12h6m-6 4h6M7 4h10a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V6a2 2 0 012-2z"
                    />

                </svg>

            </div>


            <h2 class="text-2xl font-bold text-slate-800">
                Belum Ada Riwayat Order
            </h2>


            <p class="mt-3 text-slate-500">
                Pesanan yang telah Anda buat akan muncul di halaman ini.
            </p>


            <a
                href="{{ route('dashboard.pesan-layanan') }}"
                class="
                    inline-flex
                    items-center
                    justify-center
                    mt-8
                    px-6
                    py-3
                    rounded-xl
                    bg-gradient-to-r
                    from-sky-500
                    to-blue-600
                    hover:from-sky-600
                    hover:to-blue-700
                    text-white
                    font-semibold
                    transition
                "
            >
                + Pesan Layanan
            </a>

        </div>


    {{-- =========================================================
         ADA ORDER
         ========================================================= --}}
    @else

        <div class="space-y-5">

            @foreach($orders as $order)

                <div
                    class="
                        bg-white
                        rounded-3xl
                        border
                        border-slate-200
                        shadow-sm
                        overflow-hidden
                    "
                >

                    {{-- =================================================
                         HEADER CARD
                         ================================================= --}}
                    <div
                        class="
                            bg-gradient-to-r
                            from-sky-50
                            to-blue-50
                            px-5
                            sm:px-6
                            py-5
                        "
                    >

                        <div
                            class="
                                flex
                                flex-col
                                sm:flex-row
                                sm:items-start
                                sm:justify-between
                                gap-4
                            "
                        >

                            {{-- INFORMASI LAYANAN --}}
                            <div class="min-w-0">

                                <h2
                                    class="
                                        text-lg
                                        sm:text-xl
                                        font-bold
                                        text-slate-800
                                    "
                                >
                                    {{ $order->subCategory->category->nama_kategori ?? 'Layanan' }}
                                </h2>


                                <p class="text-slate-500 mt-1">
                                    {{ $order->subCategory->nama_sub_kategori ?? '-' }}
                                </p>

                            </div>


                            {{-- =================================================
                                 STATUS
                                 ================================================= --}}
                            <div class="shrink-0">

                                @switch($order->status)

                                    {{-- MENUNGGU --}}
                                    @case('Menunggu')

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-amber-100
                                                text-amber-700
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            Menunggu
                                        </span>

                                        @break


                                    {{-- DIKONFIRMASI --}}
                                    @case('Dikonfirmasi')

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-blue-100
                                                text-blue-700
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            Dikonfirmasi
                                        </span>

                                        @break


                                    {{-- DIKERJAKAN --}}
                                    @case('Dikerjakan')

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-sky-100
                                                text-sky-700
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            Dikerjakan
                                        </span>

                                        @break


                                    {{-- SELESAI --}}
                                    @case('Selesai')

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-emerald-100
                                                text-emerald-700
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            Selesai
                                        </span>

                                        @break


                                    {{-- DIBATALKAN --}}
                                    @case('Dibatalkan')

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-red-100
                                                text-red-700
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            Dibatalkan
                                        </span>

                                        @break


                                    {{-- STATUS LAIN --}}
                                    @default

                                        <span
                                            class="
                                                inline-flex
                                                px-4
                                                py-2
                                                rounded-full
                                                bg-gray-100
                                                text-gray-600
                                                text-sm
                                                font-semibold
                                            "
                                        >
                                            {{ $order->status ?? 'Tidak diketahui' }}
                                        </span>

                                @endswitch

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                         BODY
                         ================================================= --}}
                    <div class="p-5 sm:p-6">

                        <div
                            class="
                                grid
                                grid-cols-1
                                sm:grid-cols-2
                                md:grid-cols-3
                                gap-6
                            "
                        >

                            {{-- =================================================
                                 JADWAL
                                 ================================================= --}}
                            <div>

                                <p class="text-sm text-slate-400">
                                    Jadwal
                                </p>

                                @if($order->jadwal)

                                    <h4 class="mt-1 font-semibold text-slate-800">

                                        {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d F Y') }}

                                    </h4>

                                    <p class="text-sm text-slate-500">

                                        {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }}

                                    </p>

                                @else

                                    <h4 class="mt-1 font-semibold text-slate-800">
                                        -
                                    </h4>

                                @endif

                            </div>


                            {{-- =================================================
                                 TOTAL BIAYA
                                 ================================================= --}}
                            <div>

                                <p class="text-sm text-slate-400">
                                    Total Biaya
                                </p>

                                <h4
                                    class="
                                        mt-1
                                        text-xl
                                        font-bold
                                        text-sky-600
                                    "
                                >
                                    Rp
                                    {{ number_format(
                                        $order->total_harga ?? 0,
                                        0,
                                        ',',
                                        '.'
                                    ) }}
                                </h4>

                            </div>


                            {{-- =================================================
                                 TEKNISI
                                 ================================================= --}}
                            <div>

                                <p class="text-sm text-slate-400">
                                    Teknisi
                                </p>

                                <h4 class="mt-1 font-semibold text-slate-800">

                                    {{ optional($order->teknisi)->nama ?? 'Belum ada teknisi' }}

                                </h4>

                            </div>

                        </div>


                        {{-- =================================================
                             TOMBOL AKSI
                             ================================================= --}}
                        <div
                            class="
                                mt-6
                                pt-5
                                border-t
                                border-slate-100
                                flex
                                flex-col-reverse
                                sm:flex-row
                                sm:justify-end
                                gap-3
                            "
                        >

                            {{-- =================================================
                                 BATALKAN PESANAN
                                 HANYA SAAT MENUNGGU
                                 ================================================= --}}
                            @if($order->status === 'Menunggu')

                                <form
                                    action="{{ route('order.batalkan', $order->id_order) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')"
                                >

                                    @csrf

                                    <button
                                        type="submit"
                                        class="
                                            w-full
                                            sm:w-auto
                                            inline-flex
                                            items-center
                                            justify-center
                                            gap-2
                                            rounded-xl
                                            border
                                            border-red-200
                                            bg-red-50
                                            hover:bg-red-100
                                            px-5
                                            py-3
                                            text-sm
                                            font-semibold
                                            text-red-600
                                            cursor-pointer
                                            transition
                                        "
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="2"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M6 18L18 6M6 6l12 12"
                                            />

                                        </svg>

                                        Batalkan Pesanan

                                    </button>

                                </form>

                            @endif


                            {{-- LIHAT DETAIL --}}
                            <a
                                href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                class="
                                    w-full
                                    sm:w-auto
                                    inline-flex
                                    items-center
                                    justify-center
                                    gap-1.5
                                    rounded-xl
                                    bg-sky-600
                                    hover:bg-sky-700
                                    px-5
                                    py-2.5
                                    text-xs
                                    font-bold
                                    text-white
                                    transition
                                    shadow-sm
                                "
                            >
                                Lihat Detail &rsaquo;
                            </a>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection