<!DOCTYPE html>
<html lang="id" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Improvement</title>

    <!-- Preload Latar Belakang Gambar untuk Render Instan -->
    <link rel="preload" as="image" href="{{ asset('images/hero-bg.jpg') }}" fetchpriority="high">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-900 text-slate-800 relative bg-cover bg-center bg-fixed bg-no-repeat antialiased selection:bg-sky-500 selection:text-white" style="background-image: url('{{ asset('images/hero-bg.jpg') }}');">

    {{-- OVERLAY CERAH SUPAYA GAMBAR TETAP INDAH & TERANG TAPI TEKS JELAS DIBACA --}}
    <div class="fixed inset-0 bg-slate-950/35 backdrop-brightness-95 pointer-events-none z-0"></div>

    <div class="relative z-10">

        {{-- ========================================================= --}}
        {{-- GLASSMORPHISM NAVBAR --}}
        {{-- ========================================================= --}}

        <nav class="bg-slate-950/70 backdrop-blur-xl border-b border-white/10 sticky top-0 z-50 transition-all duration-300 shadow-xl">

            <div
                class="max-w-7xl mx-auto
                       px-6 sm:px-8 lg:px-10
                       h-20
                       flex items-center justify-between">

                {{-- LOGO BRAND & ICON BADGE --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-sky-500 to-blue-600 p-0.5 shadow-lg shadow-sky-500/25 group-hover:scale-105 transition duration-300">
                        <div class="w-full h-full bg-slate-900/80 rounded-[14px] flex items-center justify-center text-white border border-white/20">
                            <svg class="w-5 h-5 text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                        </div>
                    </div>
                    <span class="text-xl font-extrabold tracking-tight text-white">
                        Home<span class="text-sky-400"> Improvement</span>
                    </span>
                </a>

                {{-- AUTH BUTTONS --}}
                <div class="flex items-center gap-4">

                    {{-- LOGIN --}}
                    <a
                        href="{{ route('login') }}"
                        class="text-sm
                               font-semibold
                               text-slate-200
                               hover:text-white
                               px-3 py-2
                               rounded-xl
                               transition">

                        Login

                    </a>


                    {{-- REGISTRASI --}}
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex
                               items-center
                               justify-center
                               px-6 py-2.5
                               rounded-xl
                               bg-gradient-to-r
                               from-sky-500
                               to-blue-600
                               hover:from-sky-400
                               hover:to-blue-500
                               text-white
                               text-sm
                               font-bold
                               shadow-lg
                               shadow-sky-500/25
                               border border-sky-400/30
                               transition transform hover:scale-[1.02]">

                        Registrasi

                    </a>

                </div>

            </div>

        </nav>



        {{-- ========================================================= --}}
        {{-- HERO (CENTERED - TULISAN DI TENGAH) --}}
        {{-- ========================================================= --}}

        <section
            class="relative
                   overflow-hidden
                   pt-10 pb-4 lg:pt-14 lg:pb-6">

            <div
                class="relative
                       max-w-3xl
                       mx-auto
                       px-6 sm:px-8
                       text-center
                       flex
                       flex-col
                       items-center
                       justify-center">


                {{-- JUDUL CENTERED --}}

                <h1
                    class="text-4xl
                           sm:text-5xl
                           lg:text-6xl
                           font-extrabold
                           tracking-tight
                           leading-[1.12]
                           text-white
                           drop-shadow-lg">

                    Rumah bermasalah?

                    <span class="block text-sky-400 drop-shadow-md">

                        Pesan teknisi tepercaya.

                    </span>

                </h1>



                {{-- DESKRIPSI CENTERED --}}

                <p
                    class="mt-5
                           text-base
                           sm:text-lg
                           lg:text-xl
                           leading-relaxed
                           text-slate-100
                           max-w-2xl
                           font-medium
                           drop-shadow">

                    Temukan teknisi sesuai kebutuhan perbaikan rumah
                    Anda dengan proses pemesanan yang mudah,
                    praktis, dan terpercaya.

                </p>



                {{-- BUTTON PESAN CENTERED --}}

                <div
                    class="flex
                           flex-col
                           sm:flex-row
                           items-center
                           justify-center
                           gap-3
                           mt-8">

                    <a
                        href="{{ route('register') }}"
                        class="inline-flex
                               items-center
                               justify-center
                               gap-2.5
                               px-8 py-3.5
                               rounded-xl
                               bg-gradient-to-r
                               from-sky-500
                               to-blue-600
                               hover:from-sky-600
                               hover:to-blue-700
                               text-white
                               font-bold
                               text-base
                               shadow-xl
                               shadow-sky-500/30
                               border border-sky-400/30
                               transition transform hover:-translate-y-0.5">

                        <span>Pesan Layanan</span>


                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2.5"
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



                {{-- TRUST POINT CENTERED --}}

                <div
                    class="flex
                           flex-wrap
                           items-center
                           justify-center
                           gap-x-6
                           gap-y-3
                           mt-5
                           text-sm
                           font-semibold
                           text-white
                           drop-shadow">


                    {{-- TEKNISI TERPERCAYA --}}

                    <div class="flex items-center gap-2 bg-slate-900/40 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 shadow-md">

                        <div
                            class="w-5 h-5
                                   rounded-full
                                   bg-emerald-500
                                   text-white
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-bold
                                   shadow">

                            ✓

                        </div>

                        Teknisi terpercaya

                    </div>



                    {{-- PEMESANAN MUDAH --}}

                    <div class="flex items-center gap-2 bg-slate-900/40 backdrop-blur-md px-4 py-2 rounded-full border border-white/20 shadow-md">

                        <div
                            class="w-5 h-5
                                   rounded-full
                                   bg-sky-500
                                   text-white
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-bold
                                   shadow">

                            ✓

                        </div>

                        Pemesanan mudah

                    </div>

                </div>

            </div>

        </section>



        {{-- ========================================================= --}}
        {{-- LAYANAN --}}
        {{-- ========================================================= --}}

        <section
            id="layanan"
            class="pt-2 pb-16 lg:pt-4 lg:pb-20">


            <div
                class="max-w-7xl
                       mx-auto
                       px-6 sm:px-8 lg:px-10">


                {{-- JUDUL LAYANAN --}}

                <div class="mb-8 text-center sm:text-left">

                    <h2
                        class="text-2xl
                               sm:text-3xl
                               font-bold
                               tracking-tight
                               text-white
                               drop-shadow">

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
                           gap-6">


                    @foreach ($layanan as $item)


                        <div
                            class="group
                                   rounded-2xl
                                   bg-slate-900/90
                                   backdrop-blur-md
                                   border border-white/20
                                   p-6
                                   text-white
                                   shadow-xl
                                   hover:bg-slate-900
                                   transition-all
                                   duration-300">


                            {{-- ICON --}}

                            <div
                                class="w-12 h-12
                                       rounded-xl
                                       bg-sky-500/20
                                       border border-sky-400/30
                                       flex
                                       items-center
                                       justify-center
                                       mb-4
                                       group-hover:bg-sky-500
                                       transition-colors">


                                <svg
                                    width="22"
                                    height="22"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    class="text-sky-400
                                           group-hover:text-white">


                                    <path
                                        d="{{ $item['icon'] }}" />

                                </svg>

                            </div>



                            {{-- NAMA --}}

                            <h3
                                class="text-lg
                                       font-bold
                                       text-white">

                                {{ $item['nama'] }}

                            </h3>



                            {{-- DESKRIPSI --}}

                            <p
                                class="text-sm
                                       text-slate-300
                                       leading-relaxed
                                       mt-2">

                                {{ $item['deskripsi'] }}

                            </p>



                            {{-- PESAN --}}

                            <a
                                href="{{ route('register') }}"
                                class="inline-flex
                                       items-center
                                       gap-1.5
                                       mt-4
                                       text-sm
                                       font-semibold
                                       text-sky-400
                                       hover:text-sky-300">

                                Pesan layanan &rarr;

                            </a>

                        </div>


                    @endforeach



                    {{-- ================================================= --}}
                    {{-- CARD MITRA TEKNISI --}}
                    {{-- ================================================= --}}

                    <div
                        class="group
                               rounded-2xl
                               bg-slate-900/90
                               backdrop-blur-md
                               border border-white/20
                               p-6
                               text-white
                               shadow-xl
                               hover:bg-slate-900
                               transition-all">


                        {{-- ICON --}}

                        <div
                            class="w-12 h-12
                                   rounded-xl
                                   bg-sky-500
                                   flex
                                   items-center
                                   justify-center
                                   mb-4 shadow-lg shadow-sky-500/30">


                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-white"
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
                            class="text-lg
                                   font-bold">

                            Punya Keahlian?

                        </h3>



                        {{-- DESKRIPSI --}}

                        <p
                            class="text-sm
                                   text-slate-300
                                   leading-relaxed
                                   mt-2">

                            Bergabung sebagai mitra teknisi dan
                            dapatkan pelanggan melalui Home Improvement.

                        </p>



                        {{-- LINK --}}

                        <a
                            href="{{ route('register') }}"
                            class="inline-flex
                                   items-center
                                   gap-2
                                   mt-4
                                   text-sm
                                   font-semibold
                                   text-sky-400 hover:text-sky-300">

                            Registrasi sebagai teknisi &rarr;

                        </a>

                    </div>

                </div>

            </div>

        </section>



        {{-- ========================================================= --}}
        {{-- CTA PENUTUP --}}
        {{-- ========================================================= --}}

        <section class="py-12 pb-20">


            <div
                class="max-w-7xl
                       mx-auto
                       px-6 sm:px-8 lg:px-10">


                <div
                    class="relative
                           overflow-hidden
                           rounded-3xl
                           bg-slate-900/90
                           backdrop-blur-md
                           border border-white/20
                           px-8 py-10
                           sm:px-12
                           text-center
                           shadow-2xl">


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
                                   text-base
                                   text-slate-300
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
                                   mt-6
                                   px-8 py-3
                                   rounded-xl
                                   bg-sky-500
                                   hover:bg-sky-400
                                   text-white
                                   text-sm
                                   font-semibold
                                   shadow-lg
                                   shadow-sky-500/30
                                   transition">

                            Registrasi Sekarang

                        </a>

                    </div>

                </div>

            </div>

        </section>

    </div>

</body>

</html>