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

    @if(session('error'))

        <div
            class="flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50 px-5 py-4"
        >
            <div
                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600"
            >
                ✕
            </div>

            <div>
                <p class="text-sm font-semibold text-red-800">
                    Perhatian
                </p>

                <p class="mt-0.5 text-sm text-red-700">
                    {{ session('error') }}
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

        $jumlahPengajuanBatal = \App\Models\Order::where(
            'status',
            'Pengajuan_Batal'
        )->count();

        $jumlahSelesai = \App\Models\Order::where(
            'status',
            'Selesai'
        )->count();

        $jumlahDibatalkan = \App\Models\Order::whereIn(
            'status',
            ['Dibatalkan', 'Ditolak']
        )->count();
    @endphp

    <div class="grid grid-cols-5 gap-2 sm:gap-3.5">

        {{-- MENUNGGU --}}
        <a href="{{ route('admin.orders', ['status' => 'Menunggu']) }}" class="rounded-3xl border {{ ($status ?? '') === 'Menunggu' ? 'border-amber-400 ring-2 ring-amber-200' : 'border-slate-200' }} bg-white p-5 shadow-xs flex items-center justify-between hover:border-amber-400 hover:shadow-md transition cursor-pointer group block">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-amber-600 transition">
                    MENUNGGU
                </p>

                <p class="mt-2 text-2xl font-extrabold text-amber-500">
                    {{ $jumlahMenunggu }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 shrink-0 group-hover:scale-105 transition">
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
                        d="M12 8v4l3 2"
                    />
                    <circle cx="12" cy="12" r="9"/>
                </svg>
            </div>
        </a>

        {{-- DIPROSES --}}
        <a href="{{ route('admin.orders', ['status' => 'Diproses']) }}" class="rounded-3xl border {{ ($status ?? '') === 'Diproses' ? 'border-blue-400 ring-2 ring-blue-200' : 'border-slate-200' }} bg-white p-5 shadow-xs flex items-center justify-between hover:border-blue-400 hover:shadow-md transition cursor-pointer group block">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-blue-600 transition">
                    DIPROSES
                </p>

                <p class="mt-2 text-2xl font-extrabold text-blue-600">
                    {{ $jumlahDiproses }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shrink-0 group-hover:scale-105 transition">
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
                        d="M12 6v6l4 2"
                    />
                    <circle cx="12" cy="12" r="9"/>
                </svg>
            </div>
        </a>

        {{-- PENGAJUAN BATAL --}}
        <a href="{{ route('admin.orders', ['status' => 'Pengajuan_Batal']) }}" class="rounded-3xl border {{ ($status ?? '') === 'Pengajuan_Batal' ? 'border-rose-500 ring-2 ring-rose-200 bg-rose-50/50' : 'border-rose-200 bg-white' }} p-5 shadow-xs flex items-center justify-between hover:border-rose-500 hover:shadow-md transition cursor-pointer group block">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-rose-600 group-hover:text-rose-700 transition">
                    PENGAJUAN BATAL
                </p>

                <p class="mt-2 text-2xl font-extrabold text-rose-600">
                    {{ $jumlahPengajuanBatal }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-100 text-rose-600 shrink-0 group-hover:scale-105 transition text-lg">
                🚨
            </div>
        </a>

        {{-- SELESAI --}}
        <a href="{{ route('admin.orders', ['status' => 'Selesai']) }}" class="rounded-3xl border {{ ($status ?? '') === 'Selesai' ? 'border-emerald-400 ring-2 ring-emerald-200' : 'border-slate-200' }} bg-white p-5 shadow-xs flex items-center justify-between hover:border-emerald-400 hover:shadow-md transition cursor-pointer group block">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-emerald-600 transition">
                    SELESAI
                </p>

                <p class="mt-2 text-2xl font-extrabold text-emerald-600">
                    {{ $jumlahSelesai }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 shrink-0 group-hover:scale-105 transition">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>
            </div>
        </a>

        {{-- DIBATALKAN --}}
        <a href="{{ route('admin.orders', ['status' => 'Dibatalkan']) }}" class="rounded-3xl border {{ ($status ?? '') === 'Dibatalkan' ? 'border-red-400 ring-2 ring-red-200' : 'border-slate-200' }} bg-white p-5 shadow-xs flex items-center justify-between hover:border-red-400 hover:shadow-md transition cursor-pointer group block">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-red-600 transition">
                    DIBATALKAN
                </p>

                <p class="mt-2 text-2xl font-extrabold text-red-500">
                    {{ $jumlahDibatalkan }}
                </p>
            </div>

            <div class="flex h-10 w-10 items-center justify-center rounded-2xl bg-red-50 text-red-500 shrink-0 group-hover:scale-105 transition">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2.5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>
            </div>
        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- TABEL HORIZONTAL DAFTAR TRANSAKSI --}}
    {{-- ========================================================= --}}

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">

        {{-- HEADER TABEL DAN FILTER --}}
        <div class="p-6 border-b border-slate-100 bg-white">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        Kelola Transaksi & Order {{ $status ? "({$status})" : '' }}
                    </h2>
                </div>


                <form
                    action="{{ route('admin.orders') }}"
                    method="GET"
                    class="flex items-center gap-2.5 shrink-0 flex-nowrap"
                >

                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="
                            min-w-[170px]
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
                            value="Pengajuan_Batal"
                            {{ $status === 'Pengajuan_Batal' ? 'selected' : '' }}
                        >
                            🚨 Pengajuan Batal (Teknisi)
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
                                whitespace-nowrap
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
                                'Pengajuan_Batal' => 'bg-rose-100 text-rose-800 border-rose-300 animate-pulse font-bold',
                                'Selesai' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'Dibatalkan', 'Ditolak' => 'bg-red-50 text-red-700 border-red-200',
                                default => 'bg-slate-50 text-slate-600 border-slate-200',
                            };
                        @endphp

                        <tr class="hover:bg-slate-50/80 transition {{ $order->status === 'Pengajuan_Batal' ? 'bg-rose-50/30' : '' }}">

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
                                        Menunggu Teknisi
                                    </span>
                                @endif
                            </td>

                            {{-- TOTAL BIAYA --}}
                            <td class="px-6 py-4 font-bold text-sky-600 whitespace-nowrap">
                                Rp {{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- METODE --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-700 border border-sky-100 text-[10px] font-bold">
                                    {{ in_array($order->metode_pembayaran, ['qris', 'online']) ? 'Pembayaran Online' : ucfirst($order->metode_pembayaran ?? '-') }}
                                </span>
                            </td>

                            {{-- STATUS --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $statusClass }}">
                                    {{ $order->status === 'Pengajuan_Batal' ? '🚨 Pengajuan Batal' : $order->status }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-2">
                                    @if($order->status === 'Pengajuan_Batal')
                                        <button
                                            type="button"
                                            onclick="openModalTinjauBatal('{{ $order->id_order }}')"
                                            class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-sm transition"
                                        >
                                            🚨 Tinjau Kendala
                                        </button>
                                    @endif

                                    <a
                                        href="{{ route('dashboard.detail-order', $order->id_order) }}"
                                        class="inline-flex items-center px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold transition"
                                    >
                                        Detail
                                    </a>
                                </div>

                                {{-- MODAL POPUP TINJAU PENGAJUAN BATAL TEKNISI --}}
                                @if($order->status === 'Pengajuan_Batal')
                                <div id="modalTinjauBatal-{{ $order->id_order }}" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4 text-left">
                                    <div class="bg-white rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl border border-slate-100">
                                        <div class="bg-rose-600 text-white p-5 flex items-center justify-between">
                                            <div class="flex items-center gap-3">
                                                <span class="text-2xl">🚨</span>
                                                <div>
                                                    <h3 class="text-base font-bold">Verifikasi Kendala Teknisi</h3>
                                                    <p class="text-xs text-rose-100">Pesanan #{{ $order->id_order }} - {{ $order->subCategory->nama_sub_kategori ?? 'Layanan' }}</p>
                                                </div>
                                            </div>
                                            <button type="button" onclick="closeModalTinjauBatal('{{ $order->id_order }}')" class="text-white hover:text-rose-200">✕</button>
                                        </div>

                                        <div class="p-5 space-y-4 text-xs whitespace-normal">
                                            <div class="grid grid-cols-2 gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-200">
                                                <div>
                                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Teknisi Berhalangan</span>
                                                    <span class="font-bold text-slate-800 text-sm">{{ $order->teknisi->nama ?? 'Teknisi' }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-[10px] text-slate-400 uppercase font-bold block">Pelanggan Pemesan</span>
                                                    <span class="font-bold text-slate-800 text-sm">{{ $order->pelanggan->nama ?? 'Pelanggan' }}</span>
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block font-bold text-slate-800 mb-1">Alasan Utama Kendala:</label>
                                                <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-rose-800 font-semibold">
                                                    {{ $order->alasan_batal_teknisi ?? 'Keterlambatan / Kendala teknis' }}
                                                </div>
                                            </div>

                                            <div>
                                                <label class="block font-bold text-slate-800 mb-1">Catatan Penjelasan Teknisi:</label>
                                                <p class="p-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-700 leading-relaxed italic">
                                                    "{{ $order->catatan_batal_teknisi ?? '-' }}"
                                                </p>
                                            </div>

                                            @if($order->foto_kendala)
                                                <div>
                                                    <label class="block font-bold text-slate-800 mb-1">Bukti Foto Kendala:</label>
                                                    <a href="{{ asset('storage/' . $order->foto_kendala) }}" target="_blank" class="block group">
                                                        <img src="{{ asset('storage/' . $order->foto_kendala) }}" alt="Foto Kendala" class="w-full h-40 object-cover rounded-xl border border-slate-200 group-hover:opacity-90 transition">
                                                        <span class="text-[10px] text-sky-600 underline mt-1 block">Klik untuk melihat foto ukuran penuh</span>
                                                    </a>
                                                </div>
                                            @endif

                                            <div class="pt-3 border-t border-slate-100 flex flex-col gap-2">
                                                <form action="{{ route('admin.orders.setujui-batal-reassign', $order->id_order) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Apakah Anda yakin menyetujui pembatalan ini? Sistem akan secara otomatis mencari teknisi pengganti terdekat yang aktif.')" class="w-full py-3 px-4 rounded-xl bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-600 hover:from-sky-600 hover:to-indigo-700 text-white font-bold text-xs shadow-md transition flex items-center justify-center gap-2">
                                                        👉 Setujui & Biarkan Sistem Cari Teknisi Pengganti
                                                    </button>
                                                    <p class="text-[10px] text-slate-400 text-center mt-1">Sistem akan melepaskan pesanan dari teknisi ini & menugaskan teknisi pengganti terdekat.</p>
                                                </form>

                                                <form action="{{ route('admin.orders.tolak-batal', $order->id_order) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" onclick="return confirm('Tolak pengajuan pembatalan teknisi?')" class="w-full py-2.5 px-4 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition">
                                                        ✕ Tolak Pengajuan (Minta Teknisi Tetap Datang)
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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

</div>

<script>
    function openModalTinjauBatal(id) {
        const modal = document.getElementById('modalTinjauBatal-' + id);
        if (modal) modal.classList.remove('hidden');
    }
    function closeModalTinjauBatal(id) {
        const modal = document.getElementById('modalTinjauBatal-' + id);
        if (modal) modal.classList.add('hidden');
    }
</script>

@endsection