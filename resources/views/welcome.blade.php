<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Improvement</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@500;600;700;900&family=Work+Sans:wght@400;500;600&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        :root { --ink:#1E2A22; --paper:#FFFFFF; --brick:#C1502E; --mustard:#E8A33D; --sage:#7C8A72; }
        body { font-family:'Work Sans',sans-serif; color:var(--ink); background:var(--paper); }
        .font-display{font-family:'Fraunces',serif;}
        .font-mono{font-family:'JetBrains Mono',monospace;}
    </style>
</head>
<body class="antialiased">

    <!-- HERO -->
    <section class="relative w-full overflow-hidden bg-white">

        <!-- NAV -->
        <nav class="relative z-10 max-w-6xl mx-auto flex items-center justify-between px-6 py-5">
            <span class="font-display font-bold text-[var(--ink)] text-sm tracking-widest uppercase">Home Improvement</span>
            <div class="flex items-center gap-5">
                <a href="{{ route('login') }}" class="text-[var(--ink)]/80 text-sm font-medium hover:text-[var(--brick)] transition">Masuk</a>
                <a href="{{ route('register') }}" class="bg-[var(--ink)] text-white px-5 py-2 rounded-full text-sm font-medium hover:bg-[var(--brick)] transition">Daftar</a>
            </div>
        </nav>

        <!-- KONTEN HERO -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 py-8 grid lg:grid-cols-2 gap-10 items-center">

            <div class="max-w-lg">
                <h1 class="font-display font-bold text-4xl md:text-5xl leading-[1.1] text-[var(--ink)]">
                    Rumah bermasalah?<br>Pesan teknisi tepercaya, sekarang juga.
                </h1>
                <p class="mt-3 text-[var(--ink)]/65 leading-relaxed">
                    Punya keahlian di bidang jasa perbaikan?
                    <a href="{{ route('register') }}" class="underline decoration-[var(--mustard)] decoration-2 underline-offset-4 font-medium text-[var(--ink)]">Daftar sebagai mitra teknisi</a>
                    dan dapatkan pelanggan dengan mudah.
                </p>
            </div>

            <!-- LOGO -->
            <div class="flex justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="Home Improvement" class="w-72 h-auto">
            </div>
        </div>
    </section>

    <!-- LAYANAN -->
    <section id="layanan" class="max-w-6xl mx-auto px-6 py-16 border-t border-[var(--ink)]/10">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @php
                $layanan = [
                    ['AC', 'Cuci AC, pengisian freon, dan perbaikan kebocoran AC', 'M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83'],
                    ['Listrik', 'Instalasi, korsleting, stop kontak', 'M13 2L4.09 12.11a1 1 0 00.76 1.65h5.02L9 22l9-11h-6l1-9z'],
                    ['Plumbing', 'Penyedotan WC, perbaikan pipa tersumbat, dan penggantian kran bocor', 'M12 2c-3 4-6 7-6 11a6 6 0 0012 0c0-4-3-7-6-11z'],
                    ['Bangunan', 'Pemasangan keramik lantai, perbaikan atap bocor, dan pengecatan dinding', 'M3 12l9-8 9 8M5 10v10h14V10'],
                    ['Perabot rumah', 'Service kompor gas, perbaikan mesin cuci, dan perbaikan kulkas', 'M4 4h16v16H4V4zM8 8h8v8H8V8z'],
                ];
            @endphp
            @foreach ($layanan as $item)
                <div class="group border border-[var(--ink)]/10 rounded-2xl p-5 bg-white hover:border-[var(--brick)]/50 hover:shadow-md transition-all">
                    <div class="w-10 h-10 rounded-xl bg-[var(--brick)]/10 flex items-center justify-center mb-4 group-hover:bg-[var(--brick)] transition-colors">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-[var(--brick)] group-hover:text-white transition-colors">
                            <path d="{{ $item[2] }}"/>
                        </svg>
                    </div>
                    <p class="font-display font-semibold text-lg">{{ $item[0] }}</p>
                    <p class="text-sm text-[var(--ink)]/55 mt-1">{{ $item[1] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- CTA PENUTUP -->
    <section class="bg-[var(--ink)]">
        <div class="max-w-6xl mx-auto px-6 py-16 text-center">
            <h2 class="font-display font-bold text-3xl text-white">Siap memperbaiki rumah Anda?</h2>
            <p class="mt-3 text-white/60 max-w-md mx-auto">
                Buat akun dan pesan teknisi pertama Anda hari ini.
            </p>
            <a href="{{ route('register') }}" class="inline-block mt-6 bg-[var(--brick)] text-white px-8 py-3.5 rounded-full font-medium hover:bg-white hover:text-[var(--ink)] transition">
                Daftar sekarang
            </a>
        </div>
    </section>

</body>
</html>