@extends('layouts.dashboard')

@section('title', 'Verifikasi Teknisi')

@section('content')

@php
    /*
    |--------------------------------------------------------------------------
    | DATA VERIFIKASI
    |--------------------------------------------------------------------------
    | Controller mengirim:
    | - $teknisis
    | - $status
    |
    | Kita gunakan collection tersebut untuk daftar sesuai filter.
    | Untuk statistik, kita ambil langsung berdasarkan status database.
    */

    $daftarTeknisi = $teknisis ?? collect();

    $statusAktif = $status ?? 'Menunggu';

    // Statistik seluruh teknisi
    $jumlahMenunggu = \App\Models\ProfileTeknisi::where(
        'status_verifikasi',
        'Menunggu'
    )->count();

    $jumlahDisetujui = \App\Models\ProfileTeknisi::where(
        'status_verifikasi',
        'Disetujui'
    )->count();

    $jumlahDitolak = \App\Models\ProfileTeknisi::where(
        'status_verifikasi',
        'Ditolak'
    )->count();
@endphp


<div class="space-y-6">

    {{-- =========================================================
         NOTIFIKASI SUKSES
         ========================================================= --}}
    @if(session('success'))

        <div class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-emerald-100">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9 12l2 2 4-4"
                    />

                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />
                </svg>

            </div>

            <div>
                <p class="text-sm font-semibold">
                    Berhasil
                </p>

                <p class="mt-0.5 text-sm">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif


    {{-- =========================================================
         NOTIFIKASI ERROR
         ========================================================= --}}
    @if(session('error'))

        <div class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">

            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-red-100">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        d="M12 8v4"
                    />

                    <path
                        stroke-linecap="round"
                        d="M12 16h.01"
                    />
                </svg>

            </div>

            <div>
                <p class="text-sm font-semibold">
                    Terjadi Kesalahan
                </p>

                <p class="mt-0.5 text-sm">
                    {{ session('error') }}
                </p>
            </div>

        </div>

    @endif


    {{-- =========================================================
         STATISTIK VERIFIKASI
         ========================================================= --}}
    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">

        {{-- MENUNGGU --}}
        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Menunggu']) }}"
            class="rounded-2xl border border-amber-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Menunggu Verifikasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-amber-600">
                        {{ $jumlahMenunggu }}
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-50 text-amber-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            d="M12 7v5l3 2"
                        />
                    </svg>

                </div>

            </div>

        </a>


        {{-- TERVERIFIKASI --}}
        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Disetujui']) }}"
            class="rounded-2xl border border-emerald-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Terverifikasi
                    </p>

                    <p class="mt-2 text-3xl font-bold text-emerald-600">
                        {{ $jumlahDisetujui }}
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">

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
                            stroke-linejoin="round"
                            d="M9 12l2 2 4-4"
                        />

                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />
                    </svg>

                </div>

            </div>

        </a>


        {{-- DITOLAK --}}
        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Ditolak']) }}"
            class="rounded-2xl border border-red-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md"
        >

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Ditolak
                    </p>

                    <p class="mt-2 text-3xl font-bold text-red-600">
                        {{ $jumlahDitolak }}
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-red-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle
                            cx="12"
                            cy="12"
                            r="9"
                        />

                        <path
                            stroke-linecap="round"
                            d="M9 9l6 6"
                        />

                        <path
                            stroke-linecap="round"
                            d="M15 9l-6 6"
                        />
                    </svg>

                </div>

            </div>

        </a>

    </div>


    {{-- =========================================================
         FILTER STATUS
         ========================================================= --}}
    <div class="flex flex-wrap gap-2">

        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Menunggu']) }}"
            class="
                rounded-xl px-4 py-2 text-sm font-semibold transition
                {{ $statusAktif === 'Menunggu'
                    ? 'bg-slate-900 text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                }}
            "
        >
            Menunggu
        </a>


        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Disetujui']) }}"
            class="
                rounded-xl px-4 py-2 text-sm font-semibold transition
                {{ $statusAktif === 'Disetujui'
                    ? 'bg-emerald-600 text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                }}
            "
        >
            Terverifikasi
        </a>


        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'Ditolak']) }}"
            class="
                rounded-xl px-4 py-2 text-sm font-semibold transition
                {{ $statusAktif === 'Ditolak'
                    ? 'bg-red-600 text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                }}
            "
        >
            Ditolak
        </a>


        <a
            href="{{ route('admin.teknisi.verifikasi', ['status' => 'semua']) }}"
            class="
                rounded-xl px-4 py-2 text-sm font-semibold transition
                {{ $statusAktif === 'semua'
                    ? 'bg-slate-900 text-white'
                    : 'border border-slate-200 bg-white text-slate-600 hover:bg-slate-50'
                }}
            "
        >
            Semua
        </a>

    </div>


    {{-- =========================================================
         DAFTAR TEKNISI
         ========================================================= --}}
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER --}}
        <div class="border-b border-slate-100 px-6 py-5">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    @if($statusAktif === 'Disetujui')

                        <h2 class="text-lg font-bold text-slate-900">
                            Teknisi Terverifikasi
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Daftar teknisi yang telah mendapatkan persetujuan Admin.
                        </p>

                    @elseif($statusAktif === 'Ditolak')

                        <h2 class="text-lg font-bold text-slate-900">
                            Teknisi Ditolak
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Daftar teknisi yang belum mendapatkan persetujuan.
                        </p>

                    @elseif($statusAktif === 'semua')

                        <h2 class="text-lg font-bold text-slate-900">
                            Semua Teknisi
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Daftar seluruh teknisi yang telah terdaftar.
                        </p>

                    @else

                        <h2 class="text-lg font-bold text-slate-900">
                            Teknisi Menunggu Verifikasi
                        </h2>

                    @endif

                </div>


                <span
                    class="
                        inline-flex w-fit items-center rounded-full px-3 py-1.5
                        text-xs font-semibold
                        @if($statusAktif === 'Disetujui')
                            bg-emerald-50 text-emerald-700
                        @elseif($statusAktif === 'Ditolak')
                            bg-red-50 text-red-700
                        @else
                            bg-amber-50 text-amber-700
                        @endif
                    "
                >
                    {{ $daftarTeknisi->count() }} Teknisi
                </span>

            </div>

        </div>


        {{-- LIST --}}
        <div class="divide-y divide-slate-100">

            @forelse($daftarTeknisi as $profile)

                <div class="p-6">

                    <div class="flex flex-col gap-5">

                        {{-- =================================================
                             DATA UTAMA TEKNISI
                             ================================================= --}}
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                            <div class="flex min-w-0 items-center gap-4">

                                {{-- =================================================
                                     AVATAR / FOTO DIRI TEKNISI
                                     ================================================= --}}
                                <div class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden rounded-full bg-violet-100 text-violet-600">

                                    {{-- 
                                        FOTO TEKNISI DIAMBIL DARI:
                                        $profile->foto_diri

                                        BUKAN:
                                        $profile->user->foto_profil
                                    --}}
                                    @if(!empty($profile->foto_diri))

                                        <img
                                            src="{{ asset('storage/' . $profile->foto_diri) }}"
                                            alt="Foto {{ $profile->user->nama ?? 'Teknisi' }}"
                                            class="h-full w-full object-cover"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >

                                        {{-- Fallback jika file tidak ditemukan --}}
                                        <div
                                            class="hidden h-full w-full items-center justify-center"
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

                                    @else

                                        {{-- IKON DEFAULT --}}
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

                                    @endif

                                </div>


                                {{-- INFORMASI --}}
                                <div class="min-w-0">

                                    <h3 class="truncate text-base font-bold text-slate-900">
                                        {{ $profile->user->nama ?? 'Nama Teknisi' }}
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Teknisi
                                    </p>

                                    <div class="mt-2 flex flex-wrap gap-2">

                                        @if($profile->category)

                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                                {{ $profile->category->nama_kategori }}
                                            </span>

                                        @endif


                                        @if($profile->subCategory)

                                            <span class="rounded-full bg-violet-50 px-3 py-1 text-xs font-medium text-violet-700">
                                                {{ $profile->subCategory->nama_sub_kategori }}
                                            </span>

                                        @endif


                                        @if(isset($profile->user->no_hp))

                                            <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                                {{ $profile->user->no_hp }}
                                            </span>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- STATUS --}}
                            <div class="shrink-0">

                                @if($profile->status_verifikasi === 'Disetujui')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                        Terverifikasi

                                    </span>

                                @elseif($profile->status_verifikasi === 'Ditolak')

                                    <span class="inline-flex items-center gap-2 rounded-full bg-red-50 px-3 py-1.5 text-xs font-semibold text-red-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Ditolak

                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-2 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-semibold text-amber-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span>

                                        Menunggu

                                    </span>

                                @endif

                            </div>

                        </div>


                        {{-- =================================================
                             INFORMASI TAMBAHAN + DOKUMEN
                             3 DATA DI KIRI + 3 DOKUMEN DI KANAN
                             ================================================= --}}
                        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">

                            {{-- =================================================
                                 INFORMASI TAMBAHAN - SISI KIRI
                                 ================================================= --}}
                            <div class="space-y-3">

                                {{-- EMAIL --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Email
                                    </p>

                                    <p class="mt-1 break-all text-sm font-medium text-slate-700">
                                        {{ $profile->user->email ?? '-' }}
                                    </p>

                                </div>


                                {{-- ALAMAT --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Alamat
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-slate-700">
                                        {{ $profile->user->alamat ?? '-' }}
                                    </p>

                                </div>


                                {{-- TANGGAL DAFTAR --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                        Terdaftar
                                    </p>

                                    <p class="mt-1 text-sm font-medium text-slate-700">

                                        @if($profile->created_at)

                                            {{ $profile->created_at->format('d M Y') }}

                                        @else

                                            -

                                        @endif

                                    </p>

                                </div>

                            </div>


                            {{-- =================================================
                                 DOKUMEN - SISI KANAN
                                 FOTO DIRI + KTP + PORTOFOLIO
                                 ================================================= --}}
                            <div class="space-y-3">

                                {{-- FOTO DIRI --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <div class="flex items-center justify-between gap-3">

                                        <div class="flex min-w-0 items-center gap-3">

                                            {{-- THUMBNAIL FOTO DIRI --}}
                                            <div class="flex h-12 w-12 shrink-0 items-center justify-center overflow-hidden rounded-xl bg-violet-100 text-violet-600">

                                                @if(!empty($profile->foto_diri))

                                                    <img
                                                        src="{{ asset('storage/' . $profile->foto_diri) }}"
                                                        alt="Foto {{ $profile->user->nama ?? 'Teknisi' }}"
                                                        class="h-full w-full object-cover"
                                                    >

                                                @else

                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        class="h-6 w-6"
                                                        fill="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"
                                                        />
                                                    </svg>

                                                @endif

                                            </div>


                                            <div class="min-w-0">

                                                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                    Foto Diri
                                                </p>

                                                @if(!empty($profile->foto_diri))

                                                    <p class="mt-1 text-sm font-medium text-emerald-600">
                                                        Foto tersedia
                                                    </p>

                                                @else

                                                    <p class="mt-1 text-sm font-medium text-red-500">
                                                        Belum tersedia
                                                    </p>

                                                @endif

                                            </div>

                                        </div>


                                        @if(!empty($profile->foto_diri))

                                            <a
                                                href="{{ asset('storage/' . $profile->foto_diri) }}"
                                                target="_blank"
                                                rel="noopener noreferrer"
                                                class="shrink-0 rounded-lg bg-white px-3 py-2 text-xs font-semibold text-sky-600 shadow-sm hover:text-sky-700"
                                            >
                                                Lihat
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- KTP --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <div class="flex items-center justify-between gap-3">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                Dokumen KTP
                                            </p>

                                            @if(!empty($profile->foto_ktp))

                                                <p class="mt-1 text-sm font-medium text-emerald-600">
                                                    Dokumen tersedia
                                                </p>

                                            @elseif(!empty($profile->ktp))

                                                <p class="mt-1 text-sm font-medium text-emerald-600">
                                                    Dokumen tersedia
                                                </p>

                                            @else

                                                <p class="mt-1 text-sm font-medium text-red-500">
                                                    Belum tersedia
                                                </p>

                                            @endif

                                        </div>


                                        @if(!empty($profile->foto_ktp))

                                            <a
                                                href="{{ asset('storage/' . $profile->foto_ktp) }}"
                                                target="_blank"
                                                class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-sky-600 shadow-sm hover:text-sky-700"
                                            >
                                                Lihat
                                            </a>

                                        @elseif(!empty($profile->ktp))

                                            <a
                                                href="{{ asset('storage/' . $profile->ktp) }}"
                                                target="_blank"
                                                class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-sky-600 shadow-sm hover:text-sky-700"
                                            >
                                                Lihat
                                            </a>

                                        @endif

                                    </div>

                                </div>


                                {{-- PORTOFOLIO --}}
                                <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">

                                    <div class="flex items-center justify-between gap-3">

                                        <div>

                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                Portofolio
                                            </p>

                                            @if(!empty($profile->portofolio))

                                                <p class="mt-1 text-sm font-medium text-emerald-600">
                                                    Dokumen tersedia
                                                </p>

                                            @else

                                                <p class="mt-1 text-sm font-medium text-red-500">
                                                    Belum tersedia
                                                </p>

                                            @endif

                                        </div>


                                        @if(!empty($profile->portofolio))

                                            <a
                                                href="{{ asset('storage/' . $profile->portofolio) }}"
                                                target="_blank"
                                                class="rounded-lg bg-white px-3 py-2 text-xs font-semibold text-sky-600 shadow-sm hover:text-sky-700"
                                            >
                                                Lihat
                                            </a>

                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- =================================================
                             TOMBOL AKSI
                             HANYA UNTUK MENUNGGU
                             ================================================= --}}
                        @if($profile->status_verifikasi === 'Menunggu')

                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">

                                {{-- TOLAK --}}
                                <form
                                    action="{{ route('admin.teknisi.update-verifikasi', $profile->getKey()) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status_verifikasi"
                                        value="Ditolak"
                                    >

                                    <button
                                        type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin menolak teknisi ini?')"
                                        class="flex w-full items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="1.8"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                d="M6 6l12 12"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                d="M18 6L6 18"
                                            />
                                        </svg>

                                        Tolak

                                    </button>

                                </form>


                                {{-- VERIFIKASI --}}
                                <form
                                    action="{{ route('admin.teknisi.update-verifikasi', $profile->getKey()) }}"
                                    method="POST"
                                >

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status_verifikasi"
                                        value="Disetujui"
                                    >

                                    <button
                                        type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin memverifikasi teknisi ini?')"
                                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800"
                                    >

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5"
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

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            />
                                        </svg>

                                        Verifikasi

                                    </button>

                                </form>

                            </div>

                        @endif


                        {{-- =================================================
                             INFORMASI STATUS
                             ================================================= --}}
                        @if($profile->status_verifikasi === 'Disetujui')

                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                d="M9 12l2 2 4-4"
                                            />

                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-emerald-800">
                                            Teknisi telah terverifikasi
                                        </p>

                                        <p class="mt-1 text-xs text-emerald-700">
                                            Teknisi ini telah mendapatkan persetujuan Admin dan dapat menerima order pelanggan.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @elseif($profile->status_verifikasi === 'Ditolak')

                            <div class="rounded-2xl border border-red-200 bg-red-50 p-4">

                                <div class="flex items-start gap-3">

                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">

                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            stroke-width="2"
                                        >
                                            <circle
                                                cx="12"
                                                cy="12"
                                                r="9"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                d="M9 9l6 6"
                                            />

                                            <path
                                                stroke-linecap="round"
                                                d="M15 9l-6 6"
                                            />
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="text-sm font-semibold text-red-800">
                                            Verifikasi ditolak
                                        </p>

                                        <p class="mt-1 text-xs text-red-700">
                                            Teknisi ini belum dapat menerima order pelanggan.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>


            @empty

                {{-- =====================================================
                     EMPTY STATE
                     ===================================================== --}}
                <div class="px-6 py-12 text-center flex flex-col items-center justify-center">

                    @if($statusAktif === 'Menunggu')

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-emerald-50 text-emerald-600 mb-3 shadow-xs">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4" />
                                <circle cx="12" cy="12" r="9" />
                            </svg>
                        </div>

                        <h3 class="text-base font-bold text-slate-900">
                            Semua pendaftaran teknisi sudah diproses
                        </h3>

                    @elseif($statusAktif === 'Disetujui')

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M8 12h8"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-base font-bold text-slate-900">
                            Belum Ada Teknisi Terverifikasi
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Belum ada teknisi yang disetujui oleh Admin.
                        </p>


                    @elseif($statusAktif === 'Ditolak')

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M8 12h8"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-base font-bold text-slate-900">
                            Belum Ada Teknisi Ditolak
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Belum ada teknisi yang ditolak.
                        </p>


                    @else

                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-slate-50 text-slate-400">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-8 w-8"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                />

                                <path
                                    stroke-linecap="round"
                                    d="M8 12h8"
                                />
                            </svg>

                        </div>

                        <h3 class="mt-4 text-base font-bold text-slate-900">
                            Belum Ada Data Teknisi
                        </h3>

                        <p class="mt-1 text-sm text-slate-500">
                            Belum ada teknisi yang terdaftar.
                        </p>

                    @endif

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection