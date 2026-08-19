@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-end">

        <button
            type="button"
            onclick="openEditProfile()"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800"
        >
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
                    d="M16.862 3.487a2.25 2.25 0 013.182 3.182L8.25 18.463 4 19.5l1.037-4.25L16.862 3.487z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 5l4 4"
                />
            </svg>

            Edit Profil
        </button>

    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- VALIDATION ERROR --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">

            <p class="mb-2 font-semibold text-red-700">
                Terdapat kesalahan:
            </p>

            <ul class="list-disc pl-5 text-sm text-red-600">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- PROFILE HEADER --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        <div class="bg-white px-6 py-7">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

                {{-- AVATAR --}}

                <div class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-violet-50 text-violet-600">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-10 w-10"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M12 12a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9Zm0 2c-4.42 0-8 2.24-8 5v1h16v-1c0-2.76-3.58-5-8-5Z"/>
                    </svg>

                </div>


                {{-- IDENTITAS --}}

                <div class="flex-1">

                    <div class="flex flex-wrap items-center justify-between gap-3">

                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ $user->nama ?? '-' }}
                        </h2>


                        @php
                            $status = strtolower(
                                $profile?->status_verifikasi ?? 'menunggu'
                            );
                        @endphp


                        {{-- SUDAH DISETUJUI --}}

                        @if($status === 'disetujui' || $status === 'terverifikasi')

                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-700">

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
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>

                                Terverifikasi

                            </span>


                        {{-- DITOLAK --}}

                        @elseif($status === 'ditolak')

                            <span class="rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-700">
                                Ditolak
                            </span>


                        {{-- MENUNGGU --}}

                        @else

                            <span class="rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-700">
                                Menunggu Verifikasi
                            </span>

                        @endif

                    </div>


                    <p class="mt-1 text-sm text-slate-400">
                        Teknisi
                    </p>


                    <p class="mt-2 text-sm font-medium text-slate-700">
                        {{ $profile?->subCategory?->nama_sub_kategori ?? 'Belum memilih keahlian' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- STATISTIK --}}
        {{-- ===================================================== --}}

        <div class="grid grid-cols-3 divide-x divide-slate-100 border-t border-slate-100">

            {{-- ORDER SELESAI --}}

            <div class="px-4 py-6 text-center">

                <p class="text-2xl font-bold text-slate-900">
                    {{ $orderSelesai }}
                </p>

                <p class="mt-1 text-xs text-slate-400 sm:text-sm">
                    Order Selesai
                </p>

            </div>


            {{-- RATING --}}

            <div class="px-4 py-6 text-center">

                <div class="flex items-center justify-center gap-1">

                    <p class="text-2xl font-bold text-slate-900">
                        {{ number_format($rating, 1) }}
                    </p>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-amber-400"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77 5.82 21.02 7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>

                </div>

                <p class="mt-1 text-xs text-slate-400 sm:text-sm">
                    Rating
                </p>

            </div>


            {{-- BERGABUNG --}}

            <div class="px-4 py-6 text-center">

                <p class="text-lg font-bold text-slate-900 sm:text-2xl">
                    {{ $bergabung }}
                </p>

                <p class="mt-1 text-xs text-slate-400 sm:text-sm">
                    Lama Bergabung
                </p>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MAIN GRID --}}
    {{-- ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">


        {{-- ===================================================== --}}
        {{-- DATA DIRI --}}
        {{-- ===================================================== --}}

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

            <h2 class="text-lg font-bold text-slate-900">
                Data Diri
            </h2>

            <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                {{-- NAMA --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Nama Lengkap
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $user->nama ?? '-' }}
                    </p>

                </div>


                {{-- EMAIL --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Email
                    </p>

                    <p class="mt-1 break-all font-semibold text-slate-800">
                        {{ $user->email ?? '-' }}
                    </p>

                </div>


                {{-- NO HP --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        No. HP
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $user->no_hp ?? '-' }}
                    </p>

                </div>


                {{-- ALAMAT --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Alamat
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $user->alamat ?? '-' }}
                    </p>

                </div>


                {{-- KATEGORI --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Kategori
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $profile?->category?->nama_kategori ?? '-' }}
                    </p>

                </div>


                {{-- KEAHLIAN --}}

                <div>

                    <p class="text-xs font-medium text-slate-400">
                        Keahlian
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $profile?->subCategory?->nama_sub_kategori ?? '-' }}
                    </p>

                </div>


                {{-- PENGALAMAN --}}

                <div class="sm:col-span-2">

                    <p class="text-xs font-medium text-slate-400">
                        Pengalaman
                    </p>

                    <p class="mt-1 whitespace-pre-line font-semibold text-slate-800">
                        {{ $profile?->pengalaman ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- DOKUMEN --}}
        {{-- ===================================================== --}}

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <h2 class="text-lg font-bold text-slate-900">
                Dokumen Verifikasi
            </h2>

            <p class="mt-1 text-sm text-slate-400">
                Dokumen yang digunakan dalam proses verifikasi.
            </p>


            <div class="mt-6 space-y-4">


                {{-- KTP --}}

                <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4">

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            KTP
                        </p>

                        <p class="text-xs text-slate-400">
                            Identitas
                        </p>

                    </div>


                    @if($profile?->ktp)

                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            Tersedia
                        </span>

                    @else

                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Belum Ada
                        </span>

                    @endif

                </div>


                {{-- FOTO DIRI --}}

                <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4">

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            Foto Diri
                        </p>

                        <p class="text-xs text-slate-400">
                            Foto teknisi
                        </p>

                    </div>


                    @if($profile?->foto_diri)

                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            Tersedia
                        </span>

                    @else

                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Belum Ada
                        </span>

                    @endif

                </div>


                {{-- PORTOFOLIO --}}

                <div class="flex items-center justify-between rounded-2xl bg-slate-50 p-4">

                    <div>

                        <p class="text-sm font-semibold text-slate-800">
                            Portofolio
                        </p>

                        <p class="text-xs text-slate-400">
                            Pengalaman kerja
                        </p>

                    </div>


                    @if($profile?->portofolio)

                        <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                            Tersedia
                        </span>

                    @else

                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                            Belum Ada
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- STATUS KETERSEDIAAN --}}
        {{-- ===================================================== --}}

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        Status Ketersediaan
                    </h2>
                </div>


                <span
                    class="rounded-full px-4 py-2 text-sm font-semibold
                    {{ ($profile?->status_ketersediaan ?? 'Tersedia') === 'Tersedia'
                        ? 'bg-emerald-100 text-emerald-700'
                        : 'bg-slate-100 text-slate-600' }}"
                >
                    {{ $profile?->status_ketersediaan ?? 'Tersedia' }}
                </span>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- ULASAN --}}
        {{-- ===================================================== --}}

        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">

            <h2 class="text-lg font-bold text-slate-900">
                Ulasan Terbaru
            </h2>

            @if($reviews->isEmpty())

                <div class="py-8 text-center">

                    <p class="text-sm font-semibold text-slate-700">
                        Belum Ada Ulasan
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Ulasan pelanggan akan muncul setelah layanan selesai.
                    </p>

                </div>

            @else

                <div class="mt-5 space-y-4">

                    @foreach($reviews as $review)

                        <div class="border-b border-slate-100 pb-4 last:border-0">

                            <div class="flex items-center justify-between">

                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $review->order?->pelanggan?->nama ?? 'Pelanggan' }}
                                </p>

                                <span class="text-sm text-amber-500">
                                    ★ {{ number_format($review->rating, 1) }}
                                </span>

                            </div>

                            <p class="mt-1 text-sm text-slate-500">
                                {{ $review->ulasan }}
                            </p>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- MODAL EDIT PROFIL --}}
{{-- ============================================================= --}}

