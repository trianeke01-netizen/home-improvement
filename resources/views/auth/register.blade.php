<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Home Improvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700;900&family=Work+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#1E2A22; --paper:#FFFFFF; --brick:#C1502E; --mustard:#E8A33D; --sage:#7C8A72; }
        body { font-family:'Work Sans',sans-serif; color:var(--ink); }
        .font-display{font-family:'Fraunces',serif;}
        .font-mono{font-family:'JetBrains Mono',monospace;}
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

        <h1 class="font-display font-bold text-2xl mb-1 text-center">Buat Akun Baru</h1>
        <p class="text-sm text-[var(--ink)]/55 mb-5 text-center">Daftar sebagai</p>

        <!-- TAB PELANGGAN / TEKNISI -->
        <div class="grid grid-cols-2 bg-[var(--ink)]/5 rounded-xl p-1 mb-6">
            <button type="button" @click="role = 'pelanggan'"
                    :class="role === 'pelanggan' ? 'bg-[var(--ink)] text-white' : 'text-[var(--ink)]/60'"
                    class="py-2.5 rounded-lg text-sm font-medium transition">
                Pelanggan
            </button>
            <button type="button" @click="role = 'teknisi'"
                    :class="role === 'teknisi' ? 'bg-[var(--ink)] text-white' : 'text-[var(--ink)]/60'"
                    class="py-2.5 rounded-lg text-sm font-medium transition">
                Teknisi
            </button>
        </div>

        @if ($errors->any())
            <div class="bg-[var(--brick)]/10 border border-[var(--brick)]/30 text-[var(--brick)] text-sm rounded-xl px-4 py-3 mb-5">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="role_user" x-bind:value="role">

            <div>
                <label class="text-xs font-medium text-[var(--ink)]/70">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama lengkap"
                       class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="text-xs font-medium text-[var(--ink)]/70">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                           class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
                </div>
                <div>
                    <label class="text-xs font-medium text-[var(--ink)]/70">No. Telepon / WhatsApp</label>
                    <input type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx"
                           class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
                </div>
            </div>

            <!-- KHUSUS TEKNISI: Kategori Keahlian -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="text-xs font-medium text-[var(--ink)]/70">Keahlian / Kategori Layanan</label>
                <select name="id_kategori"
                        class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
                    <option value="">Pilih satu kategori keahlian</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" {{ old('id_kategori') == $k->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-[var(--ink)]/45 mt-1"></p>
            </div>

            <div>
                <label class="text-xs font-medium text-[var(--ink)]/70">Alamat Domisili</label>
                <input type="text" name="alamat" value="{{ old('alamat') }}" placeholder="Masukkan alamat domisili"
                       class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="relative">
                    <label class="text-xs font-medium text-[var(--ink)]/70">Password</label>
                    <input :type="showPass ? 'text' : 'password'" name="password" placeholder="Masukkan password"
                           class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 pr-14 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
                    <button type="button" @click="showPass = !showPass"
                            class="absolute right-3 top-[34px] text-xs font-medium text-[var(--ink)]/50">
                        <span x-text="showPass ? 'Sembunyikan' : 'Lihat'"></span>
                    </button>
                </div>
                <div class="relative">
                    <label class="text-xs font-medium text-[var(--ink)]/70">Ulangi Password</label>
                    <input :type="showPass2 ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password"
                           class="mt-1.5 w-full border border-[var(--ink)]/15 rounded-xl px-4 py-2.5 pr-14 text-sm focus:outline-none focus:ring-2 focus:ring-[var(--brick)] focus:border-transparent">
                    <button type="button" @click="showPass2 = !showPass2"
                            class="absolute right-3 top-[34px] text-xs font-medium text-[var(--ink)]/50">
                        <span x-text="showPass2 ? 'Sembunyikan' : 'Lihat'"></span>
                    </button>
                </div>
            </div>

            <!-- KHUSUS TEKNISI: Upload KTP -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="text-xs font-medium text-[var(--ink)]/70">Upload Foto KTP (opsional)</label>
                <label class="mt-1.5 flex flex-col items-center justify-center gap-1 border-2 border-dashed border-[var(--ink)]/15 rounded-xl py-6 cursor-pointer hover:border-[var(--brick)]/40 transition">
                    <span class="text-lg">↑</span>
                    <span class="text-xs text-[var(--ink)]/60" x-text="ktpName || 'Klik untuk upload atau drag & drop'"></span>
                    <span class="text-[10px] text-[var(--ink)]/40">Format: JPG, PNG. Maks. 2MB</span>
                    <input type="file" name="ktp" class="hidden" accept="image/*"
                           @change="ktpName = $event.target.files[0]?.name">
                </label>
            </div>

            <!-- KHUSUS TEKNISI: Upload Portofolio -->
            <div x-show="role === 'teknisi'" x-cloak>
                <label class="text-xs font-medium text-[var(--ink)]/70">Upload Portofolio (opsional)</label>
                <label class="mt-1.5 flex flex-col items-center justify-center gap-1 border-2 border-dashed border-[var(--ink)]/15 rounded-xl py-6 cursor-pointer hover:border-[var(--brick)]/40 transition">
                    <span class="text-lg">↑</span>
                    <span class="text-xs text-[var(--ink)]/60" x-text="portofolioName || 'Klik untuk upload atau drag & drop'"></span>
                    <span class="text-[10px] text-[var(--ink)]/40">Format: JPG, PNG, PDF. Maks. 5MB</span>
                    <input type="file" name="portofolio" class="hidden" accept="image/*,.pdf"
                           @change="portofolioName = $event.target.files[0]?.name">
                </label>
            </div>
            <button type="submit"
                    class="w-full bg-[var(--ink)] text-white rounded-xl py-3 font-medium hover:bg-[var(--brick)] transition">
                Daftar
            </button>
        </form>

        <p class="text-center text-sm text-[var(--ink)]/60 mt-6">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[var(--brick)] font-medium hover:underline">Masuk</a>
        </p>
    </div>

</body>
</html>