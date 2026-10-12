@extends('layouts.dashboard')

@section('title', 'Pesan Layanan')

@section('content')

<div class="max-w-7xl mx-auto">
    <form
        action="{{ route('order.store') }}"
        method="POST"
        enctype="multipart/form-data">

        @csrf


        {{-- ===================================================== --}}
        {{-- CARD BESAR --}}
        {{-- ===================================================== --}}

        <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8">


            {{-- ================================================= --}}
            {{-- PILIH KATEGORI --}}
            {{-- ================================================= --}}

            <div class="flex items-center justify-between mb-8">

                <h2 class="text-lg font-bold text-slate-800">
                    Pilih Kategori Layanan
                </h2>

                <span class="text-slate-400 text-sm">
                    {{ count($kategori) }} Kategori
                </span>

            </div>


            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">

                @foreach($kategori as $item)

                    <label class="cursor-pointer group relative">

                        <input
                            type="radio"
                            name="id_kategori"
                            value="{{ $item->id_kategori }}"
                            class="hidden peer"
                            data-sub='@json($item->subCategories)'>

                        {{-- SELECTION INDICATOR BADGE --}}
                        <div class="absolute top-3 right-3 w-6 h-6 rounded-full bg-sky-600 text-white opacity-0 peer-checked:opacity-100 scale-75 peer-checked:scale-100 transition-all duration-200 flex items-center justify-center z-10 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                        </div>

                        <div
                            class="rounded-2xl
                                   border
                                   border-slate-200
                                   bg-white
                                   p-5
                                   h-44
                                   flex
                                   flex-col
                                   justify-between
                                   items-center
                                   text-center
                                   transition-all
                                   duration-300
                                   hover:-translate-y-1
                                   hover:border-sky-400
                                   hover:shadow-lg
                                   hover:shadow-sky-500/10
                                   peer-checked:bg-sky-50/70
                                   peer-checked:border-sky-500
                                   peer-checked:ring-2
                                   peer-checked:ring-sky-500/20
                                   peer-checked:shadow-md">


                            {{-- ================================================= --}}
                            {{-- ICON KATEGORI --}}
                            {{-- ================================================= --}}

                            @if($item->nama_kategori == "Kelistrikan")

                                <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-amber-500 group-hover:text-white transition duration-300 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                    </svg>
                                </div>

                            @elseif($item->nama_kategori == "Perawatan AC")

                                <div class="w-14 h-14 rounded-2xl bg-sky-50 text-sky-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-sky-500 group-hover:text-white transition duration-300 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                    </svg>
                                </div>

                            @elseif($item->nama_kategori == "Plumbing" || $item->nama_kategori == "Perbaikan Plumbing")

                                <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center group-hover:scale-110 group-hover:bg-cyan-500 group-hover:text-white transition duration-300 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918" />
                                    </svg>
                                </div>

                            @elseif($item->nama_kategori == "Perbaikan Bangunan")

                                <div class="w-14 h-14 rounded-2xl bg-orange-50 text-orange-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition duration-300 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                    </svg>
                                </div>

                            @else

                                <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center group-hover:scale-110 group-hover:bg-indigo-500 group-hover:text-white transition duration-300 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 11-3.586-3.586l5.654-4.654m.569-.569L13.12 7.07c.384-.317.626-.74.766-1.208m-5.8 5.8a4.5 4.5 0 00-6.364 0" />
                                    </svg>
                                </div>

                            @endif


                            <div class="mt-2">
                                <span class="font-bold text-sm text-slate-800 leading-snug block group-hover:text-sky-600 transition">
                                    {{ $item->nama_kategori }}
                                </span>
                                <span class="text-[11px] text-slate-400 font-medium block mt-0.5">
                                    Pilih Layanan
                                </span>
                            </div>

                        </div>

                    </label>

                @endforeach

            </div>


            <hr class="my-10">


            {{-- ===================================================== --}}
            {{-- INFORMASI LAYANAN --}}
            {{-- ===================================================== --}}

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">


                {{-- ================================================= --}}
                {{-- KIRI --}}
                {{-- ================================================= --}}

                <div>


                    {{-- SUB KATEGORI --}}

                    <div class="mb-7">

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Sub Kategori

                        </label>


                        <select
                            id="subKategori"
                            name="id_sub_kategori"
                            required
                            class="w-full
                                   rounded-2xl
                                   border
                                   border-slate-300
                                   bg-white
                                   px-5
                                   py-3
                                   focus:border-sky-500
                                   focus:ring-4
                                   focus:ring-sky-100
                                   outline-none
                                   transition">

                            <option value="">
                                Pilih kategori terlebih dahulu
                            </option>

                        </select>

                    </div>


                    {{-- JUMLAH UNIT --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Jumlah Unit

                        </label>


                        <input
                            id="jumlah"
                            type="number"
                            name="jumlah_unit"
                            min="1"
                            placeholder="Masukkan jumlah unit"
                            required
                            class="w-full
                                   rounded-2xl
                                   border
                                   border-slate-300
                                   px-5
                                   py-3
                                   focus:border-sky-500
                                   focus:ring-4
                                   focus:ring-sky-100
                                   outline-none">

                    </div>


                    {{-- LOKASI --}}

                    <div class="mt-7">

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Lokasi

                        </label>


                        <input
                            type="text"
                            name="alamat"
                            required
                            placeholder="Masukkan alamat lengkap"
                            class="w-full
                                   rounded-2xl
                                   border
                                   border-slate-300
                                   px-5
                                   py-3
                                   focus:border-sky-500
                                   focus:ring-4
                                   focus:ring-sky-100
                                   outline-none">

                    </div>


                    {{-- JADWAL --}}

                    <div class="mt-7">

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Jadwal Pengerjaan

                        </label>


                        <input
                            type="datetime-local"
                            name="jadwal"
                            required
                            class="w-full
                                   rounded-2xl
                                   border
                                   border-slate-300
                                   px-5
                                   py-3
                                   focus:border-sky-500
                                   focus:ring-4
                                   focus:ring-sky-100
                                   outline-none">

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- KANAN --}}
                {{-- ================================================= --}}

                <div>


                    {{-- DESKRIPSI --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Deskripsi Kerusakan

                        </label>


                        <textarea
                            name="deskripsi_kerusakan"
                            rows="5"
                            required
                            placeholder="Contoh : AC tidak dingin, mengeluarkan suara berisik..."
                            class="w-full
                                   rounded-2xl
                                   border
                                   border-slate-300
                                   px-5
                                   py-3
                                   resize-none
                                   focus:border-sky-500
                                   focus:ring-4
                                   focus:ring-sky-100
                                   outline-none"></textarea>

                    </div>


                    {{-- FOTO KERUSAKAN --}}

                    <div class="mt-5">

                        <label
                            class="block
                                   text-sm
                                   font-semibold
                                   text-slate-700
                                   mb-3">

                            Foto Kerusakan

                        </label>


                        <label
                            class="cursor-pointer
                                   h-48
                                   rounded-3xl
                                   border-2
                                   border-dashed
                                   border-slate-300
                                   bg-slate-50
                                   hover:bg-sky-50
                                   hover:border-sky-500
                                   transition
                                   flex
                                   flex-col
                                   justify-center
                                   items-center">


                            <div
                                class="w-20
                                       h-20
                                       rounded-full
                                       bg-sky-100
                                       flex
                                       items-center
                                       justify-center
                                       mb-5">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="w-10 h-10 text-sky-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24">

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 4v16m8-8H4"/>

                                </svg>

                            </div>


                            <div
                                id="namaFile"
                                class="font-semibold text-slate-700">

                                Klik untuk upload foto

                            </div>


                            <div
                                class="text-sm
                                       text-slate-400
                                       mt-2">

                                JPG, JPEG, PNG • Maksimal 2 MB

                            </div>


                            <input
                                id="foto"
                                type="file"
                                name="foto_kerusakan"
                                accept="image/*"
                                class="hidden">

                        </label>

                    </div>

                </div>

            </div>


            <hr class="my-10">


            {{-- ===================================================== --}}
            {{-- BIAYA + METODE PEMBAYARAN --}}
            {{-- ===================================================== --}}

            <div
                class="grid
                       grid-cols-1
                       md:grid-cols-2
                       gap-0
                       bg-sky-50
                       border
                       border-sky-100
                       rounded-2xl
                       overflow-hidden">


                {{-- ================================================= --}}
                {{-- BIAYA --}}
                {{-- ================================================= --}}

                <div class="px-6 py-5">

                    <h3
                        class="text-xl
                               font-bold
                               text-slate-800
                               mb-5">

                        Biaya

                    </h3>


                    <div class="space-y-3">


                        {{-- HARGA / UNIT --}}

                        <div
                            class="flex
                                   items-center
                                   justify-between">

                            <span class="text-sm text-slate-500">

                                Harga / Unit

                            </span>


                            <span
                                id="harga-per-unit"
                                class="text-sm
                                       font-semibold
                                       text-slate-800">

                                -

                            </span>

                        </div>


                        {{-- JUMLAH UNIT --}}

                        <div
                            class="flex
                                   items-center
                                   justify-between">

                            <span class="text-sm text-slate-500">

                                Jumlah Unit

                            </span>


                            <span
                                id="jumlah-unit-display"
                                class="text-sm
                                       font-semibold
                                       text-slate-800">

                                -

                            </span>

                        </div>


                        {{-- TOTAL --}}

                        <div
                            class="border-t
                                   border-slate-200
                                   pt-3
                                   mt-3">

                            <div
                                class="flex
                                       items-center
                                       justify-between">

                                <span
                                    class="text-base
                                           font-bold
                                           text-slate-800">

                                    Total Biaya

                                </span>


                                <span
                                    id="total-biaya"
                                    class="text-lg
                                           font-bold
                                           text-sky-600">

                                    -

                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- METODE PEMBAYARAN --}}
                {{-- ================================================= --}}

                <div
                    class="px-6
                           py-5
                           border-t
                           md:border-t-0
                           md:border-l
                           border-sky-100">


                    <h3
                        class="text-xl
                               font-bold
                               text-slate-800
                               mb-5">

                        Metode Pembayaran

                    </h3>


                    <div class="space-y-3">


                        {{-- ================================================= --}}
                        {{-- PEMBAYARAN ONLINE --}}
                        {{-- ================================================= --}}

                        <label
                            class="flex
                                   items-center
                                   gap-3.5
                                   p-4
                                   rounded-2xl
                                   bg-white
                                   border
                                   border-slate-200
                                   cursor-pointer
                                   hover:border-sky-500
                                   hover:bg-sky-50/50
                                   transition
                                   group shadow-xs">


                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="qris"
                                required
                                class="w-4
                                       h-4
                                       text-sky-600
                                       border-slate-300
                                       focus:ring-sky-500">

                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-9 h-9 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                                        <path stroke-linecap="round" d="M3 10h18"/>
                                        <path stroke-linecap="round" d="M7 15h4"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-sky-700 transition">
                                        Pembayaran Online
                                    </p>
                                </div>
                            </div>
                        </label>


                        {{-- ================================================= --}}
                        {{-- TUNAI --}}
                        {{-- ================================================= --}}

                        <label
                            class="flex
                                   items-center
                                   gap-3.5
                                   p-4
                                   rounded-2xl
                                   bg-white
                                   border
                                   border-slate-200
                                   cursor-pointer
                                   hover:border-emerald-500
                                   hover:bg-emerald-50/50
                                   transition
                                   group shadow-xs">


                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="tunai"
                                class="w-4
                                       h-4
                                       text-sky-600
                                       border-slate-300
                                       focus:ring-sky-500">

                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-9h6a2 2 0 010 4H9a2 2 0 000 4h6" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 transition">
                                        Tunai
                                    </p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>


            {{-- ===================================================== --}}
            {{-- BUTTON PESAN --}}
            {{-- ===================================================== --}}

            <div class="mt-6 flex justify-end">

                <button
                    type="submit"
                    class="px-8
                           py-3
                           rounded-xl
                           bg-gradient-to-r
                           from-sky-500
                           to-blue-600
                           hover:from-sky-600
                           hover:to-blue-700
                           text-white
                           font-semibold
                           shadow-md
                           transition">

                    Pesan Sekarang

                </button>

            </div>

        </div>

    </form>

