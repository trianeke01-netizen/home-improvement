@extends('layouts.dashboard')

@section('title', 'Profil Admin')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Profil Administrator</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data pribadi, kontak, dan kredensial akses akun admin</p>
        </div>
        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-violet-100 text-violet-700 border border-violet-200 w-fit">
            Administrator Utama
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 border border-red-200 text-red-800 text-sm">
            <p class="font-bold mb-1">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside space-y-1 text-xs">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- USER CARD LEFT --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 text-center shadow-sm space-y-4">
                <div class="w-24 h-24 rounded-full bg-gradient-to-tr from-slate-800 to-slate-950 text-white flex items-center justify-center text-3xl font-extrabold mx-auto shadow-md ring-4 ring-slate-100">
                    {{ strtoupper(substr($user->nama, 0, 2)) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-900">{{ $user->nama }}</h2>
                    <span class="mt-1 inline-block px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                        {{ ucfirst($user->role_user) }} System
                    </span>
                </div>

                <div class="border-t border-slate-100 pt-4 text-left space-y-3.5 text-xs">
                    <div>
                        <span class="text-slate-400 block font-medium">Email Terdaftar</span>
                        <span class="text-slate-800 font-bold block truncate mt-0.5">{{ $user->email }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">No. Telepon / WhatsApp</span>
                        <span class="text-slate-800 font-bold block mt-0.5">{{ $user->no_hp ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-400 block font-medium">Alamat Domisili / Operasional</span>
                        <span class="text-slate-800 font-semibold block leading-relaxed mt-0.5">{{ $user->alamat ?? '-' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- EDIT FORM RIGHT --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 shadow-sm">
                <div class="border-b border-slate-100 pb-4 mb-5">
                    <h3 class="text-base font-bold text-slate-900">Perbarui Informasi Profil</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Ubah data diri dan kata sandi akses akun Administrator</p>
                </div>

                <form action="{{ route('admin.profil.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $user->nama) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1.5">No. HP / WhatsApp</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat</label>
                        <textarea name="alamat" rows="3" required class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-4">
                        <div>
                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Keamanan Akun</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Kosongkan kolom password jika tidak ingin mengubah password akun</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Password Baru</label>
                                <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full px-4 py-3 rounded-xl border border-slate-200 text-xs font-medium text-slate-800 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 focus:outline-none transition bg-slate-50/50">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition shadow-md">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
