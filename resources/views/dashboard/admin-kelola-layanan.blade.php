@extends('layouts.dashboard')

@section('title', 'Kelola Layanan')

@section('content')

<div class="max-w-7xl mx-auto space-y-7">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Kelola Layanan</h1>
            <p class="text-xs text-slate-500 mt-1">Atur kategori, jenis perbaikan, dan tarif unit layanan</p>
        </div>

        <button
            type="button"
            onclick="openModal('modalTambahKategori')"
            class="inline-flex items-center justify-center gap-2
                   rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 px-5 py-3
                   text-sm font-semibold text-white
                   shadow-md transition hover:from-sky-600 hover:to-blue-700"
        >
            <svg
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path stroke-linecap="round" d="M12 5v14" />
                <path stroke-linecap="round" d="M5 12h14" />
            </svg>
            Tambah Kategori
        </button>
    </div>


    {{-- ========================================================= --}}
    {{-- SUCCESS MESSAGE --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="flex items-start gap-3 rounded-2xl
                   border border-emerald-200
                   bg-emerald-50 px-5 py-4"
        >

            <svg
                class="mt-0.5 h-5 w-5 shrink-0 text-emerald-600"
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

            <p class="text-sm font-semibold text-emerald-700">
                {{ session('success') }}
            </p>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- DAFTAR KATEGORI --}}
    {{-- ========================================================= --}}

    <div class="space-y-6">

        @forelse($kategori as $item)

            <div
                class="overflow-hidden rounded-3xl
                       border border-slate-200
                       bg-white shadow-sm"
            >

                {{-- ================================================= --}}
                {{-- HEADER KATEGORI --}}
                {{-- ================================================= --}}

                <div class="border-b border-slate-100 px-6 py-5 bg-gradient-to-r from-slate-50 to-sky-50/40">

                    <div
                        class="flex flex-col gap-4
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div class="flex items-center gap-4">

                            {{-- ICON --}}
                            <div
                                class="flex h-12 w-12 shrink-0
                                       items-center justify-center
                                       rounded-2xl bg-sky-100
                                       text-sky-600 font-bold shadow-xs"
                            >
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="1.8"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a1.996 1.996 0 00-1.022.547l-1.12 1.12a2 2 0 00.586 3.414l3.5.875a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l3.5.875a2 2 0 002.586-2.586l-1.12-1.12z"
                                    />
                                </svg>
                            </div>


                            {{-- NAMA KATEGORI --}}
                            <div>
                                <h2 class="text-lg font-bold text-slate-900">
                                    {{ $item->nama_kategori }}
                                </h2>

                                <p class="mt-0.5 text-xs text-slate-500 font-medium">
                                    {{ $item->subCategories->count() }} Sub Kategori Layanan
                                </p>
                            </div>

                        </div>


                        {{-- EDIT KATEGORI --}}

                        <button
                            type="button"
                            onclick="editKategori(
                                {{ $item->id_kategori }},
                                @js($item->nama_kategori),
                                @js($item->deskripsi)
                            )"
                            class="inline-flex items-center
                                   justify-center gap-1.5
                                   rounded-xl border
                                   border-slate-200 bg-white
                                   px-4 py-2.5
                                   text-xs font-bold
                                   text-slate-700
                                   shadow-xs transition
                                   hover:bg-slate-50
                                   hover:text-slate-900"
                        >
                            <svg
                                class="h-4 w-4 text-slate-500"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                />
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                />
                            </svg>
                            Edit Kategori
                        </button>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- SUB KATEGORI --}}
                {{-- ================================================= --}}

                <div class="p-6">

                    <div
                        class="mb-5 flex flex-col gap-3
                               sm:flex-row sm:items-center
                               sm:justify-between"
                    >

                        <div>

                            <h3 class="text-sm font-bold text-slate-800">
                                Sub Kategori Layanan
                            </h3>

                            <p class="mt-1 text-xs text-slate-400">
                                Jenis layanan yang tersedia dalam kategori ini
                            </p>

                        </div>


                        {{-- TAMBAH SUB KATEGORI --}}

                        <button
                            type="button"
                            onclick="tambahSubKategori(
                                {{ $item->id_kategori }},
                                @js($item->nama_kategori)
                            )"
                            class="inline-flex items-center
                                   justify-center gap-2
                                   rounded-xl bg-slate-900
                                   px-4 py-2.5
                                   text-xs font-semibold text-white
                                   transition hover:bg-slate-800"
                        >

                            <svg
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
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

                            Tambah Sub Kategori

                        </button>

                    </div>


                    {{-- DATA SUB KATEGORI --}}

                    @if($item->subCategories->count() > 0)

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                            @foreach($item->subCategories as $sub)

                                <div
                                    class="rounded-xl border
                                           border-slate-200
                                           bg-white p-5
                                           transition
                                           hover:border-slate-300
                                           hover:shadow-sm"
                                >

                                    <div
                                        class="flex items-start
                                               justify-between gap-4"
                                    >

                                        <div class="min-w-0">

                                            {{-- NAMA LAYANAN --}}

                                            <h4
                                                class="font-semibold
                                                       text-slate-900"
                                            >
                                                {{ $sub->nama_sub_kategori }}
                                            </h4>


                                            {{-- HARGA --}}

                                            <div class="mt-3">

                                                <p
                                                    class="text-xs
                                                           text-slate-400"
                                                >
                                                    Harga per unit
                                                </p>

                                                <p
                                                    class="mt-1 text-sm
                                                           font-bold
                                                           text-slate-800"
                                                >
                                                    Rp
                                                    {{ number_format(
                                                        $sub->harga_per_unit ?? 0,
                                                        0,
                                                        ',',
                                                        '.'
                                                    ) }}
                                                </p>

                                            </div>


                                            {{-- DESKRIPSI --}}

                                            @if($sub->deskripsi)

                                                <p
                                                    class="mt-3 text-xs
                                                           leading-relaxed
                                                           text-slate-400"
                                                >
                                                    {{ $sub->deskripsi }}
                                                </p>

                                            @endif

                                        </div>


                                        {{-- EDIT SUB KATEGORI --}}

                                        <button
                                            type="button"
                                            onclick="editSubKategori(
                                                {{ $sub->id_sub_kategori }},
                                                {{ $item->id_kategori }},
                                                @js($sub->nama_sub_kategori),
                                                @js($sub->harga_per_unit),
                                                @js($sub->deskripsi)
                                            )"
                                            class="flex h-9 w-9 shrink-0
                                                   items-center justify-center
                                                   rounded-lg border
                                                   border-slate-200
                                                   text-slate-500
                                                   transition
                                                   hover:bg-slate-50
                                                   hover:text-slate-900"
                                            title="Edit layanan"
                                        >

                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                                />

                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                                />
                                            </svg>

                                        </button>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div
                            class="rounded-xl border border-dashed
                                   border-slate-200 px-6 py-10
                                   text-center"
                        >

                            <p class="text-sm text-slate-400">
                                Belum ada sub kategori layanan.
                            </p>

                            <button
                                type="button"
                                onclick="tambahSubKategori(
                                    {{ $item->id_kategori }},
                                    @js($item->nama_kategori)
                                )"
                                class="mt-3 text-sm font-semibold
                                       text-slate-700
                                       hover:text-slate-900"
                            >
                                + Tambah Sub Kategori
                            </button>

                        </div>

                    @endif

                </div>

            </div>

        @empty

            {{-- TIDAK ADA DATA --}}

            <div
                class="rounded-2xl border border-dashed
                       border-slate-300 bg-white
                       px-6 py-14 text-center"
            >

                <div
                    class="mx-auto flex h-14 w-14
                           items-center justify-center
                           rounded-2xl bg-slate-100
                           text-slate-400"
                >

                    <svg
                        class="h-7 w-7"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>

                </div>

                <h3 class="mt-4 text-sm font-bold text-slate-800">
                    Belum ada kategori layanan
                </h3>

                <p class="mt-1 text-sm text-slate-400">
                    Tambahkan kategori untuk mulai mengelola layanan.
                </p>

                <button
                    type="button"
                    onclick="openModal('modalTambahKategori')"
                    class="mt-5 rounded-xl bg-slate-900
                           px-5 py-2.5 text-sm font-semibold
                           text-white hover:bg-slate-800"
                >
                    Tambah Kategori
                </button>

            </div>

        @endforelse

    </div>

