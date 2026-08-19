<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Improvement</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-800">


    {{-- ========================================================= --}}
    {{-- NAVBAR --}}
    {{-- ========================================================= --}}

    <nav class="bg-white border-b border-slate-100">

        <div
            class="max-w-7xl mx-auto
                   px-6 sm:px-8 lg:px-10
                   h-16
                   flex items-center justify-end">

            <div class="flex items-center gap-8">

                {{-- MASUK --}}
                <a
                    href="{{ route('login') }}"
                    class="text-sm
                           font-semibold
                           text-slate-600
                           hover:text-sky-600
                           transition">

                    Masuk

                </a>


                {{-- DAFTAR --}}
                <a
                    href="{{ route('register') }}"
                    class="inline-flex
                           items-center
                           justify-center
                           px-7 py-2.5
                           rounded-xl
                           bg-slate-900
                           hover:bg-sky-600
                           text-white
                           text-sm
                           font-semibold
                           shadow-sm
                           transition">

                    Daftar

                </a>

            </div>

        </div>

    </nav>



    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}

    <section
        class="relative
               overflow-hidden
               bg-white">


        {{-- Background dekorasi --}}

        <div
            class="absolute
                   -top-32
                   -right-32
                   w-96 h-96
                   rounded-full
                   bg-sky-100/60
                   blur-3xl">
        </div>


        <div
            class="absolute
                   -bottom-40
                   -left-40
                   w-96 h-96
                   rounded-full
                   bg-blue-50
                   blur-3xl">
        </div>



        <div
            class="relative
                   max-w-7xl
                   mx-auto
                   px-6 sm:px-8 lg:px-10
                   py-8 lg:py-10">


            <div
                class="grid
                       lg:grid-cols-2
                       gap-8
                       lg:gap-12
                       items-center">


                {{-- ================================================= --}}
                {{-- BAGIAN KIRI --}}
                {{-- ================================================= --}}

                <div class="max-w-xl">


                    {{-- JUDUL --}}

                    <h1
                        class="text-4xl
                               sm:text-5xl
                               lg:text-5xl
                               font-bold
                               tracking-tight
                               leading-[1.08]
                               text-slate-900">

                        Rumah bermasalah?

                        <span class="block text-sky-600">

                            Pesan teknisi tepercaya.

                        </span>

                    </h1>



                    {{-- DESKRIPSI --}}

                    <p
                        class="mt-4
                               text-base
                               sm:text-lg
                               leading-relaxed
                               text-slate-500
                               max-w-lg">

                        Temukan teknisi sesuai kebutuhan perbaikan rumah
                        Anda dengan proses pemesanan yang mudah,
                        praktis, dan terpercaya.

                    </p>



                    {{-- BUTTON PESAN --}}

                    <div
                        class="flex
                               flex-col
                               sm:flex-row
                               gap-3
                               mt-5">

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-6 py-3
                                   rounded-xl
                                   bg-gradient-to-r
                                   from-sky-500
                                   to-blue-600
                                   hover:from-sky-600
                                   hover:to-blue-700
                                   text-white
                                   font-semibold
                                   shadow-lg
                                   shadow-sky-200
                                   transition">

                            Pesan Layanan


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
                                    d="M5 12h14" />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13 6l6 6-6 6" />

                            </svg>

                        </a>

                    </div>



                    {{-- TRUST POINT --}}

                    <div
                        class="flex
                               flex-wrap
                               items-center
                               gap-x-6
                               gap-y-2
                               mt-5
                               text-sm
                               text-slate-500">


                        {{-- TEKNISI TERPERCAYA --}}

                        <div class="flex items-center gap-2">

                            <div
                                class="w-5 h-5
                                       rounded-full
                                       bg-green-100
                                       text-green-600
                                       flex
                                       items-center
                                       justify-center">

                                ✓

                            </div>

                            Teknisi terpercaya

                        </div>



                        {{-- PEMESANAN MUDAH --}}

                        <div class="flex items-center gap-2">

                            <div
                                class="w-5 h-5
                                       rounded-full
                                       bg-sky-100
                                       text-sky-600
                                       flex
                                       items-center
                                       justify-center">

                                ✓

                            </div>

                            Pemesanan mudah

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- BAGIAN KANAN / LOGO --}}
                {{-- ================================================= --}}

                <div
                    class="flex
                           justify-center
                           lg:justify-end">


                    {{-- CARD BIRU LUAR --}}

                    <div
                        class="w-full
                               max-w-sm
                               rounded-[2rem]
                               bg-sky-50
                               border border-sky-100
                               p-4
                               shadow-xl
                               shadow-slate-200/60">


                        {{-- CARD PUTIH --}}

                        <div
                            class="rounded-3xl
                                   bg-white
                                   border border-slate-100
                                   px-5
                                   py-8
                                   flex
                                   items-center
                                   justify-center">


                            {{-- LOGO --}}
                            {{-- Ukuran dibuat sekitar setengah dari sebelumnya --}}

                            <img
                                src="{{ asset('images/logo.png') }}"
                                alt="Home Improvement"
                                class="w-52
                                       h-auto
                                       object-contain">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- LAYANAN --}}
    {{-- ========================================================= --}}

    <section
        id="layanan"
        class="bg-slate-50
               border-t border-slate-100">


        <div
            class="max-w-7xl
                   mx-auto
                   px-6 sm:px-8 lg:px-10
                   py-7 lg:py-8">


            {{-- JUDUL LAYANAN --}}

            <div class="mb-5">

                <h2
                    class="text-2xl
                           sm:text-3xl
                           font-bold
                           tracking-tight
                           text-slate-900">

                    Layanan yang Tersedia

                </h2>

            </div>



            {{-- DATA LAYANAN --}}

            @php

                $layanan = [

                    [
                        'nama' => 'Perawatan AC',
                        'deskripsi' => 'Cuci AC, pengisian freon, dan perbaikan kebocoran AC',
                        'icon' => 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83',
                    ],

                    [
                        'nama' => 'Kelistrikan',
                        'deskripsi' => 'Instalasi saklar dan penggantian kabel',
                        'icon' => 'M13 2L4.09 12.11a1 1 0 00.76 1.65h5.02L9 22l9-11h-6l1-9z',
                    ],

                    [
                        'nama' => 'Perbaikan Plumbing',
                        'deskripsi' => 'Penyedotan WC, perbaikan pipa tersumbat, dan penggantian kran bocor',
                        'icon' => 'M12 2c-3 4-6 7-6 11a6 6 0 0012 0c0-4-3-7-6-11z',
                    ],

                    [
                        'nama' => 'Perbaikan Bangunan',
                        'deskripsi' => 'Pemasangan keramik, perbaikan atap bocor, dan pengecatan dinding',
                        'icon' => 'M3 12l9-8 9 8M5 10v10h14V10',
                    ],

                    [
                        'nama' => 'Perbaikan Perabot Rumah',
                        'deskripsi' => 'Service kompor gas, mesin cuci, dan perbaikan kulkas',
                        'icon' => 'M4 4h16v16H4V4zM8 8h8v8H8V8z',
                    ],

                ];

            @endphp



            {{-- GRID LAYANAN --}}

            <div
                class="grid
                       sm:grid-cols-2
                       lg:grid-cols-3
                       gap-4">


                @foreach ($layanan as $item)


                    <div
                        class="group
                               bg-white
                               rounded-2xl
                               border border-slate-200
                               p-4
                               hover:border-sky-200
                               hover:shadow-lg
                               hover:shadow-slate-200/50
                               transition-all
                               duration-300">


                        {{-- ICON --}}

                        <div
                            class="w-10 h-10
                                   rounded-xl
                                   bg-sky-50
                                   flex
                                   items-center
                                   justify-center
                                   mb-3
                                   group-hover:bg-sky-500
                                   transition-colors">


                            <svg
                                width="20"
                                height="20"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="text-sky-600
                                       group-hover:text-white">


                                <path
                                    d="{{ $item['icon'] }}" />

                            </svg>

                        </div>



                        {{-- NAMA --}}

                        <h3
                            class="text-base
                                   font-bold
                                   text-slate-800">

                            {{ $item['nama'] }}

                        </h3>



                        {{-- DESKRIPSI --}}

                        <p
                            class="text-xs
                                   text-slate-500
                                   leading-relaxed
                                   mt-1">

                            {{ $item['deskripsi'] }}

                        </p>



                        {{-- PESAN --}}

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex
                                   items-center
                                   gap-1.5
                                   mt-3
                                   text-xs
                                   font-semibold
                                   text-sky-600
                                   hover:text-sky-700">

                            Pesan layanan

                        </a>

                    </div>


                @endforeach



                {{-- ================================================= --}}
                {{-- CARD MITRA TEKNISI --}}
                {{-- ================================================= --}}

                <div
                    class="group
                           rounded-2xl
                           bg-slate-900
                           p-4
                           text-white
                           hover:bg-slate-800
                           transition-all">


                    {{-- ICON --}}

                    <div
                        class="w-10 h-10
                               rounded-xl
                               bg-white/10
                               flex
                               items-center
                               justify-center
                               mb-3">


                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5 text-sky-400"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24">


                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2" />


                            <circle
                                cx="9"
                                cy="7"
                                r="4" />


                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M22 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />

                        </svg>

                    </div>



                    {{-- JUDUL --}}

                    <h3
                        class="text-base
                               font-bold">

                        Punya Keahlian?

                    </h3>



                    {{-- DESKRIPSI --}}

                    <p
                        class="text-xs
                               text-white/60
                               leading-relaxed
                               mt-1">

                        Bergabung sebagai mitra teknisi dan
                        dapatkan pelanggan melalui Home Improvement.

                    </p>



                    {{-- LINK --}}

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex
                               items-center
                               gap-2
                               mt-3
                               text-xs
                               font-semibold
                               text-sky-400">

                        Daftar sebagai teknisi

                    </a>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- CTA PENUTUP --}}
    {{-- ========================================================= --}}

    <section class="bg-white">


        <div
            class="max-w-7xl
                   mx-auto
                   px-6 sm:px-8 lg:px-10
                   py-7">


            <div
                class="relative
                       overflow-hidden
                       rounded-3xl
                       bg-gradient-to-r
                       from-slate-900
                       to-slate-800
                       px-7 py-7
                       sm:px-10
                       text-center">


                {{-- DEKORASI --}}

                <div
                    class="absolute
                           -top-20
                           -right-20
                           w-64 h-64
                           rounded-full
                           bg-sky-500/10">
                </div>


                <div
                    class="absolute
                           -bottom-24
                           -left-20
                           w-72 h-72
                           rounded-full
                           bg-blue-500/10">
                </div>



                <div class="relative">


                    <h2
                        class="text-2xl
                               sm:text-3xl
                               font-bold
                               text-white">

                        Siap memperbaiki rumah Anda?

                    </h2>



                    <p
                        class="mt-2
                               text-sm
                               text-white/60
                               max-w-lg
                               mx-auto">

                        Buat akun dan pesan layanan teknisi
                        sesuai kebutuhan rumah Anda.

                    </p>



                    <a
                        href="{{ route('register') }}"
                        class="inline-flex
                               items-center
                               justify-center
                               mt-4
                               px-6 py-2.5
                               rounded-xl
                               bg-sky-500
                               hover:bg-sky-400
                               text-white
                               text-sm
                               font-semibold
                               transition">

                        Daftar Sekarang

                    </a>

                </div>

            </div>

        </div>

    </section>


</body>

</html>