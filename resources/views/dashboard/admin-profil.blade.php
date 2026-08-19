@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')

<div class="space-y-6">

    {{-- ALERT SUCCESS --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- ALERT ERROR --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">
            <p class="mb-2 font-semibold text-red-700">Terdapat kesalahan:</p>
            <ul class="list-disc pl-5 text-sm text-red-600">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- ===================================================== --}}
    {{-- PROFILE CARD --}}
    {{-- ===================================================== --}}

    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        {{-- ================================================= --}}
        {{-- PROFILE HEADER --}}
        {{-- ================================================= --}}

        <div class="bg-sky-50 px-7 py-6 border-b border-sky-100">

            <div class="flex items-center justify-between gap-5">

                {{-- USER INFO --}}
                <div class="flex items-center gap-5">

                    {{-- ICON AVATAR --}}
                    <div class="w-16 h-16 rounded-full bg-sky-100 flex items-center justify-center shrink-0">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-sky-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20 21a8 8 0 00-16 0"
                            />
                            <circle cx="12" cy="7" r="4"/>
                        </svg>
                    </div>

                    {{-- NAME & ROLE --}}
                    <div>
                        <h2 class="text-2xl font-bold text-slate-800">
                            {{ $user->nama }}
                        </h2>

                        <p class="text-slate-500 mt-1">
                            Administrator Utama
                        </p>
                    </div>

                </div>

                {{-- EDIT BUTTON --}}
                <button
                    type="button"
                    onclick="toggleEditProfile()"
                    class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold shadow-md transition shrink-0"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>
                    </svg>

                    <span>Edit Profil</span>
                </button>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PROFILE INFORMATION --}}
        {{-- ================================================= --}}

        <div class="px-7 py-5">

            {{-- VIEW MODE --}}
            <div id="profileView" class="divide-y divide-slate-100">

                {{-- NAMA LENGKAP --}}
                <div class="py-4 first:pt-0">
                    <p class="text-sm text-slate-400">
                        Nama Lengkap
                    </p>

                    <p class="text-base font-semibold text-slate-800 mt-1">
                        {{ $user->nama }}
                    </p>
                </div>

                {{-- ALAMAT EMAIL --}}
                <div class="py-4">
                    <p class="text-sm text-slate-400">
                        Alamat Email
                    </p>

                    <p class="text-base font-semibold text-slate-800 mt-1">
                        {{ $user->email }}
                    </p>
                </div>

                {{-- NO TELEPON --}}
                <div class="py-4">
                    <p class="text-sm text-slate-400">
                        No. Telepon / WhatsApp
                    </p>

                    <p class="text-base font-semibold text-slate-800 mt-1">
                        {{ $user->no_hp ?? '-' }}
                    </p>
                </div>

                {{-- ALAMAT --}}
                <div class="py-4 last:pb-0">
                    <p class="text-sm text-slate-400">
                        Alamat Operasional / Domisili
                    </p>

                    <p class="text-base font-semibold text-slate-800 mt-1">
                        {{ $user->alamat ?? '-' }}
                    </p>
                </div>

            </div>


            {{-- EDIT MODE --}}
            <div id="profileEdit" class="hidden">

                <form method="POST" action="{{ route('admin.profil.update') }}" class="space-y-5">
                    @csrf
                    @method('PUT')

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama', $user->nama) }}"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none"
                        >
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- EMAIL --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                Alamat Email
                            </label>

                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none"
                            >
                        </div>

                        {{-- TELEPON --}}
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-2">
                                No. Telepon / WhatsApp
                            </label>

                            <input
                                type="text"
                                name="no_hp"
                                value="{{ old('no_hp', $user->no_hp) }}"
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none"
                            >
                        </div>
                    </div>

                    {{-- ALAMAT --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-2">
                            Alamat Operasional / Domisili
                        </label>

                        <textarea
                            name="alamat"
                            rows="3"
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none resize-none"
                        >{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    {{-- UBAH PASSWORD --}}
                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div>
                            <h4 class="text-sm font-bold text-slate-800 uppercase tracking-wider">
                                Ubah Password (Opsional)
                            </h4>
                            <p class="text-xs text-slate-400 mt-0.5">
                                Biarkan kosong jika tidak ingin mengemas password baru.
                            </p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Password Baru
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    placeholder="Minimal 8 karakter"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none"
                                >
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-600 mb-2">
                                    Konfirmasi Password Baru
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    placeholder="Ulangi password baru"
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 text-slate-800 text-sm focus:ring-2 focus:ring-sky-500 focus:border-sky-500 focus:outline-none"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- TOMBOL ACTION --}}
                    <div class="flex items-center justify-end gap-3 pt-4">
                        <button
                            type="button"
                            onclick="toggleEditProfile()"
                            class="px-5 py-3 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition"
                        >
                            Batal
                        </button>

                        <button
                            type="submit"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white text-sm font-semibold shadow-md transition"
                        >
                            Simpan Perubahan
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
    function toggleEditProfile() {
        const view = document.getElementById('profileView');
        const edit = document.getElementById('profileEdit');

        if (view.classList.contains('hidden')) {
            view.classList.remove('hidden');
            edit.classList.add('hidden');
        } else {
            view.classList.add('hidden');
            edit.classList.remove('hidden');
        }
    }

    @if($errors->any())
        document.addEventListener('DOMContentLoaded', function() {
            toggleEditProfile();
        });
    @endif
</script>

@endsection