</div>



{{-- ============================================================= --}}
{{-- MODAL TAMBAH KATEGORI --}}
{{-- ============================================================= --}}

<div
    id="modalTambahKategori"
    class="fixed inset-0 z-[100] hidden
           items-center justify-center
           bg-slate-900/50 p-5"
>

    <div
        class="w-full max-w-lg overflow-hidden
               rounded-2xl bg-white shadow-2xl"
    >

        <div
            class="flex items-center justify-between
                   border-b border-slate-100 px-6 py-5"
        >

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Tambah Kategori
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Tambahkan kategori layanan baru
                </p>

            </div>

            <button
                type="button"
                onclick="closeModal('modalTambahKategori')"
                class="flex h-9 w-9 items-center
                       justify-center rounded-lg
                       text-slate-400
                       hover:bg-slate-100
                       hover:text-slate-700"
            >
                ✕
            </button>

        </div>


        <form
            action="{{ route('admin.kategori.store') }}"
            method="POST"
            class="space-y-5 p-6"
        >

            @csrf

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Nama Kategori
                </label>

                <input
                    type="text"
                    name="nama_kategori"
                    required
                    maxlength="100"
                    placeholder="Contoh: Kelistrikan"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none transition
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

            </div>


            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Deskripsi

                    <span class="font-normal text-slate-400">
                        (opsional)
                    </span>

                </label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    placeholder="Deskripsi kategori layanan..."
                    class="w-full resize-none rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none transition
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                ></textarea>

            </div>


            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeModal('modalTambahKategori')"
                    class="rounded-xl border
                           border-slate-200
                           px-5 py-2.5
                           text-sm font-semibold
                           text-slate-600
                           hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900
                           px-5 py-2.5
                           text-sm font-semibold
                           text-white
                           hover:bg-slate-800"
                >
                    Simpan Kategori
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ============================================================= --}}
{{-- MODAL EDIT KATEGORI --}}
{{-- ============================================================= --}}

<div
    id="modalEditKategori"
    class="fixed inset-0 z-[100] hidden
           items-center justify-center
           bg-slate-900/50 p-5"
>

    <div
        class="w-full max-w-lg overflow-hidden
               rounded-2xl bg-white shadow-2xl"
    >

        <div
            class="flex items-center justify-between
                   border-b border-slate-100 px-6 py-5"
        >

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Edit Kategori
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Perbaiki nama atau deskripsi kategori
                </p>

            </div>

            <button
                type="button"
                onclick="closeModal('modalEditKategori')"
                class="flex h-9 w-9 items-center
                       justify-center rounded-lg
                       text-slate-400
                       hover:bg-slate-100"
            >
                ✕
            </button>

        </div>


        <form
            id="formEditKategori"
            method="POST"
            class="space-y-5 p-6"
        >

            @csrf
            @method('PUT')

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Nama Kategori
                </label>

                <input
                    id="editNamaKategori"
                    type="text"
                    name="nama_kategori"
                    required
                    maxlength="100"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

            </div>


            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Deskripsi
                </label>

                <textarea
                    id="editDeskripsiKategori"
                    name="deskripsi"
                    rows="3"
                    class="w-full resize-none rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                ></textarea>

            </div>


            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeModal('modalEditKategori')"
                    class="rounded-xl border
                           border-slate-200
                           px-5 py-2.5
                           text-sm font-semibold
                           text-slate-600
                           hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900
                           px-5 py-2.5
                           text-sm font-semibold
                           text-white
                           hover:bg-slate-800"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ============================================================= --}}
{{-- MODAL TAMBAH SUB KATEGORI --}}
{{-- ============================================================= --}}

<div
    id="modalTambahSubKategori"
    class="fixed inset-0 z-[100] hidden
           items-center justify-center
           bg-slate-900/50 p-5"
>

    <div
        class="w-full max-w-lg overflow-hidden
               rounded-2xl bg-white shadow-2xl"
    >

        <div
            class="flex items-center justify-between
                   border-b border-slate-100 px-6 py-5"
        >

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Tambah Sub Kategori
                </h2>

                <p
                    id="namaKategoriSub"
                    class="mt-1 text-xs text-slate-400"
                ></p>

            </div>

            <button
                type="button"
                onclick="closeModal('modalTambahSubKategori')"
                class="flex h-9 w-9 items-center
                       justify-center rounded-lg
                       text-slate-400
                       hover:bg-slate-100"
            >
                ✕
            </button>

        </div>


        <form
            action="{{ route('admin.subkategori.store') }}"
            method="POST"
            class="space-y-5 p-6"
        >

            @csrf

            <input
                id="idKategoriSub"
                type="hidden"
                name="id_kategori"
            >


            {{-- NAMA SUB KATEGORI --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Nama Sub Kategori
                </label>

                <input
                    type="text"
                    name="nama_sub_kategori"
                    required
                    maxlength="100"
                    placeholder="Contoh: Instalasi Saklar"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

            </div>


            {{-- HARGA PER UNIT --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Harga per Unit
                </label>

                {{-- TANPA Rp DI DALAM INPUT --}}

                <input
                    type="number"
                    name="harga_per_unit"
                    required
                    min="0"
                    step="1000"
                    placeholder="250000"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

                <p class="mt-1.5 text-xs text-slate-400">
                    Masukkan harga dalam angka tanpa Rp atau titik.
                </p>

            </div>


            {{-- DESKRIPSI --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Deskripsi

                    <span class="font-normal text-slate-400">
                        (opsional)
                    </span>

                </label>

                <textarea
                    name="deskripsi"
                    rows="3"
                    placeholder="Deskripsi layanan..."
                    class="w-full resize-none rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                ></textarea>

            </div>


            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeModal('modalTambahSubKategori')"
                    class="rounded-xl border
                           border-slate-200
                           px-5 py-2.5
                           text-sm font-semibold
                           text-slate-600
                           hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900
                           px-5 py-2.5
                           text-sm font-semibold
                           text-white
                           hover:bg-slate-800"
                >
                    Simpan Layanan
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ============================================================= --}}
{{-- MODAL EDIT SUB KATEGORI --}}
{{-- ============================================================= --}}

<div
    id="modalEditSubKategori"
    class="fixed inset-0 z-[100] hidden
           items-center justify-center
           bg-slate-900/50 p-5"
>

    <div
        class="w-full max-w-lg overflow-hidden
               rounded-2xl bg-white shadow-2xl"
    >

        <div
            class="flex items-center justify-between
                   border-b border-slate-100 px-6 py-5"
        >

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Edit Sub Kategori
                </h2>

                <p class="mt-1 text-xs text-slate-400">
                    Perbaiki nama, harga, atau deskripsi layanan
                </p>

            </div>

            <button
                type="button"
                onclick="closeModal('modalEditSubKategori')"
                class="flex h-9 w-9 items-center
                       justify-center rounded-lg
                       text-slate-400
                       hover:bg-slate-100"
            >
                ✕
            </button>

        </div>


        <form
            id="formEditSubKategori"
            method="POST"
            class="space-y-5 p-6"
        >

            @csrf
            @method('PUT')

            <input
                id="editIdKategoriSub"
                type="hidden"
                name="id_kategori"
            >


            {{-- NAMA SUB KATEGORI --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Nama Sub Kategori
                </label>

                <input
                    id="editNamaSubKategori"
                    type="text"
                    name="nama_sub_kategori"
                    required
                    maxlength="100"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

            </div>


            {{-- HARGA PER UNIT --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Harga per Unit
                </label>

                {{-- TANPA Rp DI DALAM INPUT --}}

                <input
                    id="editHargaSubKategori"
                    type="number"
                    name="harga_per_unit"
                    required
                    min="0"
                    step="1000"
                    placeholder="250000"
                    class="w-full rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                >

                <p class="mt-1.5 text-xs text-slate-400">
                    Masukkan harga dalam angka tanpa Rp atau titik.
                </p>

            </div>


            {{-- DESKRIPSI --}}

            <div>

                <label
                    class="mb-2 block text-sm
                           font-semibold text-slate-700"
                >
                    Deskripsi
                </label>

                <textarea
                    id="editDeskripsiSubKategori"
                    name="deskripsi"
                    rows="3"
                    class="w-full resize-none rounded-xl
                           border border-slate-200
                           px-4 py-3
                           text-sm text-slate-800
                           outline-none
                           focus:border-slate-900
                           focus:ring-1 focus:ring-slate-900"
                ></textarea>

            </div>


            <div class="flex justify-end gap-3 pt-2">

                <button
                    type="button"
                    onclick="closeModal('modalEditSubKategori')"
                    class="rounded-xl border
                           border-slate-200
                           px-5 py-2.5
                           text-sm font-semibold
                           text-slate-600
                           hover:bg-slate-50"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="rounded-xl bg-slate-900
                           px-5 py-2.5
                           text-sm font-semibold
                           text-white
                           hover:bg-slate-800"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>



{{-- ============================================================= --}}
{{-- JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | OPEN MODAL
    |--------------------------------------------------------------------------
    */

    function openModal(id)
    {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | CLOSE MODAL
    |--------------------------------------------------------------------------
    */

    function closeModal(id)
    {
        const modal = document.getElementById(id);

        if (!modal) {
            return;
        }

        modal.classList.add('hidden');
        modal.classList.remove('flex');

        document.body.classList.remove('overflow-hidden');
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT KATEGORI
    |--------------------------------------------------------------------------
    */

    function editKategori(id, nama, deskripsi)
    {
        const form =
            document.getElementById('formEditKategori');

        const namaInput =
            document.getElementById('editNamaKategori');

        const deskripsiInput =
            document.getElementById('editDeskripsiKategori');


        if (!form || !namaInput || !deskripsiInput) {
            return;
        }


        form.action =
            "{{ url('/dashboard/admin/kategori') }}/" + id;


        namaInput.value =
            nama ?? '';


        deskripsiInput.value =
            deskripsi ?? '';


        openModal('modalEditKategori');
    }


    /*
    |--------------------------------------------------------------------------
    | TAMBAH SUB KATEGORI
    |--------------------------------------------------------------------------
    */

    function tambahSubKategori(id, nama)
    {
        const idInput =
            document.getElementById('idKategoriSub');

        const namaKategori =
            document.getElementById('namaKategoriSub');


        if (!idInput || !namaKategori) {
            return;
        }


        idInput.value = id;


        namaKategori.textContent =
            'Kategori: ' + nama;


        openModal('modalTambahSubKategori');
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT SUB KATEGORI
    |--------------------------------------------------------------------------
    */

    function editSubKategori(
        idSub,
        idKategori,
        nama,
        harga,
        deskripsi
    )
    {
        const form =
            document.getElementById('formEditSubKategori');

        const idKategoriInput =
            document.getElementById('editIdKategoriSub');

        const namaInput =
            document.getElementById('editNamaSubKategori');

        const hargaInput =
            document.getElementById('editHargaSubKategori');

        const deskripsiInput =
            document.getElementById('editDeskripsiSubKategori');


        if (
            !form ||
            !idKategoriInput ||
            !namaInput ||
            !hargaInput ||
            !deskripsiInput
        ) {
            return;
        }


        form.action =
            "{{ url('/dashboard/admin/sub-kategori') }}/" + idSub;


        idKategoriInput.value =
            idKategori;


        namaInput.value =
            nama ?? '';


        /*
        | Harga langsung dimasukkan sebagai angka.
        | Tidak ada prefix "Rp".
        */

        hargaInput.value =
            harga ?? '';


        deskripsiInput.value =
            deskripsi ?? '';


        openModal('modalEditSubKategori');
    }


    /*
    |--------------------------------------------------------------------------
    | TUTUP MODAL KETIKA KLIK BACKDROP
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function(event)
        {
            const modalIds = [
                'modalTambahKategori',
                'modalEditKategori',
                'modalTambahSubKategori',
                'modalEditSubKategori'
            ];


            modalIds.forEach(
                function(id)
                {
                    const modal =
                        document.getElementById(id);


                    if (
                        modal &&
                        event.target === modal
                    ) {
                        closeModal(id);
                    }
                }
            );
        }
    );


    /*
    |--------------------------------------------------------------------------
    | TUTUP MODAL DENGAN ESCAPE
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function(event)
        {
            if (event.key !== 'Escape') {
                return;
            }


            const modalIds = [
                'modalTambahKategori',
                'modalEditKategori',
                'modalTambahSubKategori',
                'modalEditSubKategori'
            ];


            modalIds.forEach(
                function(id)
                {
                    closeModal(id);
                }
            );
        }
    );

</script>

@endsection