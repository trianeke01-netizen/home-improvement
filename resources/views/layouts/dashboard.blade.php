<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Dashboard')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        * {
            font-family: 'Inter', sans-serif;
        }

        html,
        body {
            margin: 0;
            padding: 0;
        }

        body {
            background: #f8fafc;
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
        }

        @media (max-width: 1023px) {

            .sidebar-mobile {
                transform: translateX(-100%);
                transition: transform .25s ease;
            }

            .sidebar-mobile.open {
                transform: translateX(0);
            }

            .sidebar-overlay {
                opacity: 0;
                pointer-events: none;
                transition: opacity .25s ease;
            }

            .sidebar-overlay.open {
                opacity: 1;
                pointer-events: auto;
            }

        }

    </style>

    @stack('styles')

</head>


<body class="min-h-screen bg-slate-50">


@php

    $user = auth()->user();

    $role = $user?->role_user ?? null;

@endphp



{{-- ================================================================ --}}
{{-- MOBILE OVERLAY --}}
{{-- ================================================================ --}}

<div
    id="sidebarOverlay"
    class="
        sidebar-overlay
        fixed
        inset-0
        z-40
        bg-slate-900/50
        lg:hidden
    "
    onclick="closeSidebar()"
></div>



{{-- ================================================================ --}}
{{-- SIDEBAR --}}
{{-- ================================================================ --}}

<aside
    id="sidebar"
    class="
        sidebar-mobile
        fixed
        inset-y-0
        left-0
        z-50
        flex
        w-[334px]
        flex-col
        border-r
        border-slate-200
        bg-white
        lg:translate-x-0
    "