</div>


{{-- ===================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ===================================================== --}}

<script>

document.addEventListener('DOMContentLoaded', function () {


    /* =====================================================
       ELEMENT
    ===================================================== */

    const kategori =
        document.querySelectorAll(
            'input[name="id_kategori"]'
        );

    const subKategori =
        document.getElementById(
            'subKategori'
        );

    const jumlah =
        document.getElementById(
            'jumlah'
        );

    const hargaDisplay =
        document.getElementById(
            'harga-per-unit'
        );

    const jumlahDisplay =
        document.getElementById(
            'jumlah-unit-display'
        );

    const totalDisplay =
        document.getElementById(
            'total-biaya'
        );

    const foto =
        document.getElementById(
            'foto'
        );

    const namaFile =
        document.getElementById(
            'namaFile'
        );


    /* =====================================================
       HARGA PER UNIT
       Nilai ini berasal dari database melalui
       data-sub pada kategori.
    ===================================================== */

    let hargaPerUnit = 0;


    /* =====================================================
       FORMAT RUPIAH
    ===================================================== */

    function formatRupiah(angka)
    {
        return 'Rp ' +
            Number(angka).toLocaleString('id-ID');
    }


    /* =====================================================
       RESET BIAYA
    ===================================================== */

    function resetBiaya()
    {
        hargaDisplay.textContent = '-';

        jumlahDisplay.textContent = '-';

        totalDisplay.textContent = '-';
    }

    function hitungBiaya()
    {

        const jml =
            parseInt(jumlah.value) || 0;


        if (
            hargaPerUnit <= 0 ||
            jml <= 0
        ) {

            resetBiaya();

            return;
        }

        hargaDisplay.textContent =
            formatRupiah(
                hargaPerUnit
            );

        jumlahDisplay.textContent =
            jml;


        const total =
            hargaPerUnit * jml;


        totalDisplay.textContent =
            formatRupiah(total);

    }


    kategori.forEach(function (item) {

        item.addEventListener(
            'change',
            function () {

                let data = [];

                try {

                    data =
                        JSON.parse(
                            this.dataset.sub
                        );

                } catch (error) {

                    console.error(
                        'Data subkategori tidak valid:',
                        error
                    );

                    data = [];

                }

                subKategori.innerHTML = `
                    <option value="">
                        Pilih Sub Kategori
                    </option>
                `;

                data.forEach(
                    function (sub) {

                        const option =
                            document.createElement(
                                'option'
                            );


                        option.value =
                            sub.id_sub_kategori;


                        option.textContent =
                            sub.nama_sub_kategori;

                        option.dataset.harga =
                            sub.harga_per_unit;


                        subKategori.appendChild(
                            option
                        );

                    }
                );

                hargaPerUnit = 0;

                jumlah.value = '';

                resetBiaya();

            }
        );

    });

    subKategori.addEventListener(
        'change',
        function () {


            const selected =
                this.options[
                    this.selectedIndex
                ];

            if (
                !selected ||
                !selected.value
            ) {

                hargaPerUnit = 0;

                resetBiaya();

                return;
            }

            hargaPerUnit =
                parseFloat(
                    selected.dataset.harga
                ) || 0;
            hitungBiaya();

        }
    );

    jumlah.addEventListener(
        'input',
        function () {

            hitungBiaya();

        }
    );


    foto.addEventListener(
        'change',
        function () {

            if (
                this.files &&
                this.files.length > 0
            ) {

                namaFile.textContent =
                    this.files[0].name;

            } else {

                namaFile.textContent =
                    'Klik untuk upload foto';

            }

        }
    );


});

</script>

@endsection