@extends('layouts.dashboard')
@section('title', 'Pesan Layanan')

@section('content')

    <h1 class="text-xl font-bold text-gray-900 mb-1">Pesan Layanan Baru</h1>
    <p class="text-sm text-gray-500 mb-6">Pilih kategori layanan yang kamu butuhkan.</p>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('order.store') }}" class="space-y-5 max-w-lg">
        @csrf

        <div>
            <label class="text-xs font-medium text-gray-600">Kategori Layanan</label>
            <select name="id_kategori" class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
                <option value="">Pilih kategori</option>
                @foreach ($kategori ?? [] as $k)
                    <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">Deskripsi Kerusakan / Kebutuhan</label>
            <textarea name="deskripsi" rows="4" placeholder="Jelaskan masalah yang kamu alami..."
                      class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900"></textarea>
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">Alamat Layanan</label>
            <input type="text" name="alamat_layanan" placeholder="Masukkan alamat lengkap"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">Tanggal & Jam yang Diinginkan</label>
            <input type="datetime-local" name="jadwal"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white font-semibold rounded-xl py-3 hover:bg-gray-800 transition">
            Kirim Pesanan
        </button>
    </form>

@endsection