@extends('layouts.dashboard')

@section('title', 'Detail Order')

@section('content')

<div class="space-y-5">

    {{-- ===================================================== --}}
    {{-- HEADER --}}
    {{-- ===================================================== --}}

    <div>

        <a
            href="{{ route('dashboard.riwayat-order') }}"
            class="inline-flex items-center gap-2
                   text-slate-500
                   hover:text-sky-600
                   transition
                   text-sm
                   font-medium">

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
                    d="M15 19l-7-7 7-7"/>

            </svg>

            Kembali

        </a>

    </div>


    {{-- ===================================================== --}}
    {{-- MAIN CARD --}}
    {{-- ===================================================== --}}

    <div
        class="bg-white
               rounded-3xl
               border border-slate-200
               shadow-sm
               overflow-hidden">


        {{-- ================================================= --}}
        {{-- CARD HEADER --}}
        {{-- ================================================= --}}

        <div
            class="bg-sky-50
                   px-7 py-5
                   border-b border-sky-100">

            <div
                class="flex
                       items-start
                       justify-between
                       gap-4">

                <div>

                    <h1
                        class="text-2xl
                               font-bold
                               text-slate-800">

                        {{ $order->subCategory->category->nama_kategori }}

                    </h1>

                    <p
                        class="text-slate-500
                               mt-1">

                        {{ $order->subCategory->nama_sub_kategori }}

                    </p>

                </div>


                {{-- STATUS --}}

                @if($order->status == 'Menunggu')

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-yellow-100
                               text-yellow-700
                               text-sm
                               font-semibold
                               whitespace-nowrap">

                        Dipesan

                    </span>

                @elseif($order->status == 'Dikonfirmasi')

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-blue-100
                               text-blue-700
                               text-sm
                               font-semibold
                               whitespace-nowrap">

                        Dikonfirmasi

                    </span>

                @elseif($order->status == 'Diproses')

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-sky-100
                               text-sky-700
                               text-sm
                               font-semibold
                               whitespace-nowrap">

                        Dikerjakan

                    </span>

                @elseif($order->status == 'Selesai')

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-green-100
                               text-green-700
                               text-sm
                               font-semibold
                               whitespace-nowrap">

                        Selesai

                    </span>

                @else

                    <span
                        class="px-4 py-2
                               rounded-full
                               bg-red-100
                               text-red-700
                               text-sm
                               font-semibold
                               whitespace-nowrap">

                        Dibatalkan

                    </span>

                @endif

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- STATUS PROGRESS --}}
        {{-- ================================================= --}}

        <div
            class="px-7 py-5
                   border-b border-slate-100">

            <div
                class="relative
                       max-w-4xl
                       mx-auto">


                {{-- LINE --}}

                <div
                    class="absolute
                           top-3.5
                           left-[8%]
                           right-[8%]
                           h-1
                           bg-slate-200
                           rounded-full">
                </div>


                {{-- ACTIVE LINE --}}

                @php

                    if ($order->status == 'Menunggu') {
                        $progress = '25%';
                    } elseif ($order->status == 'Dikonfirmasi') {
                        $progress = '50%';
                    } elseif ($order->status == 'Diproses') {
                        $progress = '75%';
                    } elseif ($order->status == 'Selesai') {
                        $progress = '100%';
                    } else {
                        $progress = '0%';
                    }

                @endphp


                <div
                    class="absolute
                           top-3.5
                           left-[8%]
                           h-1
                           bg-sky-500
                           rounded-full"
                    style="width: {{ $progress }};">
                </div>


                {{-- STEPS --}}

                <div
                    class="relative
                           grid
                           grid-cols-4
                           gap-4">


                    {{-- STEP 1 --}}

                    <div class="text-center">

                        <div
                            class="w-7 h-7
                                   mx-auto
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Menunggu','Dikonfirmasi','Diproses','Selesai'])
                                      ? 'bg-sky-500 text-white'
                                      : 'bg-slate-200 text-slate-500' }}">

                            @if(in_array($order->status, ['Menunggu','Dikonfirmasi','Diproses','Selesai']))

                                ✓

                            @else

                                1

                            @endif

                        </div>

                        <p
                            class="mt-2
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Menunggu','Dikonfirmasi','Diproses','Selesai'])
                                      ? 'text-slate-700'
                                      : 'text-slate-400' }}">

                            Dipesan

                        </p>

                    </div>


                    {{-- STEP 2 --}}

                    <div class="text-center">

                        <div
                            class="w-7 h-7
                                   mx-auto
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Dikonfirmasi','Diproses','Selesai'])
                                      ? 'bg-sky-500 text-white'
                                      : 'bg-slate-200 text-slate-500' }}">

                            @if(in_array($order->status, ['Dikonfirmasi','Diproses','Selesai']))

                                ✓

                            @else

                                2

                            @endif

                        </div>

                        <p
                            class="mt-2
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Dikonfirmasi','Diproses','Selesai'])
                                      ? 'text-slate-700'
                                      : 'text-slate-400' }}">

                            Dikonfirmasi

                        </p>

                    </div>


                    {{-- STEP 3 --}}

                    <div class="text-center">

                        <div
                            class="w-7 h-7
                                   mx-auto
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Diproses','Selesai'])
                                      ? 'bg-sky-500 text-white'
                                      : 'bg-slate-200 text-slate-500' }}">

                            @if(in_array($order->status, ['Diproses','Selesai']))

                                ✓

                            @else

                                3

                            @endif

                        </div>

                        <p
                            class="mt-2
                                   text-xs
                                   font-semibold
                                   {{ in_array($order->status, ['Diproses','Selesai'])
                                      ? 'text-slate-700'
                                      : 'text-slate-400' }}">

                            Dikerjakan

                        </p>

                    </div>


                    {{-- STEP 4 --}}

                    <div class="text-center">

                        <div
                            class="w-7 h-7
                                   mx-auto
                                   rounded-full
                                   flex
                                   items-center
                                   justify-center
                                   text-xs
                                   font-semibold
                                   {{ $order->status == 'Selesai'
                                      ? 'bg-sky-500 text-white'
                                      : 'bg-slate-200 text-slate-500' }}">

                            @if($order->status == 'Selesai')

                                ✓

                            @else

                                4

                            @endif

                        </div>

                        <p
                            class="mt-2
                                   text-xs
                                   font-semibold
                                   {{ $order->status == 'Selesai'
                                      ? 'text-slate-700'
                                      : 'text-slate-400' }}">

                            Selesai

                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- RINGKASAN ORDER --}}
        {{-- ================================================= --}}

        {{-- ================================================= --}}
        {{-- BARIS 1: RINGKASAN BIAYA & JADWAL --}}
        {{-- ================================================= --}}

        <div class="px-7 py-5 border-b border-slate-100 bg-slate-50/50">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">

                {{-- JADWAL --}}
                <div>
                    <p class="text-xs text-slate-400">Jadwal</p>
                    <p class="font-semibold text-slate-800 mt-1">
                        {{ \Carbon\Carbon::parse($order->jadwal)->translatedFormat('d M Y') }}
                    </p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        {{ \Carbon\Carbon::parse($order->jadwal)->format('H:i') }} WIB
                    </p>
                </div>

                {{-- JUMLAH UNIT --}}
                <div>
                    <p class="text-xs text-slate-400">Jumlah Unit</p>
                    <p class="font-semibold text-slate-800 mt-1">
                        {{ $order->jumlah_unit }} Unit
                    </p>
                </div>

                {{-- HARGA / UNIT --}}
                <div>
                    <p class="text-xs text-slate-400">Harga / Unit</p>
                    <p class="font-semibold text-sky-600 mt-1">
                        Rp {{ number_format($order->harga_per_unit, 0, ',', '.') }}
                    </p>
                </div>

                {{-- TOTAL BIAYA --}}
                <div>
                    <p class="text-xs text-slate-400">Total Biaya</p>
                    <p class="font-bold text-sky-600 text-lg mt-1">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </p>
                </div>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- BARIS 2: DETAIL ALAMAT, TEKNISI, DESKRIPSI, METODE PEMBAYARAN & FOTO KERUSAKAN --}}
        {{-- ================================================= --}}

        <div class="px-7 py-6 border-b border-slate-100">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- ALAMAT LAYANAN --}}
                <div>
                    <p class="text-xs text-slate-400 font-medium">Alamat Layanan</p>
                    <p class="text-sm font-semibold text-slate-800 mt-1 leading-relaxed">
                        {{ $order->alamat }}
                    </p>
                </div>

                {{-- DESKRIPSI KERUSAKAN --}}
                <div>
                    <p class="text-xs text-slate-400 font-medium">Deskripsi Kerusakan</p>
                    <p class="text-sm text-slate-700 mt-1 leading-relaxed">
                        {{ $order->deskripsi_kerusakan ?? '-' }}
                    </p>
                </div>

                {{-- METODE PEMBAYARAN --}}
                <div>
                    <p class="text-xs text-slate-400 font-medium">Metode Pembayaran</p>
                    <div class="mt-1">
                        @if($order->metode_pembayaran === 'qris')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold">
                                QRIS
                            </span>
                        @elseif($order->metode_pembayaran === 'tunai')
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                Tunai
                            </span>
                        @else
                            <span class="text-xs text-slate-500">Belum dipilih</span>
                        @endif
                    </div>
                </div>

            </div>

            {{-- DOKUMENTASI FOTO KERUSAKAN & BUKTI HASIL PERBAIKAN (SEBARIS / SIDE-BY-SIDE) --}}
            @if($order->foto_kerusakan || $order->foto_bukti)
                <div class="mt-6 pt-5 border-t border-slate-100">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Dokumentasi Pesanan</p>
                    <div class="flex flex-wrap items-center gap-6">
                        @if($order->foto_kerusakan)
                            <div class="flex flex-col gap-1.5">
                                <span class="text-xs text-slate-500 font-semibold">📷 Foto Kerusakan</span>
                                <a href="{{ asset('storage/' . $order->foto_kerusakan) }}" target="_blank" class="block group">
                                    <img
                                        src="{{ asset('storage/' . $order->foto_kerusakan) }}"
                                        alt="Foto Kerusakan"
                                        class="w-32 h-24 object-cover rounded-2xl border border-slate-200 shadow-xs group-hover:opacity-90 transition duration-200"
                                    >
                                </a>
                            </div>
                        @endif

                        @if($order->foto_bukti)
                            <div class="flex flex-col gap-1.5">
                                <span class="text-xs text-emerald-700 font-bold">📸 Bukti Hasil Perbaikan</span>
                                <a href="{{ asset('storage/' . $order->foto_bukti) }}" target="_blank" class="block group">
                                    <img
                                        src="{{ asset('storage/' . $order->foto_bukti) }}"
                                        alt="Bukti Hasil Perbaikan"
                                        class="w-32 h-24 object-cover rounded-2xl border-2 border-emerald-500 shadow-xs group-hover:opacity-90 transition duration-200"
                                    >
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>


        {{-- ================================================= --}}
        {{-- BARIS 3: RATING & ULASAN DAN FOTO/PROFIL TEKNISI --}}
        {{-- ================================================= --}}

        <div class="px-7 py-7 bg-slate-50/70">

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- COL 1: RATING & ULASAN --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">

                    <div>
                        <h3 class="text-base font-bold text-slate-800 mb-1">
                            Rating & Ulasan
                        </h3>
                        <p class="text-xs text-slate-500 mb-4">
                            Penilaian kualitas hasil perbaikan layanan ini.
                        </p>

                        @if($order->status === 'Selesai')

                            @if(auth()->user()->role_user === 'pelanggan')

                                @if($order->review)

                                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-200">
                                        <div class="flex items-center gap-1 text-amber-500 font-bold text-lg">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $order->review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                            <span class="text-slate-700 text-xs ml-2">({{ $order->review->rating }}/5)</span>
                                        </div>
                                        <p class="text-xs text-slate-700 mt-2 italic">
                                            "{{ $order->review->ulasan ?? 'Tidak ada komentar' }}"
                                        </p>
                                    </div>

                                @else

                                    <form action="{{ route('order.review', $order->id_order) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Bintang Rating (1-5)</label>
                                            <div class="flex items-center gap-3">
                                                @for($star = 5; $star >= 1; $star--)
                                                    <label class="flex items-center gap-1 cursor-pointer">
                                                        <input type="radio" name="rating" value="{{ $star }}" required class="text-sky-600 focus:ring-sky-500">
                                                        <span class="text-xs font-bold text-slate-700">{{ $star }} ★</span>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 mb-1">Ulasan Pengalaman</label>
                                            <textarea name="ulasan" rows="2" placeholder="Tulis ulasan Anda..." class="w-full text-xs p-2.5 rounded-xl border border-slate-200 text-slate-800 focus:ring-2 focus:ring-sky-500"></textarea>
                                        </div>

                                        <button type="submit" class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition shadow-sm">
                                            Kirim Ulasan
                                        </button>
                                    </form>

                                @endif

                            @else

                                @if($order->review)
                                    <div class="p-4 rounded-xl bg-amber-50/50 border border-amber-200">
                                        <div class="flex items-center gap-1 text-amber-400 text-base font-bold">
                                            @for($i = 1; $i <= 5; $i++)
                                                <span>{{ $i <= $order->review->rating ? '★' : '☆' }}</span>
                                            @endfor
                                            <span class="text-slate-700 text-xs ml-2">({{ $order->review->rating }}/5)</span>
                                        </div>
                                        <p class="text-xs text-slate-700 mt-2 italic">
                                            "{{ $order->review->ulasan ?? 'Pelanggan tidak memberikan catatan tertulis' }}"
                                        </p>
                                    </div>
                                @else
                                    <div class="p-4 rounded-xl bg-slate-50 text-slate-400 text-xs text-center">
                                        Belum ada ulasan dari pelanggan untuk pesanan ini.
                                    </div>
                                @endif

                            @endif

                        @else

                            <div class="p-4 rounded-xl bg-slate-50 text-slate-400 text-xs text-center">
                                Rating & Ulasan dapat diisi setelah pesanan selesai.
                            </div>

                        @endif

                    </div>

                </div>


                {{-- COL 2: PROFIL TERHUBUNG (PELANGGAN UNTUK TEKNISI, TEKNISI UNTUK PELANGGAN) --}}
                <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">

                    @if(auth()->user()->role_user === 'teknisi')

                        {{-- PROFIL PELANGGAN (UNTUK TEKNISI) --}}
                        <h3 class="text-base font-bold text-slate-800 mb-1">
                            Profil Pelanggan Terhubung
                        </h3>

                        @if($order->pelanggan)

                            <div class="flex items-start gap-4">

                                {{-- AVATAR PELANGGAN --}}
                                <div class="w-16 h-16 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-xl font-bold shrink-0 shadow-sm">
                                    {{ strtoupper(substr($order->pelanggan->nama ?? 'P', 0, 2)) }}
                                </div>

                                {{-- DETAIL PELANGGAN --}}
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-base font-bold text-slate-800">
                                        {{ $order->pelanggan->nama }}
                                    </h4>

                                    <p class="text-xs text-slate-500 mt-0.5">
                                        No. HP: <span class="font-semibold text-slate-700">{{ $order->pelanggan->no_hp ?? '-' }}</span>
                                    </p>

                                    <p class="text-xs text-slate-500 mt-0.5 truncate">
                                        Alamat: <span class="font-semibold text-slate-700">{{ $order->alamat }}</span>
                                    </p>

                                    @if($order->pelanggan->no_hp)
                                        <div class="mt-3 flex flex-wrap gap-2">
                                            <a
                                                href="{{ $order->pelanggan->getWhatsappLinkWithMessage('Halo ' . $order->pelanggan->nama . ', saya teknisi ' . auth()->user()->nama . ' yang menangani order #' . $order->id_order . ' (' . ($order->subCategory->nama_sub_kategori ?? 'Layanan') . ').') }}"
                                                target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition border border-emerald-200"
                                            >
                                                💬 WhatsApp
                                            </a>

                                            <a
                                                href="tel:{{ $order->pelanggan->no_hp }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold transition"
                                            >
                                                📞 Telepon
                                            </a>
                                        </div>
                                    @endif

                                </div>

                            </div>

                        @else

                            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs text-center">
                                Data pelanggan tidak ditemukan.
                            </div>

                        @endif

                    @else

                        {{-- PROFIL TEKNISI (UNTUK PELANGGAN / ADMIN) --}}
                        <h3 class="text-base font-bold text-slate-800 mb-1">
                            Profil Teknisi Terhubung
                        </h3>

                        @if($order->teknisi)

                            <div class="flex items-start gap-4">

                                {{-- FOTO / AVATAR TEKNISI --}}
                                @if(optional($order->teknisi->profileTeknisi)->foto_profil)
                                    <img
                                        src="{{ asset('storage/' . $order->teknisi->profileTeknisi->foto_profil) }}"
                                        alt="{{ $order->teknisi->nama }}"
                                        class="w-16 h-16 rounded-2xl object-cover border border-slate-200 shadow-sm shrink-0"
                                    >
                                @else
                                    <div class="w-16 h-16 rounded-2xl bg-sky-600 text-white flex items-center justify-center text-xl font-bold shrink-0 shadow-sm">
                                        {{ strtoupper(substr($order->teknisi->nama, 0, 2)) }}
                                    </div>
                                @endif

                                {{-- DETAIL TEKNISI --}}
                                <div class="min-w-0 flex-1">
                                    <h4 class="text-base font-bold text-slate-800">
                                        {{ $order->teknisi->nama }}
                                    </h4>

                                    <p class="text-xs text-slate-500 mt-0.5">
                                        Spesialisasi: <span class="font-semibold text-slate-700">{{ $order->subCategory->nama_sub_kategori ?? 'Teknisi Handal' }}</span>
                                    </p>

                                    <p class="text-xs text-slate-500 mt-0.5">
                                        No. HP: <span class="font-semibold text-slate-700">{{ $order->teknisi->no_hp }}</span>
                                    </p>

                                    <div class="mt-3 flex flex-wrap gap-2">
                                        <a
                                            href="{{ $order->teknisi->getWhatsappLinkWithMessage('Halo ' . $order->teknisi->nama . ', saya pelanggan order #' . $order->id_order . ' (' . ($order->subCategory->nama_sub_kategori ?? 'Layanan') . ') di Home Improvement.') }}"
                                            target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-xs font-semibold transition border border-emerald-200"
                                        >
                                            💬 WhatsApp
                                        </a>

                                        <a
                                            href="tel:{{ $order->teknisi->no_hp }}"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 text-slate-700 hover:bg-slate-200 text-xs font-semibold transition"
                                        >
                                            📞 Telepon
                                        </a>
                                    </div>

                                </div>

                            </div>

                        @else

                            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs text-center">
                                Belum ada teknisi yang menerima pesanan ini.
                            </div>

                        @endif

                    @endif

                </div>

            </div>

        </div>

    </div>

</div>

@endsection