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

                    <label class="cursor-pointer">

                        <input
                            type="radio"
                            name="id_kategori"
                            value="{{ $item->id_kategori }}"
                            class="hidden peer"
                            data-sub='@json($item->subCategories)'>


                        <div
                            class="rounded-2xl
                                   border-2
                                   border-slate-200
                                   bg-white
                                   h-48
                                   flex
                                   flex-col
                                   justify-center
                                   items-center
                                   transition-all
                                   duration-300
                                   hover:border-sky-500
                                   hover:shadow-xl
                                   peer-checked:bg-sky-500
                                   peer-checked:border-sky-500
                                   peer-checked:text-white">


                            {{-- ================================================= --}}
                            {{-- ICON KATEGORI --}}
                            {{-- ================================================= --}}

                            @if($item->nama_kategori == "Kelistrikan")

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-yellow-100
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           mb-5">

                                    ⚡

                                </div>


                            @elseif($item->nama_kategori == "Perawatan AC")

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-sky-100
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           mb-5">

                                    ❄️

                                </div>


                            @elseif(
                                $item->nama_kategori == "Plumbing" ||
                                $item->nama_kategori == "Perbaikan Plumbing"
                            )

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-cyan-100
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           mb-5">

                                    🚰

                                </div>


                            @elseif($item->nama_kategori == "Perbaikan Bangunan")

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-orange-100
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           mb-5">

                                    🏠

                                </div>


                            @else

                                <div
                                    class="w-16 h-16
                                           rounded-2xl
                                           bg-gray-100
                                           flex
                                           items-center
                                           justify-center
                                           text-xl
                                           mb-5">

                                    🔧

                                </div>

                            @endif


                            <span
                                class="font-semibold
                                       text-center
                                       px-3
                                       leading-6">

                                {{ $item->nama_kategori }}

                            </span>

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
                        {{-- QRIS --}}
                        {{-- ================================================= --}}

                        <label
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   bg-white
                                   border
                                   border-slate-200
                                   cursor-pointer
                                   hover:border-sky-400
                                   hover:bg-sky-50
                                   transition">


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

                            <div>
                                <p
                                    class="text-sm
                                           font-semibold
                                           text-slate-800">
                                    QRIS
                                </p>
                            </div>
                        </label>


                        {{-- ================================================= --}}
                        {{-- TUNAI --}}
                        {{-- ================================================= --}}

                        <label
                            class="flex
                                   items-center
                                   gap-3
                                   p-3
                                   rounded-xl
                                   bg-white
                                   border
                                   border-slate-200
                                   cursor-pointer
                                   hover:border-sky-400
                                   hover:bg-sky-50
                                   transition">


                            <input
                                type="radio"
                                name="metode_pembayaran"
                                value="tunai"
                                class="w-4
                                       h-4
                                       text-sky-600
                                       border-slate-300
                                       focus:ring-sky-500">

                            <div>
                                <p
                                    class="text-sm
                                           font-semibold
                                           text-slate-800">
                                    Tunai
                                </p>
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


    /* =====================================================
       HITUNG BIAYA
    ===================================================== */

    function hitungBiaya()
    {

        const jml =
            parseInt(jumlah.value) || 0;


        /*
         * Jika subkategori belum dipilih
         * atau jumlah unit belum diisi
         */

        if (
            hargaPerUnit <= 0 ||
            jml <= 0
        ) {

            resetBiaya();

            return;
        }


        /*
         * Tampilkan harga/unit
         */

        hargaDisplay.textContent =
            formatRupiah(
                hargaPerUnit
            );


        /*
         * Tampilkan jumlah unit
         */

        jumlahDisplay.textContent =
            jml;


        /*
         * Hitung total
         */

        const total =
            hargaPerUnit * jml;


        totalDisplay.textContent =
            formatRupiah(total);

    }


    /* =====================================================
       PILIH KATEGORI
    ===================================================== */

    kategori.forEach(function (item) {

        item.addEventListener(
            'change',
            function () {


                /*
                 * Ambil data subkategori
                 * dari database.
                 */

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


                /*
                 * Kosongkan dropdown
                 */

                subKategori.innerHTML = `
                    <option value="">
                        Pilih Sub Kategori
                    </option>
                `;


                /*
                 * Masukkan subkategori
                 */

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


                        /*
                         * Harga berasal dari
                         * database.
                         */

                        option.dataset.harga =
                            sub.harga_per_unit;


                        subKategori.appendChild(
                            option
                        );

                    }
                );


                /*
                 * Reset harga
                 */

                hargaPerUnit = 0;

                jumlah.value = '';

                resetBiaya();

            }
        );

    });


    /* =====================================================
       PILIH SUB KATEGORI
    ===================================================== */

    subKategori.addEventListener(
        'change',
        function () {


            const selected =
                this.options[
                    this.selectedIndex
                ];


            /*
             * Jika belum memilih subkategori
             */

            if (
                !selected ||
                !selected.value
            ) {

                hargaPerUnit = 0;

                resetBiaya();

                return;
            }


            /*
             * Ambil harga dari database
             */

            hargaPerUnit =
                parseFloat(
                    selected.dataset.harga
                ) || 0;


            /*
             * Hitung biaya
             */

            hitungBiaya();

        }
    );


    /* =====================================================
       JUMLAH UNIT
    ===================================================== */

    jumlah.addEventListener(
        'input',
        function () {

            hitungBiaya();

        }
    );


    /* =====================================================
       UPLOAD FOTO
    ===================================================== */

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