<div
    id="editProfileModal"
    class="fixed inset-0 z-50 hidden overflow-y-auto"
>

    <div
        class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm"
        onclick="closeEditProfile()"
    ></div>


    <div class="relative flex min-h-screen items-center justify-center p-5">

        <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl">


            {{-- HEADER MODAL --}}

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>

                    <h2 class="text-xl font-bold text-slate-900">
                        Edit Profil Teknisi
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Perbarui informasi profil Anda.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="closeEditProfile()"
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100 text-slate-500 hover:bg-slate-200"
                >
                    ✕
                </button>

            </div>


            {{-- ================================================= --}}
            {{-- FORM --}}
            {{-- ================================================= --}}

            <form
                action="{{ route('dashboard.teknisi.profil.update') }}"
                method="POST"
                enctype="multipart/form-data"
                class="max-h-[80vh] space-y-5 overflow-y-auto p-6"
            >

                @csrf

                @method('PUT')


                {{-- NAMA --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        value="{{ old('nama', $user->nama) }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                </div>


                {{-- EMAIL --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                </div>


                {{-- NO HP --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        No. HP
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp', $user->no_hp) }}"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                </div>


                {{-- ALAMAT --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Alamat
                    </label>

                    <textarea
                        name="alamat"
                        rows="3"
                        required
                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >{{ old('alamat', $user->alamat) }}</textarea>

                </div>


                {{-- KATEGORI --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Kategori
                    </label>

                    <select
                        name="id_kategori"
                        id="editKategori"
                        required
                        onchange="filterSubKategori()"
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                        <option value="">
                            Pilih Kategori
                        </option>


                        @foreach($kategori as $item)

                            <option
                                value="{{ $item->id_kategori }}"
                                {{ old('id_kategori', $profile?->id_kategori) == $item->id_kategori ? 'selected' : '' }}
                            >
                                {{ $item->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- KEAHLIAN --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Keahlian
                    </label>

                    <select
                        name="id_sub_kategori"
                        id="editSubKategori"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                        <option value="">
                            Pilih Keahlian
                        </option>


                        @foreach($kategori as $item)

                            @foreach($item->subCategories as $sub)

                                <option
                                    value="{{ $sub->id_sub_kategori }}"
                                    data-kategori="{{ $item->id_kategori }}"
                                    {{ old('id_sub_kategori', $profile?->id_sub_kategori) == $sub->id_sub_kategori ? 'selected' : '' }}
                                >
                                    {{ $sub->nama_sub_kategori }}
                                </option>

                            @endforeach

                        @endforeach

                    </select>

                </div>


                {{-- PENGALAMAN --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Pengalaman
                    </label>

                    <textarea
                        name="pengalaman"
                        rows="4"
                        placeholder="Contoh: Berpengalaman 3 tahun dalam perbaikan instalasi listrik rumah."
                        class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >{{ old('pengalaman', $profile?->pengalaman) }}</textarea>

                </div>


                {{-- STATUS KETERSEDIAAN --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Status Ketersediaan
                    </label>

                    <select
                        name="status_ketersediaan"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-slate-900 focus:ring-4 focus:ring-slate-100"
                    >

                        <option
                            value="Tersedia"
                            {{ old('status_ketersediaan', $profile?->status_ketersediaan) === 'Tersedia' ? 'selected' : '' }}
                        >
                            Tersedia
                        </option>

                        <option
                            value="Tidak Tersedia"
                            {{ old('status_ketersediaan', $profile?->status_ketersediaan) === 'Tidak Tersedia' ? 'selected' : '' }}
                        >
                            Tidak Tersedia
                        </option>

                    </select>

                </div>


                {{-- ================================================= --}}
                {{-- DOKUMEN --}}
                {{-- ================================================= --}}

                <div class="border-t border-slate-100 pt-5">

                    <h3 class="text-base font-bold text-slate-900">
                        Dokumen Teknisi
                    </h3>

                    <p class="mt-1 text-sm text-slate-400">
                        Kosongkan jika tidak ingin mengganti dokumen.
                    </p>

                </div>


                {{-- KTP --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        KTP
                    </label>

                    <input
                        type="file"
                        name="ktp"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm"
                    >

                    @if($profile?->ktp)

                        <p class="mt-1 text-xs text-emerald-600">
                            Dokumen KTP sudah tersedia.
                        </p>

                    @endif

                </div>


                {{-- FOTO DIRI --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Foto Diri
                    </label>

                    <input
                        type="file"
                        name="foto_diri"
                        accept=".jpg,.jpeg,.png"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm"
                    >

                    @if($profile?->foto_diri)

                        <p class="mt-1 text-xs text-emerald-600">
                            Foto diri sudah tersedia.
                        </p>

                    @endif

                </div>


                {{-- PORTOFOLIO --}}

                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Portofolio
                    </label>

                    <input
                        type="file"
                        name="portofolio"
                        accept=".jpg,.jpeg,.png,.pdf"
                        class="block w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm"
                    >

                    @if($profile?->portofolio)

                        <p class="mt-1 text-xs text-emerald-600">
                            Portofolio sudah tersedia.
                        </p>

                    @endif

                </div>


                {{-- INFO VERIFIKASI --}}

                <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3">

                    <p class="text-sm font-semibold text-amber-800">
                        Status Verifikasi
                    </p>

                    <p class="mt-1 text-xs text-amber-700">

                        {{ $profile?->status_verifikasi ?? 'Menunggu' }}

                        <br>

                        Status verifikasi hanya dapat diubah oleh Admin.

                    </p>

                </div>


                {{-- BUTTON --}}

                <div class="flex flex-col-reverse gap-3 pt-3 sm:flex-row sm:justify-end">

                    <button
                        type="button"
                        onclick="closeEditProfile()"
                        class="rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Batal
                    </button>


                    <button
                        type="submit"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800"
                    >
                        Simpan Perubahan
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

    function openEditProfile()
    {
        const modal =
            document.getElementById('editProfileModal');

        if (modal) {

            modal.classList.remove('hidden');

            document.body.classList.add('overflow-hidden');

        }

        filterSubKategori();
    }


    function closeEditProfile()
    {
        const modal =
            document.getElementById('editProfileModal');

        if (modal) {

            modal.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');

        }
    }


    function filterSubKategori()
    {
        const kategori =
            document.getElementById('editKategori');

        const subKategori =
            document.getElementById('editSubKategori');


        if (!kategori || !subKategori) {
            return;
        }


        const kategoriId =
            kategori.value;


        const options =
            subKategori.querySelectorAll('option');


        options.forEach(function(option) {

            if (!option.value) {

                option.style.display = '';

                return;

            }


            const optionKategori =
                option.dataset.kategori;


            if (optionKategori === kategoriId) {

                option.style.display = '';

            } else {

                option.style.display = 'none';

            }

        });


        const selected =
            subKategori.options[
                subKategori.selectedIndex
            ];


        if (
            selected &&
            selected.value &&
            selected.dataset.kategori !== kategoriId
        ) {

            subKategori.value = '';

        }

    }


    document.addEventListener(
        'keydown',
        function(event)
        {

            if (event.key === 'Escape') {

                closeEditProfile();

            }

        }
    );


    document.addEventListener(
        'DOMContentLoaded',
        function()
        {

            filterSubKategori();

        }
    );

</script>

@endsection