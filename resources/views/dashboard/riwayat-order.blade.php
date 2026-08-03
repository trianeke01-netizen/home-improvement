@extends('layouts.dashboard')
@section('title', 'Riwayat Order')

@section('content')

    <h1 class="text-xl font-bold text-gray-900 mb-6">Riwayat Order</h1>

    <div class="flex flex-col gap-3">
        @forelse ($semuaOrder ?? [] as $item)
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
            <div class="border border-dashed border-gray-200 rounded-2xl p-10 text-center text-sm text-gray-400">
                Belum ada riwayat order sama sekali.
            </div>
        @endforelse
    </div>

    @if (isset($semuaOrder) && $semuaOrder instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="mt-6">
            {{ $semuaOrder->links() }}
        </div>
    @endif

@endsection