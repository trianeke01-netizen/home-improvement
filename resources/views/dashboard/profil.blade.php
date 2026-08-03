@extends('layouts.dashboard')
@section('title', 'Profil Saya')

@section('content')

    <h1 class="text-xl font-bold text-gray-900 mb-6">Profil Saya</h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('profil.update') }}" class="space-y-5 max-w-lg">
        @csrf
        @method('PUT')

        <div>
            <label class="text-xs font-medium text-gray-600">Nama Lengkap</label>
            <input type="text" name="nama" value="{{ old('nama', auth()->user()->nama) }}"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">No. Telepon / WhatsApp</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', auth()->user()->no_hp) }}"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <div>
            <label class="text-xs font-medium text-gray-600">Alamat</label>
            <input type="text" name="alamat" value="{{ old('alamat', auth()->user()->alamat) }}"
                   class="mt-1.5 w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900">
        </div>

        <button type="submit" class="w-full bg-gray-900 text-white font-semibold rounded-xl py-3 hover:bg-gray-800 transition">
            Simpan Perubahan
        </button>
    </form>

@endsection