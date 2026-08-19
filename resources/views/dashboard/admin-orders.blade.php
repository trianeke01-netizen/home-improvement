@extends('layouts.dashboard')

@section('title', 'Transaksi')

@section('content')

<div class="space-y-6">

    {{-- ========================================================= --}}
    {{-- NOTIFIKASI --}}
    {{-- ========================================================= --}}

    @if(session('success'))

        <div
            class="flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4"
        >

            <div
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600"
            >
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
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            </div>

            <div>
                <p class="text-sm font-semibold text-emerald-800">
                    Berhasil
                </p>

                <p class="mt-0.5 text-sm text-emerald-700">
                    {{ session('success') }}
                </p>
            </div>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- ERROR VALIDASI --}}
    {{-- ========================================================= --}}

    @if($errors->any())

        <div
            class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4"
        >

            <p class="text-sm font-semibold text-red-800">
                Terjadi kesalahan
            </p>

            <ul class="mt-2 space-y-1 text-sm text-red-700">

                @foreach($errors->all() as $error)

                    <li>
                        • {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ========================================================= --}}
    {{-- FILTER --}}
    {{-- ========================================================= --}}

    {{-- ========================================================= --}}
    {{-- FILTER TRANSAKSI (TOP HEADER BAR) --}}
    {{-- ========================================================= --}}

    <div
        class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm"
    >

        <div
            class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between"
        >

            <div>

                <h2 class="text-lg font-bold text-slate-900">
                    Kelola Transaksi & Order
                </h2>

                <p class="mt-0.5 text-xs text-slate-500">
                    Filter dan kelola penugasan teknisi untuk seluruh transaksi pelanggan.
                </p>

            </div>


            <form
                action="{{ route('admin.orders') }}"
                method="GET"
                class="flex flex-wrap items-center gap-3"
            >

                <select
                    name="status"
                    onchange="this.form.submit()"
                    class="
                        min-w-[180px]
                        rounded-xl
                        border
                        border-slate-200
                        bg-slate-50
                        px-4
                        py-2.5
                        text-xs
                        font-semibold
                        text-slate-800
                        outline-none
                        transition
                        focus:border-sky-500
                        focus:bg-white
                    "
                >

                    <option value="">
                        Semua Status Transaksi
                    </option>

                    <option
                        value="Menunggu"
                        {{ $status === 'Menunggu' ? 'selected' : '' }}
                    >
                        Menunggu
                    </option>

                    <option
                        value="Dikonfirmasi"
                        {{ $status === 'Dikonfirmasi' ? 'selected' : '' }}
                    >
                        Dikonfirmasi
                    </option>

                    <option
                        value="Dikerjakan"
                        {{ $status === 'Dikerjakan' ? 'selected' : '' }}
                    >
                        Dikerjakan
                    </option>

                    <option
                        value="Diproses"
                        {{ $status === 'Diproses' ? 'selected' : '' }}
                    >
                        Diproses
                    </option>

                    <option
                        value="Selesai"
                        {{ $status === 'Selesai' ? 'selected' : '' }}
                    >
                        Selesai
                    </option>

                    <option
                        value="Dibatalkan"
                        {{ $status === 'Dibatalkan' ? 'selected' : '' }}
                    >
                        Dibatalkan
                    </option>

                </select>


                @if($status)

                    <a
                        href="{{ route('admin.orders') }}"
                        class="
                            inline-flex
                            items-center
                            justify-center
                            rounded-xl
                            border
                            border-slate-200
                            bg-white
                            px-4
                            py-2.5
                            text-xs
                            font-bold
                            text-slate-500
                            transition
                            hover:bg-slate-50
                        "
                    >
                        Reset Filter
                    </a>

                @endif

            </form>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RINGKASAN GLOBAL --}}
    {{-- ========================================================= --}}

    @php
        $jumlahMenunggu = \App\Models\Order::where(
            'status',
            'Menunggu'
        )->count();

        $jumlahDiproses = \App\Models\Order::whereIn(
            'status',
            ['Dikonfirmasi', 'Dikerjakan', 'Diproses']
        )->count();

        $jumlahSelesai = \App\Models\Order::where(
            'status',
            'Selesai'
        )->count();

        $nilaiTransaksi = \App\Models\Order::sum('total_harga');
    @endphp

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- MENUNGGU --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Menunggu
                    </p>

                    <p class="mt-2 text-2xl font-bold text-amber-600">
                        {{ $jumlahMenunggu }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
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
                            d="M12 8v4l3 2"
                        />
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- DIPROSES --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Diproses
                    </p>

                    <p class="mt-2 text-2xl font-bold text-blue-600">
                        {{ $jumlahDiproses }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
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
                            d="M12 6v6l4 2"
                        />
                        <circle cx="12" cy="12" r="9"/>
                    </svg>
                </div>
            </div>
        </div>

        {{-- SELESAI --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Selesai
                    </p>

                    <p class="mt-2 text-2xl font-bold text-emerald-600">
                        {{ $jumlahSelesai }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
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
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                </div>
            </div>
        </div>

        {{-- NILAI TRANSAKSI --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div class="min-w-0">
                    <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                        Nilai Transaksi
                    </p>

                    <p class="mt-2 truncate text-xl font-bold text-slate-900">
                        Rp {{ number_format($nilaiTransaksi, 0, ',', '.') }}
                    </p>
                </div>

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-slate-100 text-slate-700">
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
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                </div>
            </div>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- TABEL HORIZONTAL DAFTAR TRANSAKSI --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER TABEL --}}
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4 bg-slate-50/60">
            <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">
                Semua Daftar Transaksi {{ $status ? "({$status})" : '' }}
            </h3>

            <span class="text-xs font-medium text-slate-500">
                Total {{ $orders->count() }} transaksi
            </span>
        </div>

        {{-- TABEL DATA --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 bg-slate-50/40 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="px-6 py-3.5">ID & Tanggal</th>
                        <th class="px-6 py-3.5">Pelanggan</th>
                        <th class="px-6 py-3.5">Layanan</th>
                        <th class="px-6 py-3.5">Teknisi</th>
                        <th class="px-6 py-3.5">Total Biaya</th>
                        <th class="px-6 py-3.5">Metode</th>
                        <th class="px-6 py-3.5">Status</th>
                        <th class="px-6 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-xs text-slate-700">

                    @forelse($orders as $order)
                        @php
                            $statusClass = match($order->status) {
                                'Menunggu' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'Dikonfirmasi' => 'bg-blue-50 text-blue-700 border-blue-200',
                                'Dikerjakan', 'Diproses' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Dibatalkan', 'Ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                        @endphp

                        <tr class="hover:bg-slate-50/80 transition">

                            {{-- ID & TANGGAL --}}
                            <td class="px-6 py-4 font-semibold text-slate-900 whitespace-nowrap">
                                <div>#{{ $order->id_order }}</div>
                                <div class="text-[10px] font-normal text-slate-400 mt-0.5">
                                    {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y, H:i') }}
                                </div>
                            </td>

                            {{-- PELANGGAN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $order->pelanggan->nama ?? 'Pelanggan' }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $order->pelanggan->no_hp ?? '-' }}</div>
                            </td>

                            {{-- LAYANAN --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-slate-800">{{ $order->subCategory->nama_sub_kategori ?? 'Layanan' }}</div>
                                <div class="text-[10px] text-slate-400 mt-0.5">{{ $order->subCategory->category->nama_kategori ?? '-' }}</div>
                            </td>

                            {{-- TEKNISI --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($order->teknisi)
                                    <div class="font-semibold text-slate-800">{{ $order->teknisi->nama }}</div>
                                    <div class="text-[10px] text-emerald-600 font-medium mt-0.5">Terhubung</div>
                                @else
                                    <span class="inline-block px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-semibold border border-amber-200">
                                        Belum Ditugaskan
                                    </span>
                                @endif
                            </td>

                            {{-- TOTAL BIAYA --}}
                            <td class="px-6 py-4 font-bold text-sky-600 whitespace-nowrap">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- METODE --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold uppercase">
                                    {{ $order->metode_pembayaran ?? '-' }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $statusClass }}">
                                    {{ $order->status }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$order->teknisi && $order->status !== 'Selesai' && $order->status !== 'Dibatalkan')
                                        <button
                                            type="button"
                                            onclick="openAssignModal({{ $order->id_order }})"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition shadow-xs"
                                        >
                                            Tugaskan
                                        </button>
                                    @endif

                                    <a
                                        href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition"
                                    >
                                        Detail
                                    </a>
                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400 text-xs">
                                Belum ada transaksi yang ditemukan.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>
        </div>

    </div>


{{-- ============================================================= --}}
{{-- MODAL TUGASKAN TEKNISI --}}
{{-- ============================================================= --}}

<div
    id="assignModal"
    class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/50 px-5 py-8 backdrop-blur-sm"
>

    <div
        class="w-full max-w-lg overflow-hidden rounded-3xl bg-white shadow-2xl"
    >

        {{-- HEADER MODAL --}}

        <div class="border-b border-slate-100 px-6 py-5">

            <div class="flex items-start justify-between gap-4">

                <div>

                    <h2 class="text-lg font-bold text-slate-900">
                        Tugaskan Teknisi
                    </h2>

                    <p class="mt-1 text-sm text-slate-400">
                        Pilih teknisi yang sudah terverifikasi.
                    </p>

                </div>


                <button
                    type="button"
                    onclick="closeAssignModal()"
                    class="
                        flex
                        h-9
                        w-9
                        cursor-pointer
                        items-center
                        justify-center
                        rounded-xl
                        bg-slate-100
                        text-slate-500
                        transition
                        hover:bg-slate-200
                    "
                >

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
                            d="M6 18L18 6M6 6l12 12"
                        />

                    </svg>

                </button>

            </div>

        </div>


        {{-- FORM --}}

        <form
            id="assignForm"
            method="POST"
            action=""
            class="px-6 py-6"
        >

            @csrf

            <div>

                <label
                    for="id_teknisi"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Teknisi
                </label>

                <select
                    name="id_teknisi"
                    id="id_teknisi"
                    required
                    class="
                        w-full
                        rounded-xl
                        border
                        border-slate-200
                        bg-white
                        px-4
                        py-3
                        text-sm
                        text-slate-700
                        outline-none
                        transition
                        focus:border-slate-400
                        focus:ring-2
                        focus:ring-slate-100
                    "
                >

                    <option value="">
                        -- Pilih Teknisi --
                    </option>

                    @forelse($teknisiAktif as $teknisi)

                        <option value="{{ $teknisi->id_user }}">

                            {{ $teknisi->nama }}

                            @if($teknisi->profileTeknisi?->subCategory)
                                —
                                {{ $teknisi->profileTeknisi->subCategory->nama_sub_kategori }}
                            @endif

                        </option>

                    @empty

                        <option value="" disabled>
                            Belum ada teknisi terverifikasi
                        </option>

                    @endforelse

                </select>

                <p class="mt-2 text-xs text-slate-400">
                    Hanya teknisi dengan status verifikasi
                    <span class="font-semibold text-emerald-600">
                        Disetujui
                    </span>
                    yang tersedia.
                </p>

            </div>


            {{-- BUTTON --}}

            <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    onclick="closeAssignModal()"
                    class="
                        cursor-pointer
                        rounded-xl
                        border
                        border-slate-200
                        px-5
                        py-3
                        text-sm
                        font-semibold
                        text-slate-600
                        transition
                        hover:bg-slate-50
                    "
                >
                    Batal
                </button>


                <button
                    type="submit"
                    class="
                        cursor-pointer
                        rounded-xl
                        bg-slate-900
                        px-5
                        py-3
                        text-sm
                        font-semibold
                        text-white
                        transition
                        hover:bg-slate-800
                    "
                >
                    Tugaskan Teknisi
                </button>

            </div>

        </form>

    </div>

</div>


{{-- ============================================================= --}}
{{-- JAVASCRIPT MODAL --}}
{{-- ============================================================= --}}

<script>

    function openAssignModal(orderId)
    {
        const modal = document.getElementById('assignModal');
        const form = document.getElementById('assignForm');

        if (!modal || !form) {
            return;
        }

        /*
         * Route Laravel:
         * POST /dashboard/admin/orders/{id}/assign
         */
        form.action =
            "{{ url('/dashboard/admin/orders') }}/"
            + orderId
            + "/assign";

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        document.body.classList.add('overflow-hidden');
    }


    function closeAssignModal()
    {
        const modal = document.getElementById('assignModal');

        if (!modal) {
            return;
        }

        modal.classList.remove('flex');
        modal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');

        const select = document.getElementById('id_teknisi');

        if (select) {
            select.value = '';
        }
    }


    /*
     * Klik area luar modal
     */

    document
        .getElementById('assignModal')
        ?.addEventListener(
            'click',
            function(event)
            {
                if (event.target === this) {
                    closeAssignModal();
                }
            }
        );


    /*
     * Tombol ESC
     */

    document.addEventListener(
        'keydown',
        function(event)
        {
            if (event.key === 'Escape') {
                closeAssignModal();
            }
        }
    );

</script>

@endsection