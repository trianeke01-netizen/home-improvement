<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Home Improvement</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script
        defer
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js">
    </script>

    <style>
        :root {
            --ink: #111827;
            --brick: #C1502E;
        }

        body {
            font-family:
                -apple-system,
                BlinkMacSystemFont,
                'Segoe UI',
                Roboto,
                sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Hilangkan ikon password bawaan browser */
        input[type="password"]::-webkit-credentials-auto-fill-button,
        input[type="password"]::-webkit-contacts-auto-fill-button {
            visibility: hidden;
            pointer-events: none;
            position: absolute;
            right: 0;
        }

        input[type="password"] {
            -webkit-appearance: none;
            appearance: none;
        }
    </style>
</head>


<body
    class="min-h-screen flex items-center justify-center p-6"
    style="background:#1e293b;"
    x-data="{
        role: '{{ old('role_user', 'pelanggan') }}',

        showPass: false,
        showPass2: false,

        fotoDiriName: '',
        ktpName: '',
        portofolioName: '',

        selectedKategori: '{{ old('id_kategori') }}',
        selectedSubKategori: '{{ old('id_sub_kategori') }}'
    }"
>


    <!-- ===================================================== -->
    <!-- CONTAINER -->
    <!-- ===================================================== -->

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 py-10">


        <!-- ================================================= -->
        <!-- HEADER -->
        <!-- ================================================= -->

        <h1 class="text-2xl font-bold text-center text-gray-900">
            Buat Akun Baru
        </h1>

        <p class="text-sm text-gray-500 text-center mt-1 mb-6">
            Daftar sebagai
        </p>


        <!-- ================================================= -->
        <!-- TAB PELANGGAN / TEKNISI -->
        <!-- ================================================= -->

        <div class="grid grid-cols-2 bg-gray-100 rounded-xl p-1 mb-6">

            <!-- PELANGGAN -->
            <button
                type="button"
                @click="role = 'pelanggan'"
                :class="
                    role === 'pelanggan'
                        ? 'bg-gray-900 text-white'
                        : 'text-gray-500'
                "
                class="py-2.5 rounded-lg text-sm font-medium transition"
            >
                Pelanggan
            </button>


            <!-- TEKNISI -->
            <button
                type="button"
                @click="role = 'teknisi'"
                :class="
                    role === 'teknisi'
                        ? 'bg-gray-900 text-white'
                        : 'text-gray-500'
                "
                class="py-2.5 rounded-lg text-sm font-medium transition"
            >
                Teknisi
            </button>

        </div>


        <!-- ================================================= -->
        <!-- ERROR -->
        <!-- ================================================= -->

        @if ($errors->any())

            <div
                class="bg-red-50
                       border border-red-200
                       text-red-700
                       text-sm
                       rounded-lg
                       px-4 py-3
                       mb-5"
            >
                {{ $errors->first() }}
            </div>

        @endif


        <!-- ================================================= -->
        <!-- FORM -->
        <!-- ================================================= -->

        <form
            method="POST"
            action="{{ route('register') }}"
            enctype="multipart/form-data"
            class="space-y-4"
        >

            @csrf


            <!-- ROLE -->
            <input
                type="hidden"
                name="role_user"
                x-bind:value="role"
            >


            <!-- ================================================= -->
            <!-- NAMA -->
            <!-- ================================================= -->

            <div>

                <label
                    class="block text-sm font-semibold text-gray-800 mb-2"
                >
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder="Masukkan nama lengkap"
                    class="w-full
                           border border-gray-300
                           rounded-lg
                           px-3.5 py-3
                           text-sm
                           outline-none
                           focus:border-gray-900
                           transition"
                >

            </div>


            <!-- ================================================= -->
            <!-- EMAIL + TELEPON -->
            <!-- ================================================= -->

            <div class="grid grid-cols-2 gap-3">

                <!-- EMAIL -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        class="w-full
                               border border-gray-300
                               rounded-lg
                               px-3.5 py-3
                               text-sm
                               outline-none
                               focus:border-gray-900
                               transition"
                    >

                </div>


                <!-- NO HP -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        No. Telepon
                    </label>

                    <input
                        type="text"
                        name="no_hp"
                        value="{{ old('no_hp') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full
                               border border-gray-300
                               rounded-lg
                               px-3.5 py-3
                               text-sm
                               outline-none
                               focus:border-gray-900
                               transition"
                    >

                </div>

            </div>


            <!-- ================================================= -->
            <!-- KHUSUS TEKNISI -->
            <!-- ================================================= -->

            <div
                x-show="role === 'teknisi'"
                x-cloak
            >

                <!-- KATEGORI KEAHLIAN -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        Kategori Keahlian
                    </label>

                    <select
                        id="kategori"
                        name="id_kategori"
                        x-model="selectedKategori"
                        class="w-full
                               border border-gray-300
                               rounded-lg
                               px-3.5 py-3
                               text-sm
                               outline-none
                               focus:border-gray-900
                               transition"
                    >

                        <option value="">
                            Pilih kategori keahlian
                        </option>

                        @foreach ($kategori as $k)

                            <option
                                value="{{ $k->id_kategori }}"
                                data-sub='@json($k->subCategories)'
                            >
                                {{ $k->nama_kategori }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <!-- SUB KATEGORI KEAHLIAN -->
                <div class="mt-4">

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        Sub Kategori Keahlian
                    </label>

                    <select
                        id="subKategori"
                        name="id_sub_kategori"
                        x-model="selectedSubKategori"
                        required
                        class="w-full
                               border border-gray-300
                               rounded-lg
                               px-3.5 py-3
                               text-sm
                               outline-none
                               focus:border-gray-900
                               transition"
                    >

                        <option value="">
                            Pilih kategori terlebih dahulu
                        </option>

                    </select>

                    <p class="mt-1.5 text-xs text-gray-400">
                        Pilih satu subkategori sesuai keahlian Anda.
                    </p>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- ALAMAT -->
            <!-- ================================================= -->

            <div>

                <label
                    class="block text-sm font-semibold text-gray-800 mb-2"
                >
                    Alamat Domisili
                </label>

                <input
                    type="text"
                    name="alamat"
                    value="{{ old('alamat') }}"
                    placeholder="Masukkan alamat domisili"
                    class="w-full
                           border border-gray-300
                           rounded-lg
                           px-3.5 py-3
                           text-sm
                           outline-none
                           focus:border-gray-900
                           transition"
                >

            </div>


            <!-- ================================================= -->
            <!-- PASSWORD -->
            <!-- ================================================= -->

            <div class="grid grid-cols-2 gap-3">

                <!-- PASSWORD -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        Password
                    </label>

                    <div class="relative">

                        <input
                            :type="showPass ? 'text' : 'password'"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="new-password"
                            class="w-full
                                   border border-gray-300
                                   rounded-lg
                                   px-3.5 py-3
                                   pr-11
                                   text-sm
                                   outline-none
                                   focus:border-gray-900
                                   transition"
                        >

                        <button
                            type="button"
                            @click="showPass = !showPass"
                            class="absolute
                                   right-3
                                   top-1/2
                                   -translate-y-1/2
                                   text-gray-400
                                   hover:text-gray-700
                                   transition"
                        >

                            <!-- MATA TERBUKA -->
                            <svg
                                x-show="!showPass"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                width="19"
                                height="19"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5.25 12 5.25c4.477 0 8.268 2.693 9.542 6.75-1.274 4.057-5.065 6.75-9.542 6.75-4.477 0-8.268-2.693-9.542-6.75z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                    stroke-width="2"
                                />

                            </svg>


                            <!-- MATA TERTUTUP -->
                            <svg
                                x-show="showPass"
                                x-cloak
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                width="19"
                                height="19"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3l18 18"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.58 10.58a2 2 0 102.83 2.83"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.48 0 8.27 2.69 9.54 6.75a10.74 10.74 0 01-2.16 3.44M6.23 6.23A10.72 10.72 0 002.46 12c1.27 4.06 5.06 6.75 9.54 6.75a9.7 9.7 0 004.03-.86"
                                />

                            </svg>

                        </button>

                    </div>

                </div>


                <!-- ULANGI PASSWORD -->
                <div>

                    <label
                        class="block text-sm font-semibold text-gray-800 mb-2"
                    >
                        Ulangi Password
                    </label>

                    <div class="relative">

                        <input
                            :type="showPass2 ? 'text' : 'password'"
                            name="password_confirmation"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            class="w-full
                                   border border-gray-300
                                   rounded-lg
                                   px-3.5 py-3
                                   pr-11
                                   text-sm
                                   outline-none
                                   focus:border-gray-900
                                   transition"
                        >

                        <button
                            type="button"
                            @click="showPass2 = !showPass2"
                            class="absolute
                                   right-3
                                   top-1/2
                                   -translate-y-1/2
                                   text-gray-400
                                   hover:text-gray-700
                                   transition"
                        >

                            <!-- MATA TERBUKA -->
                            <svg
                                x-show="!showPass2"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                width="19"
                                height="19"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5.25 12 5.25c4.477 0 8.268 2.693 9.542 6.75-1.274 4.057-5.065 6.75-9.542 6.75-4.477 0-8.268-2.693-9.542-6.75-9.542 6.75-4.477-8.268-6.75-9.542-6.75z"
                                />

                                <circle
                                    cx="12"
                                    cy="12"
                                    r="3"
                                    stroke-width="2"
                                />

                            </svg>


                            <!-- MATA TERTUTUP -->
                            <svg
                                x-show="showPass2"
                                x-cloak
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                width="19"
                                height="19"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M3 3l18 18"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M10.58 10.58a2 2 0 102.83 2.83"
                                />

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9.88 5.09A9.77 9.77 0 0112 4.5c4.48 0 8.27 2.69 9.54 6.75a10.74 10.74 0 01-2.16 3.44M6.23 6.23A10.72 10.72 0 002.46 12c1.27 4.06 5.06 6.75 9.54 6.75a9.7 9.7 0 004.03-.86"
                                />

                            </svg>

                        </button>

                    </div>

                </div>

            </div>


            <!-- ================================================= -->
            <!-- FOTO DIRI - KHUSUS TEKNISI -->
            <!-- ================================================= -->

            <div
                x-show="role === 'teknisi'"
                x-cloak
            >

                <label
                    class="block text-sm font-semibold text-gray-800 mb-2"
                >
                    Foto Diri
                </label>

                <label
                    class="flex
                           flex-col
                           items-center
                           justify-center
                           gap-1
                           border-2
                           border-dashed
                           border-gray-300
                           rounded-xl
                           py-6
                           cursor-pointer
                           hover:border-gray-400
                           transition"
                >

                    <!-- ICON UPLOAD -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        width="22"
                        height="22"
                        class="text-gray-400"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v12m0-12l-4 4m4-4l4 4M4 20h16"
                        />

                    </svg>


                    <!-- NAMA FILE -->
                    <span
                        class="text-xs text-gray-600 text-center px-3"
                        x-text="
                            fotoDiriName ||
                            'Klik untuk upload atau drag & drop'
                        "
                    ></span>


                    <!-- FORMAT -->
                    <span class="text-[11px] text-gray-400">
                        Format: JPG, PNG. Maks. 2MB
                    </span>


                    <!-- INPUT FOTO DIRI -->
                    <input
                        type="file"
                        name="foto_diri"
                        class="hidden"
                        accept="image/jpeg,image/png"
                        @change="
                            fotoDiriName =
                            $event.target.files[0]?.name || ''
                        "
                    >

                </label>

            </div>


            <!-- ================================================= -->
            <!-- UPLOAD KTP -->
            <!-- ================================================= -->

            <div
                x-show="role === 'teknisi'"
                x-cloak
            >

                <label
                    class="block text-sm font-semibold text-gray-800 mb-2"
                >
                    Upload Foto KTP (opsional)
                </label>

                <label
                    class="flex
                           flex-col
                           items-center
                           justify-center
                           gap-1
                           border-2
                           border-dashed
                           border-gray-300
                           rounded-xl
                           py-6
                           cursor-pointer
                           hover:border-gray-400
                           transition"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        width="22"
                        height="22"
                        class="text-gray-400"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v12m0-12l-4 4m4-4l4 4M4 20h16"
                        />

                    </svg>


                    <span
                        class="text-xs text-gray-600"
                        x-text="
                            ktpName ||
                            'Klik untuk upload atau drag & drop'
                        "
                    ></span>


                    <span class="text-[11px] text-gray-400">
                        Format: JPG, PNG. Maks. 2MB
                    </span>


                    <input
                        type="file"
                        name="ktp"
                        class="hidden"
                        accept="image/*"
                        @change="
                            ktpName =
                            $event.target.files[0]?.name || ''
                        "
                    >

                </label>

            </div>


            <!-- ================================================= -->
            <!-- UPLOAD PORTOFOLIO -->
            <!-- ================================================= -->

            <div
                x-show="role === 'teknisi'"
                x-cloak
            >

                <label
                    class="block text-sm font-semibold text-gray-800 mb-2"
                >
                    Upload Portofolio (opsional)
                </label>

                <label
                    class="flex
                           flex-col
                           items-center
                           justify-center
                           gap-1
                           border-2
                           border-dashed
                           border-gray-300
                           rounded-xl
                           py-6
                           cursor-pointer
                           hover:border-gray-400
                           transition"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        width="22"
                        height="22"
                        class="text-gray-400"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v12m0-12l-4 4m4-4l4 4M4 20h16"
                        />

                    </svg>


                    <span
                        class="text-xs text-gray-600"
                        x-text="
                            portofolioName ||
                            'Klik untuk upload atau drag & drop'
                        "
                    ></span>


                    <span class="text-[11px] text-gray-400">
                        Format: JPG, PNG, PDF. Maks. 5MB
                    </span>


                    <input
                        type="file"
                        name="portofolio"
                        class="hidden"
                        accept="image/*,.pdf"
                        @change="
                            portofolioName =
                            $event.target.files[0]?.name || ''
                        "
                    >

                </label>

            </div>


            <!-- ================================================= -->
            <!-- BUTTON DAFTAR -->
            <!-- ================================================= -->

            <button
                type="submit"
                class="w-full
                       bg-gray-900
                       text-white
                       rounded-lg
                       py-3.5
                       font-semibold
                       hover:bg-gray-800
                       transition"
            >
                Daftar
            </button>

        </form>


        <!-- ================================================= -->
        <!-- LOGIN -->
        <!-- ================================================= -->

        <p class="text-center text-sm text-gray-500 mt-6">

            Sudah punya akun?

            <a
                href="{{ route('login') }}"
                class="text-gray-900 font-semibold underline"
            >
                Masuk
            </a>

        </p>


    </div>


    <!-- ===================================================== -->
    <!-- JAVASCRIPT SUBKATEGORI -->
    <!-- ===================================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const kategori =
                document.getElementById('kategori');

            const subKategori =
                document.getElementById('subKategori');


            if (!kategori || !subKategori) {
                return;
            }


            function loadSubKategori() {

                /*
                 * Kosongkan subkategori terlebih dahulu.
                 */

                subKategori.innerHTML = `
                    <option value="">
                        Pilih sub kategori keahlian
                    </option>
                `;


                /*
                 * Kalau kategori belum dipilih,
                 * jangan tampilkan subkategori.
                 */

                if (!kategori.value) {

                    subKategori.innerHTML = `
                        <option value="">
                            Pilih kategori terlebih dahulu
                        </option>
                    `;

                    return;
                }


                /*
                 * Ambil option kategori yang sedang dipilih.
                 */

                const selectedOption =
                    kategori.options[
                        kategori.selectedIndex
                    ];


                /*
                 * Ambil data subkategori
                 * dari data-sub.
                 */

                let subKategoriData = [];


                try {

                    subKategoriData =
                        JSON.parse(
                            selectedOption.dataset.sub || '[]'
                        );

                } catch (error) {

                    console.error(
                        'Data subkategori tidak valid:',
                        error
                    );

                    return;
                }


                /*
                 * Masukkan seluruh subkategori
                 * dari kategori yang dipilih.
                 */

                subKategoriData.forEach(function (sub) {

                    const option =
                        document.createElement('option');


                    option.value =
                        sub.id_sub_kategori;


                    option.textContent =
                        sub.nama_sub_kategori;


                    /*
                     * Pertahankan pilihan lama
                     * jika validasi Laravel gagal.
                     */

                    @if(old('id_sub_kategori'))

                        if (
                            String(sub.id_sub_kategori) ===
                            String(@json(old('id_sub_kategori')))
                        ) {
                            option.selected = true;
                        }

                    @endif


                    subKategori.appendChild(option);

                });

            }


            /*
             * Ketika kategori berubah,
             * subkategori ikut berubah.
             */

            kategori.addEventListener(
                'change',
                loadSubKategori
            );


            /*
             * Jalankan sekali ketika halaman
             * pertama kali dibuka.
             */

            if (kategori.value) {

                loadSubKategori();

            }

        });

    </script>


</body>

</html>