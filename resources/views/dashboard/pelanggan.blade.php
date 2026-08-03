@extends('layouts.dashboard')
@section('title', 'Dashboard')

@section('content')

    <!-- STAT CARDS -->
    <div class="grid grid-cols-3 gap-4 mb-8">
        <div class="border border-gray-200 rounded-2xl p-5">
            <div class="text-sm text-gray-500 mb-2">Total Order</div>
            <div class="text-3xl font-bold text-gray-900">{{ $totalOrder ?? 0 }}</div>
        </div>
        <div class="bg-gray-900 rounded-2xl p-5">
            <div class="text-sm text-gray-400 mb-2">Sedang Berjalan</div>
            <div class="text-3xl font-bold text-white">{{ $sedangBerjalan ?? 0 }}</div>
        </div>
        <div class="border border-gray-200 rounded-2xl p-5">
            <div class="text-sm text-gray-500 mb-2">Selesai</div>
            <div class="text-3xl font-bold text-gray-900">{{ $selesai ?? 0 }}</div>
        </div>
    </div>

    <!-- ORDER AKTIF -->
    <div class="mb-8">
        <h2 class="text-base font-bold text-gray-900 mb-3">Order Aktif</h2>

        @forelse ($orderAktif ?? [] as $order)
            <div class="border border-gray-200 rounded-2xl p-5 mb-3">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <div class="font-bold text-gray-900">{{ $order->nama_layanan }}</div>
                        <div class="text-sm text-gray-500">Teknisi: {{ $order->nama_teknisi }}</div>
                    </div>
                    <span class="text-xs font-medium border border-gray-300 rounded-full px-3 py-1.5 whitespace-nowrap">
                        {{ $order->status_label }}
                    </span>
                </div>

                @php
                    $steps = ['Dipesan', 'Dikonfirmasi', 'Pembayaran', 'Dikerjakan', 'Selesai'];
                    $currentIndex = array_search($order->status_label, $steps);
                    $currentIndex = $currentIndex === false ? 0 : $currentIndex;
                @endphp

                <div class="flex items-center gap-1 mb-2">
                    @foreach ($steps as $i => $step)
                        <div class="flex-1 h-1.5 rounded-full {{ $i <= $currentIndex ? 'bg-gray-900' : 'bg-gray-200' }}"></div>
                    @endforeach
                </div>
                <div class="flex items-center justify-between text-xs text-gray-500">
                    @foreach ($steps as $i => $step)
                        <span class="{{ $i === $currentIndex ? 'font-bold text-gray-900' : '' }}">{{ $step }}</span>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="border border-dashed border-gray-200 rounded-2xl p-6 text-center text-sm text-gray-400">
                Belum ada order yang sedang berjalan.
            </div>
        @endforelse
    </div>

    <!-- RIWAYAT ORDER (RINGKAS) -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-base font-bold text-gray-900">Riwayat Order</h2>
            <a href="{{ route('dashboard.riwayat-order') }}" class="text-sm font-medium underline text-gray-900">Lihat semua</a>
        </div>

        <div class="flex flex-col gap-3 mb-6">
            @forelse ($riwayatOrder ?? [] as $item)
                <div class="border border-gray-200 rounded-2xl p-4 flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-gray-900">{{ $item->nama_layanan }}</div>
                        <div class="text-sm text-gray-500">{{ $item->tanggal }} · {{ $item->nama_teknisi }}</div>
                    </div>
                    <div class="text-right">
                        <span class="inline-block text-xs font-medium border border-gray-300 rounded-full px-3 py-1.5 mb-1">
                            {{ $item->status_label }}
                        </span>
                        <div class="text-sm font-semibold text-gray-900">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            @empty
                <div class="border border-dashed border-gray-200 rounded-2xl p-6 text-center text-sm text-gray-400">
                    Belum ada riwayat order.
                </div>
            @endforelse
        </div>

        <a href="{{ route('dashboard.pesan-layanan') }}" class="block w-full text-center bg-gray-900 text-white font-semibold rounded-xl py-3 hover:bg-gray-800 transition">
            + Pesan Layanan Baru
        </a>
    </div>

@endsection