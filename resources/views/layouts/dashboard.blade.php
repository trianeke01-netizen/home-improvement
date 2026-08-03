<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Home Improvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Work Sans', sans-serif; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-800 p-6">

    <div class="w-full max-w-5xl bg-white rounded-2xl shadow-2xl overflow-hidden flex" style="min-height: 640px;">

        <!-- SIDEBAR -->
        <div class="w-64 border-r border-gray-200 flex flex-col p-6 shrink-0">

            <div class="flex flex-col items-start gap-3 mb-8">
                <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="8" r="4" fill="#7c3aed"/>
                        <path d="M4 20c0-3.3 3.6-6 8-6s8 2.7 8 6" fill="#7c3aed"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-sm text-gray-900">{{ auth()->user()->nama }}</div>
                    <div class="text-xs text-gray-500">Pelanggan</div>
                </div>
            </div>

            <nav class="flex flex-col gap-1 flex-1">
                <a href="{{ route('dashboard.pelanggan') }}"
                   class="px-4 py-2.5 rounded-lg text-sm font-semibold transition
                          {{ request()->routeIs('dashboard.pelanggan') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    Dashboard
                </a>
                <a href="{{ route('dashboard.pesan-layanan') }}"
                   class="px-4 py-2.5 rounded-lg text-sm font-semibold transition
                          {{ request()->routeIs('dashboard.pesan-layanan') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    Pesan Layanan
                </a>
                <a href="{{ route('dashboard.riwayat-order') }}"
                   class="px-4 py-2.5 rounded-lg text-sm font-semibold transition
                          {{ request()->routeIs('dashboard.riwayat-order') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    Riwayat Order
                </a>
                <a href="{{ route('dashboard.profil') }}"
                   class="px-4 py-2.5 rounded-lg text-sm font-semibold transition
                          {{ request()->routeIs('dashboard.profil') ? 'bg-gray-900 text-white' : 'text-gray-700 hover:bg-gray-50' }}">
                    Profil Saya
                </a>

                <div class="border-t border-gray-100 my-3"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 rounded-lg text-sm text-gray-400 hover:bg-gray-50 hover:text-gray-600 transition">
                        Keluar
                    </button>
                </form>
            </nav>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="flex-1 p-8 overflow-y-auto">
            @if (session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>

    </div>

</body>
</html>