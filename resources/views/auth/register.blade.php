<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Home Improvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        :root { --ink:#111827; --brick:#C1502E; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6" style="background:#1e293b;" x-data="{
    role: '{{ old('role_user', 'pelanggan') }}',
    showPass: false,
    showPass2: false,
    ktpName: '',
    portofolioName: ''
}">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 py-10">

        <h1 class="text-2xl font-bold text-center text-gray-900">Buat Akun Baru</h1>
        <p class="text-sm text-gray-500 text-center mt-1 mb-6">Daftar sebagai</p>

        <!-- TAB PELANGGAN / TEKNISI -->
        <div class="grid grid-cols-2 bg-gray-100 rounded-xl p-1 mb-6">
            <button type="button" @click="role = 'pelanggan'"
                    :class="role === 'pelanggan' ? 'bg-gray-900 text-white' : 'text-gray-500'"
                    class="py-2.5 rounded-lg text-sm font-medium transition">
                Pelanggan
            </button>
            <button type="button" @click="role = 'teknisi'"
                    :class="role === 'teknisi' ? 'bg-gray-900 text-white' : 'text-gray-500'"
                    class="py-2.5 rounded-lg text-sm font-medium transition">
                Teknisi
            </button>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="role_user" x-bind:value="role">

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">No. Telepon</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                           class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
                </div>
            </div>

            <!-- KHUSUS TEKNISI -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Keahlian / Kategori Layanan</label>
                <select name="id_kategori"
                        class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
                    <option value="">Pilih satu kategori keahlian</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Domisili</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat domisili"
                       class="w-full border border-gray-300 rounded-lg px-3.5 py-3 text-sm outline-none focus:border-gray-900 transition">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- PASSWORD dengan ikon mata -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Password</label>
                    <div class="relative">
                        <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Masukkan password"
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

                <!-- ULANGI PASSWORD dengan ikon mata -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Ulangi Password</label>
                    <div class="relative">
                        <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password"
                               class="w-full border border-gray-300 rounded-lg px-3.5 py-3 pr-11 text-sm outline-none focus:border-gray-900 transition">
                        <button type="button" @click="showPass2 = !showPass2"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700">
                            <svg x-show="!showPass2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="19" height="19">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5.25 12 5.25c4.477 0 8.268 2.693 9.542 6.75-1.274 4.057-5.065 6.75-9.542 6.75-4.477 0-8.268-2.693-9.542-6.75z"/>
                                <circle cx="12" cy="12" r="3" stroke-width="2"/>
                            </svg>
                            <svg x-show="showPass2" x-cloak xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="19" height="19">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.58 10.58a2 2 0 102.83 2.83"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.48 0 8.27 2.69 9.54 6.75a10.74 10.74 0 01-2.16 3.44M6.23 6.23A10.72 10.72 0 002.46 12c1.27 4.06 5.06 6.75 9.54 6.75a9.7 9.7 0 004.03-.86"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- UPLOAD KTP -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Upload Foto KTP (opsional)</label>
                <label class="flex flex-col items-center justify-center gap-1 border-2 border-dashed border-gray-300 rounded-xl py-6 cursor-pointer hover:border-gray-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22" class="text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0-12l-4 4m4-4l4 4M4 20h16"/>
                    </svg>
                    <span class="text-xs text-gray-600" x-text="ktpName || 'Klik untuk upload atau drag & drop'"></span>
                    <span class="text-[11px] text-gray-400">Format: JPG, PNG. Maks. 2MB</span>
                    <input type="file" name="ktp" class="hidden" accept="image/*" @change="ktpName = $event.target.files[0]?.name">
                </label>
            </div>

            <!-- UPLOAD PORTOFOLIO -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="block text-sm font-semibold text-gray-800 mb-2">Upload Portofolio (opsional)</label>
                <label class="flex flex-col items-center justify-center gap-1 border-2 border-dashed border-gray-300 rounded-xl py-6 cursor-pointer hover:border-gray-400 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" width="22" height="22" class="text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v12m0-12l-4 4m4-4l4 4M4 20h16"/>
                    </svg>
                    <span class="text-xs text-gray-600" x-text="portofolioName || 'Klik untuk upload atau drag & drop'"></span>
                    <span class="text-[11px] text-gray-400">Format: JPG, PNG, PDF. Maks. 5MB</span>
                    <input type="file" name="portofolio" class="hidden" accept="image/*,.pdf" @change="portofolioName = $event.target.files[0]?.name">
                </label>
            </div>
            <button type="submit" class="w-full bg-gray-900 text-white rounded-lg py-3.5 font-semibold hover:bg-gray-800 transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-gray-900 font-semibold underline">Masuk</a>
        </p>
    </div>

</body>
</html>