>


    {{-- ============================================================ --}}
    {{-- USER PROFILE --}}
    {{-- ============================================================ --}}

    <div class="px-7 pt-7">

        <div class="flex items-center gap-4">


            {{-- AVATAR --}}

            <div
                class="
                    flex
                    h-14
                    w-14
                    shrink-0
                    items-center
                    justify-center
                    rounded-full
                    bg-violet-100
                    text-violet-600
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-7 w-7"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"
                    />

                </svg>

            </div>


            {{-- USER NAME --}}

            <div class="min-w-0">

                <p
                    class="
                        truncate
                        text-base
                        font-bold
                        text-slate-900
                    "
                >
                    {{ $user?->nama ?? 'User' }}
                </p>

                <p
                    class="
                        mt-1
                        text-sm
                        font-medium
                        capitalize
                        text-slate-400
                    "
                >
                    {{ $role ?? 'Pengguna' }}
                </p>

            </div>

        </div>


        {{-- GARIS PEMISAH --}}

        <div class="mt-7 border-b border-slate-100"></div>

    </div>



    {{-- ============================================================ --}}
    {{-- MENU --}}
    {{-- ============================================================ --}}

    <div
        class="
            sidebar-scroll
            flex-1
            overflow-y-auto
            px-6
            py-7
        "
    >


        {{-- ======================================================== --}}
        {{-- PELANGGAN --}}
        {{-- ======================================================== --}}

        @if($role === 'pelanggan')


            {{-- DASHBOARD --}}

            <a
                href="{{ route('dashboard.pelanggan') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('dashboard.pelanggan')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect x="4" y="4" width="6" height="6" rx="1"/>
                    <rect x="14" y="4" width="6" height="6" rx="1"/>
                    <rect x="4" y="14" width="6" height="6" rx="1"/>
                    <rect x="14" y="14" width="6" height="6" rx="1"/>

                </svg>

                <span>Dashboard</span>

            </a>



            {{-- PESAN LAYANAN --}}

            <a
                href="{{ route('dashboard.pesan-layanan') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('dashboard.pesan-layanan')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        d="M12 5v14"
                    />

                    <path
                        stroke-linecap="round"
                        d="M5 12h14"
                    />

                </svg>

                <span>Pesan Layanan</span>

            </a>



            {{-- RIWAYAT ORDER --}}

            <a
                href="{{ route('dashboard.riwayat-order') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs(
                            'dashboard.riwayat-order',
                            'dashboard.detail-order',
                            'dashboard.pembayaran-qris'
                        )
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 12a9 9 0 1 0 3-6.7"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 4v5h5"
                    />

                </svg>

                <span>Riwayat Order</span>

            </a>



            {{-- PROFIL --}}

            <a
                href="{{ route('dashboard.profil') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('dashboard.profil')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
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

                <span>Profil Saya</span>

            </a>

        @endif



        {{-- ======================================================== --}}
        {{-- TEKNISI --}}
        {{-- ======================================================== --}}

        @if($role === 'teknisi')


            {{-- DASHBOARD --}}

            <a
                href="{{ route('dashboard.teknisi') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('dashboard.teknisi')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect x="4" y="4" width="6" height="6" rx="1"/>
                    <rect x="14" y="4" width="6" height="6" rx="1"/>
                    <rect x="4" y="14" width="6" height="6" rx="1"/>
                    <rect x="14" y="14" width="6" height="6" rx="1"/>

                </svg>

                <span>Dashboard</span>

            </a>



            {{-- RIWAYAT ORDER --}}

            <a
                href="{{ route('dashboard.teknisi.riwayat-order') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs(
                            'dashboard.teknisi.riwayat-order'
                        )
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 12a9 9 0 1 0 3-6.7"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 4v5h5"
                    />

                </svg>

                <span>Riwayat Order</span>

            </a>



            {{-- PROFIL TEKNISI --}}

            <a
                href="{{ route('dashboard.teknisi.profil') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs(
                            'dashboard.teknisi.profil'
                        )
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
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

                <span>Profil Saya</span>

            </a>

        @endif



        {{-- ======================================================== --}}
        {{-- ADMIN --}}
        {{-- ======================================================== --}}

        @if($role === 'admin')


            {{-- ==================================================== --}}
            {{-- DASHBOARD ADMIN --}}
            {{-- ==================================================== --}}

            <a
                href="{{ route('admin.dashboard') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('admin.dashboard')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect x="4" y="4" width="6" height="6" rx="1"/>
                    <rect x="14" y="4" width="6" height="6" rx="1"/>
                    <rect x="4" y="14" width="6" height="6" rx="1"/>
                    <rect x="14" y="14" width="6" height="6" rx="1"/>

                </svg>

                <span>Dashboard</span>

            </a>



            {{-- ==================================================== --}}
            {{-- VERIFIKASI TEKNISI --}}
            {{-- ==================================================== --}}

            @if(\Illuminate\Support\Facades\Route::has('admin.teknisi.verifikasi'))

                <a
                    href="{{ route('admin.teknisi.verifikasi') }}"
                    onclick="closeSidebar()"
                    class="
                        mb-2
                        flex
                        items-center
                        gap-5
                        rounded-2xl
                        px-5
                        py-4
                        text-base
                        font-semibold
                        transition
                        cursor-pointer

                        {{
                            request()->routeIs('admin.teknisi.verifikasi')
                                ? 'bg-slate-900 text-white shadow-sm'
                                : 'text-slate-600 hover:bg-slate-50'
                        }}
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 shrink-0"
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

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4Z"
                        />

                    </svg>

                    <span>Verifikasi Teknisi</span>

                </a>

            @elseif(\Illuminate\Support\Facades\Route::has('admin.verifikasi'))

                {{-- FALLBACK JIKA NAMA ROUTE MASIH admin.verifikasi --}}

                <a
                    href="{{ route('admin.verifikasi') }}"
                    onclick="closeSidebar()"
                    class="
                        mb-2
                        flex
                        items-center
                        gap-5
                        rounded-2xl
                        px-5
                        py-4
                        text-base
                        font-semibold
                        transition
                        cursor-pointer

                        {{
                            request()->routeIs('admin.verifikasi')
                                ? 'bg-slate-900 text-white shadow-sm'
                                : 'text-slate-600 hover:bg-slate-50'
                        }}
                    "
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6 shrink-0"
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

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 3l7 4v5c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V7l7-4Z"
                        />

                    </svg>

                    <span>Verifikasi Teknisi</span>

                </a>

            @endif



            {{-- ==================================================== --}}
            {{-- KELOLA LAYANAN --}}
            {{-- ==================================================== --}}

            <a
                href="{{ route('admin.kategori') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('admin.kategori')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        d="M4 6h16"
                    />

                    <path
                        stroke-linecap="round"
                        d="M4 12h16"
                    />

                    <path
                        stroke-linecap="round"
                        d="M4 18h16"
                    />

                    <circle
                        cx="8"
                        cy="6"
                        r="1.5"
                        fill="currentColor"
                        stroke="none"
                    />

                    <circle
                        cx="15"
                        cy="12"
                        r="1.5"
                        fill="currentColor"
                        stroke="none"
                    />

                    <circle
                        cx="10"
                        cy="18"
                        r="1.5"
                        fill="currentColor"
                        stroke="none"
                    />

                </svg>

                <span>Kelola Layanan</span>

            </a>



            {{-- ==================================================== --}}
            {{-- TRANSAKSI --}}
            {{-- ==================================================== --}}

            <a
                href="{{ route('admin.orders') }}"
                onclick="closeSidebar()"
                class="
                    mb-2
                    flex
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    transition
                    cursor-pointer

                    {{
                        request()->routeIs('admin.orders')
                            ? 'bg-slate-900 text-white shadow-sm'
                            : 'text-slate-600 hover:bg-slate-50'
                    }}
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <rect
                        x="3"
                        y="5"
                        width="18"
                        height="14"
                        rx="2"
                    />

                    <path
                        stroke-linecap="round"
                        d="M3 10h18"
                    />

                    <path
                        stroke-linecap="round"
                        d="M7 15h4"
                    />

                </svg>

                <span>Transaksi</span>

            </a>



           {{-- ==================================================== --}}
{{-- STATISTIK --}}
{{-- ==================================================== --}}

<a
    href="{{ route('admin.statistik') }}"
    onclick="closeSidebar()"
    class="
        mb-2
        flex
        items-center
        gap-5
        rounded-2xl
        px-5
        py-4
        text-base
        font-semibold
        transition
        cursor-pointer

        {{
            request()->routeIs('admin.statistik')
                ? 'bg-slate-900 text-white shadow-sm'
                : 'text-slate-600 hover:bg-slate-50'
        }}
    "
>

    <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 shrink-0"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.8"
    >

        {{-- Icon Grafik --}}

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 19V5"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M4 19h16"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8 16v-4"
        />

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 16V8"
        />

        {{-- STATISTIK --}}

        <a
            href="{{ route('admin.statistik') }}"
            onclick="closeSidebar()"
            class="
                mb-2
                flex
                items-center
                gap-5
                rounded-2xl
                px-5
                py-4
                text-base
                font-semibold
                transition
                cursor-pointer

                {{
                    request()->routeIs('admin.statistik')
                        ? 'bg-slate-900 text-white shadow-sm'
                        : 'text-slate-600 hover:bg-slate-50'
                }}
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 19V5"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 19h16"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M8 16v-4"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M12 16V8"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M16 16v-7"
                />

            </svg>

            <span>Statistik</span>

        </a>


        {{-- PROFIL ADMIN --}}

        <a
            href="{{ route('admin.profil') }}"
            onclick="closeSidebar()"
            class="
                mb-2
                flex
                items-center
                gap-5
                rounded-2xl
                px-5
                py-4
                text-base
                font-semibold
                transition
                cursor-pointer

                {{
                    request()->routeIs('admin.profil')
                        ? 'bg-slate-900 text-white shadow-sm'
                        : 'text-slate-600 hover:bg-slate-50'
                }}
            "
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0"
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

            <span>Profil Saya</span>

        </a>

        @endif

    </div>



    {{-- ============================================================ --}}
    {{-- LOGOUT --}}
    {{-- ============================================================ --}}

    <div
        class="
            shrink-0
            border-t
            border-slate-100
            px-6
            py-5
        "
    >

        <form
            action="{{ route('logout') }}"
            method="POST"
        >

            @csrf

            <button
                type="submit"
                class="
                    flex
                    w-full
                    cursor-pointer
                    items-center
                    gap-5
                    rounded-2xl
                    px-5
                    py-4
                    text-base
                    font-semibold
                    text-slate-500
                    transition
                    hover:bg-slate-50
                    hover:text-slate-700
                "
            >

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 shrink-0"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M10 17l5-5-5-5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15 12H3"
                    />

                </svg>

                <span>Keluar</span>

            </button>

        </form>

    </div>

</aside>



{{-- ================================================================ --}}
{{-- MAIN CONTENT --}}
{{-- ================================================================ --}}

