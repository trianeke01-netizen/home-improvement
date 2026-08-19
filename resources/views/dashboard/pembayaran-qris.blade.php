@extends('layouts.dashboard')

@section('title', 'Pembayaran QRIS')

@section('content')

<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-bold text-slate-800">
            Pembayaran QRIS
        </h1>
    </div>

    <div
        class="rounded-2xl
               border border-sky-200
               bg-sky-50
               px-5 py-4">

        <div class="flex items-start gap-3">

            <div
                class="w-9 h-9
                       rounded-full
                       bg-sky-100
                       flex items-center justify-center
                       shrink-0">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-sky-600"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z"/>

                </svg>

            </div>

            <div>

                <p class="font-semibold text-sky-800">
                    Pembayaran QRIS
                </p>
            </div>
        </div>
    </div>

    <div
        class="bg-white
               rounded-3xl
               border border-slate-200
               shadow-sm
               overflow-hidden">

        <div
            class="bg-sky-50
                   px-7 py-6
                   border-b border-sky-100">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <p class="text-sm text-slate-500">
                        Layanan yang dipesan
                    </p>

                    <h2
                        class="text-2xl
                               font-bold
                               text-slate-800
                               mt-1">

                        {{ $order->subCategory->category->nama_kategori }}

                    </h2>

                    <p class="text-slate-500 mt-1">

                        {{ $order->subCategory->nama_sub_kategori }}

                    </p>

                </div>


                {{-- STATUS --}}

                <span
                    class="px-4 py-2
                           rounded-full
                           bg-yellow-100
                           text-yellow-700
                           text-sm
                           font-semibold
                           shrink-0">

                    Menunggu Pembayaran

                </span>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BODY --}}
        {{-- ================================================= --}}

        <div class="p-7">

            <div
                class="grid
                       grid-cols-1
                       md:grid-cols-2
                       gap-8">


                {{-- ================================================= --}}
                {{-- QRIS --}}
                {{-- ================================================= --}}

                <div
                    class="border
                           border-slate-200
                           rounded-2xl
                           p-6
                           text-center">


                    <h3
                        class="text-lg
                               font-bold
                               text-slate-800">

                        Scan QRIS

                    </h3>

                    {{-- QR DUMMY --}}

                    <div
                        class="w-56 h-56
                               mx-auto
                               bg-white
                               border
                               border-slate-200
                               rounded-2xl
                               p-4
                               shadow-sm">

                        <div
                            class="w-full h-full
                                   grid grid-cols-9
                                   gap-1
                                   bg-slate-900
                                   p-3">

                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>

                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>

                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>

                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>

                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>

                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>

                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>

                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>

                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>
                            <span class="bg-white"></span>
                            <span></span>

                        </div>
                    </div>
                </div>

                <div>
                    <h3
                        class="text-lg
                               font-bold
                               text-slate-800
                               mb-5">
                        Detail Pembayaran
                    </h3>


                    {{-- JUMLAH UNIT --}}

                    <div
                        class="flex
                               items-center
                               justify-between
                               py-4
                               border-b
                               border-slate-100">

                        <span class="text-sm text-slate-500">
                            Jumlah Unit
                        </span>

                        <span
                            class="font-semibold
                                   text-slate-800">

                            {{ $order->jumlah_unit }}

                        </span>

                    </div>


                    {{-- HARGA UNIT --}}

                    <div
                        class="flex
                               items-center
                               justify-between
                               py-4
                               border-b
                               border-slate-100">

                        <span class="text-sm text-slate-500">
                            Harga / Unit
                        </span>

                        <span
                            class="font-semibold
                                   text-slate-800">

                            Rp {{ number_format(
                                $order->harga_per_unit,
                                0,
                                ',',
                                '.'
                            ) }}

                        </span>

                    </div>


                    {{-- METODE PEMBAYARAN --}}

                    <div
                        class="flex
                               items-center
                               justify-between
                               py-4
                               border-b
                               border-slate-100">

                        <span class="text-sm text-slate-500">
                            Metode Pembayaran
                        </span>

                        <span
                            class="font-semibold
                                   text-slate-800">

                            QRIS

                        </span>

                    </div>


                    {{-- TOTAL --}}

                    <div
                        class="mt-5
                               rounded-2xl
                               bg-sky-50
                               border border-sky-100
                               px-5 py-5">

                        <p
                            class="text-sm
                                   text-slate-500">

                            Total Pembayaran

                        </p>

                        <p
                            class="text-3xl
                                   font-bold
                                   text-sky-600
                                   mt-1">

                            Rp {{ number_format(
                                $order->total_harga,
                                0,
                                ',',
                                '.'
                            ) }}

                        </p>

                    </div>

                    <form
                        action="{{ route(
                            'dashboard.pembayaran-qris.simulasi',
                            $order->id_order
                        ) }}"
                        method="POST"
                        class="mt-5">

                        @csrf

                        <button
                            type="submit"
                            class="w-full
                                   inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-6
                                   py-3.5
                                   rounded-xl
                                   bg-gradient-to-r
                                   from-sky-500
                                   to-blue-600
                                   hover:from-sky-600
                                   hover:to-blue-700
                                   text-white
                                   font-semibold
                                   shadow-md
                                   transition">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-5 h-5"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                viewBox="0 0 24 24">

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M5 13l4 4L19 7"/>
                            </svg>
                            Pembayaran Berhasil
                        </button>
                    </form>

                    <p
                        class="text-xs
                               text-slate-400
                               text-center
                               mt-3">

                        Tombol ini digunakan untuk simulasi pembayaran
                        pada prototipe tugas akhir.

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection