<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — Home Improvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#1e293b;" x-data="{ showPass: false }">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 py-10">

        <h1 class="text-2xl font-bold text-center text-gray-900">Masuk</h1>
        <p class="text-sm text-gray-500 text-center mt-1 mb-7">Selamat datang kembali</p>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                <div class="relative">
                    <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Masukkan password" required
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-3 pr-11 text-sm outline-none focus:border-gray-900 transition">
                    <button type="button" @click="showPass = !showPass"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                        <svg x-show="!showPass" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="19" height="19">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5.25 12 5.25c4.477 0 8.268 2.693 9.542 6.75-1.274 4.057-5.065 6.75-9.542 6.75-4.477 0-8.268-2.693-9.542-6.75z"/>
                            <circle cx="12" cy="12" r="3" stroke-width="2"/>
                        </svg>
                        <svg x-show="showPass" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="19" height="19">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.58 10.58a2 2 0 102.83 2.83"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.48 0 8.27 2.69 9.54 6.75a10.74 10.74 0 01-2.16 3.44M6.23 6.23A10.72 10.72 0 002.46 12c1.27 4.06 5.06 6.75 9.54 6.75a9.7 9.7 0 004.03-.86"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="text-right">
                <a href="#" class="text-sm font-semibold text-gray-800 underline">Lupa password?</a>
            </div>

            <button type="submit" class="w-full bg-gray-900 text-white rounded-lg py-3.5 font-semibold hover:bg-gray-800 transition">
                Masuk
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Belum punya akun? <a href="{{ route('register') }}" class="text-gray-900 font-semibold underline">Daftar sekarang</a>
        </p>
    </div>

</body>
</html>