<div class="min-h-screen lg:pl-[334px]">

    @php
        $unreadNotifs = $user?->unreadNotifications ?? collect();
        $allNotifs = $user?->notifications()->take(10)->get() ?? collect();
    @endphp

    {{-- ============================================================ --}}
    {{-- TOPBAR (DESKTOP & MOBILE) --}}
    {{-- ============================================================ --}}

    <header
        class="
            sticky
            top-0
            z-30
            flex
            h-[70px]
            items-center
            justify-between
            border-b
            border-slate-200
            bg-white/95
            px-5
            sm:px-7
            lg:px-9
            backdrop-blur
        "
    >

        <div class="flex items-center">

            <button
                type="button"
                onclick="openSidebar()"
                class="
                    flex
                    h-10
                    w-10
                    cursor-pointer
                    items-center
                    justify-center
                    rounded-xl
                    bg-slate-100
                    text-slate-600
                    lg:hidden
                    mr-3
                "
            >

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
                        d="M4 7h16"
                    />

                    <path
                        stroke-linecap="round"
                        d="M4 12h16"
                    />

                    <path
                        stroke-linecap="round"
                        d="M4 17h16"
                    />

                </svg>

            </button>

            <p class="text-lg font-extrabold text-slate-900">

                @yield('title', 'Dashboard')

            </p>

        </div>


        {{-- NOTIFIKASI BELL DROPDOWN --}}
        <div class="relative" id="notifDropdownWrapper">

            <button
                type="button"
                onclick="toggleNotifDropdown()"
                class="
                    relative
                    flex
                    h-10
                    w-10
                    items-center
                    justify-center
                    rounded-xl
                    border
                    border-slate-200
                    bg-white
                    text-slate-600
                    hover:bg-slate-50
                    transition
                "
            >

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>

                @if($unreadNotifs->count() > 0)
                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-extrabold text-white shadow">
                        {{ $unreadNotifs->count() > 9 ? '9+' : $unreadNotifs->count() }}
                    </span>
                @endif

            </button>


            {{-- DROPDOWN CONTAINER --}}

            <div
                id="notifDropdown"
                class="
                    hidden
                    absolute
                    right-0
                    mt-2
                    w-80
                    sm:w-96
                    rounded-2xl
                    border
                    border-slate-200
                    bg-white
                    shadow-xl
                    z-50
                    overflow-hidden
                "
            >

                <div class="flex items-center justify-between border-b border-slate-100 px-4 py-3 bg-slate-50">

                    <span class="text-xs font-bold text-slate-800 uppercase tracking-wider">
                        Notifikasi
                        @if($unreadNotifs->count() > 0)
                            <span class="ml-1 rounded-full bg-slate-900 text-white px-2 py-0.5 text-[10px]">
                                {{ $unreadNotifs->count() }} Baru
                            </span>
                        @endif
                    </span>

                    @if($unreadNotifs->count() > 0)
                        <form action="{{ route('notifikasi.baca-semua') }}" method="POST">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                                Tandai Semua Dibaca
                            </button>
                        </form>
                    @endif

                </div>


                <div class="max-h-80 overflow-y-auto divide-y divide-slate-100">

                    @forelse($allNotifs as $notif)

                        <div class="p-3.5 transition hover:bg-slate-50 {{ !$notif->is_read ? 'bg-indigo-50/40' : '' }}">

                            <div class="flex items-start justify-between gap-2">

                                <div class="flex-1">

                                    <p class="text-xs font-bold text-slate-900 flex items-center gap-1.5">
                                        @if(!$notif->is_read)
                                            <span class="inline-block w-2 h-2 rounded-full bg-indigo-600 shrink-0"></span>
                                        @endif
                                        {{ $notif->judul }}
                                    </p>

                                    <p class="mt-1 text-xs text-slate-600 leading-relaxed">
                                        {{ $notif->pesan }}
                                    </p>

                                    <span class="mt-1.5 block text-[10px] text-slate-400">
                                        {{ $notif->created_at->diffForHumans() }}
                                    </span>

                                </div>


                                @if(!$notif->is_read)
                                    <form action="{{ route('notifikasi.baca', $notif->id_notification) }}" method="POST">
                                        @csrf
                                        <button type="submit" title="Tandai dibaca" class="p-1 rounded text-slate-400 hover:text-slate-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif

                            </div>

                            @if($notif->url)
                                <a href="{{ $notif->url }}" class="mt-2 inline-block text-[11px] font-semibold text-indigo-600 hover:underline">
                                    Lihat Detail &rarr;
                                </a>
                            @endif

                        </div>

                    @empty

                        <div class="p-6 text-center text-xs text-slate-400">
                            Belum ada notifikasi.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </header>



    {{-- ============================================================ --}}
    {{-- CONTENT --}}
    {{-- ============================================================ --}}

    <main
        class="
            min-h-screen
            bg-slate-50
            px-5
            py-7
            sm:px-7
            lg:px-9
            lg:py-8
        "
    >

        @yield('content')

    </main>

</div>



{{-- ================================================================ --}}
{{-- JAVASCRIPT --}}
{{-- ================================================================ --}}

<script>

    function toggleNotifDropdown()
    {
        const dropdown = document.getElementById('notifDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    document.addEventListener('click', function(event) {
        const wrapper = document.getElementById('notifDropdownWrapper');
        const dropdown = document.getElementById('notifDropdown');
        if (wrapper && dropdown && !wrapper.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });

    function openSidebar()
    {
        const sidebar =
            document.getElementById('sidebar');

        const overlay =
            document.getElementById('sidebarOverlay');

        if (sidebar) {

            sidebar.classList.add('open');

        }

        if (overlay) {

            overlay.classList.add('open');

        }

        document.body.classList.add('overflow-hidden');
    }


    function closeSidebar()
    {
        const sidebar =
            document.getElementById('sidebar');

        const overlay =
            document.getElementById('sidebarOverlay');

        if (sidebar) {

            sidebar.classList.remove('open');

        }

        if (overlay) {

            overlay.classList.remove('open');

        }

        document.body.classList.remove('overflow-hidden');
    }


    document.addEventListener(
        'keydown',
        function(event)
        {

            if (event.key === 'Escape') {

                closeSidebar();

            }

        }
    );


    window.addEventListener(
        'resize',
        function()
        {

            if (window.innerWidth >= 1024) {

                closeSidebar();

            }

        }
    );

</script>


@stack('scripts')

</body>

</html>