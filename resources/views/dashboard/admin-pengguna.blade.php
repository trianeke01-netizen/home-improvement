@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna - Admin')

@section('content')
<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Pengguna</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar seluruh akun pelanggan dan teknisi dalam sistem.</p>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.pengguna') }}" method="GET" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama / email / HP..." class="px-4 py-2 rounded-xl text-xs border border-slate-200 bg-white text-slate-800 w-48 sm:w-64 focus:ring-2 focus:ring-sky-500">
                <button type="submit" class="px-4 py-2 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-slate-800 transition">Cari</button>
            </form>
        </div>
    </div>

    {{-- FILTER ROLE --}}
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.pengguna') }}" class="px-4 py-2 rounded-xl text-xs font-semibold {{ !$role ? 'bg-sky-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Semua Peran</a>
        <a href="{{ route('admin.pengguna', ['role' => 'pelanggan']) }}" class="px-4 py-2 rounded-xl text-xs font-semibold {{ $role === 'pelanggan' ? 'bg-sky-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Pelanggan</a>
        <a href="{{ route('admin.pengguna', ['role' => 'teknisi']) }}" class="px-4 py-2 rounded-xl text-xs font-semibold {{ $role === 'teknisi' ? 'bg-sky-600 text-white' : 'bg-white border border-slate-200 text-slate-600' }}">Teknisi</a>
    </div>

    {{-- TABEL PENGGUNA --}}
    <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-100">
                    <tr>
                        <th class="p-4">Nama User</th>
                        <th class="p-4">Role</th>
                        <th class="p-4">Kontak (HP & Email)</th>
                        <th class="p-4">Alamat</th>
                        <th class="p-4">Status / Keahlian</th>
                        <th class="p-4">Aksi WhatsApp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-4 font-bold text-slate-800 text-sm">
                                {{ $u->nama }}
                            </td>
                            <td class="p-4">
                                <span class="px-2.5 py-1 rounded-full font-bold text-[11px] 
                                    @if($u->role_user === 'admin') bg-purple-100 text-purple-700
                                    @elseif($u->role_user === 'teknisi') bg-sky-100 text-sky-700
                                    @else bg-blue-100 text-blue-700 @endif">
                                    {{ ucfirst($u->role_user) }}
                                </span>
                            </td>
                            <td class="p-4">
                                <p class="font-semibold text-slate-800">{{ $u->no_hp }}</p>
                                <p class="text-slate-400 text-[11px]">{{ $u->email }}</p>
                            </td>
                            <td class="p-4 text-slate-700 max-w-xs truncate">
                                {{ $u->alamat }}
                            </td>
                            <td class="p-4">
                                @if($u->isTeknisi() && $u->profileTeknisi)
                                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 text-amber-700 font-medium text-[11px] block w-fit mb-1">
                                        Status: {{ $u->profileTeknisi->status_verifikasi }}
                                    </span>
                                    <span class="text-slate-500 text-[11px]">
                                        Sub: {{ $u->profileTeknisi->subCategory->nama_sub_kategori ?? '-' }}
                                    </span>
                                @else
                                    <span class="text-slate-400 font-medium">-</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <a href="{{ $u->getWhatsappLinkWithMessage('Halo ' . $u->nama . ', saya Admin Home Improvement.') }}" target="_blank" class="px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-semibold text-xs transition inline-flex items-center gap-1">
                                    💬 Chat WA
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400">Tidak ada pengguna ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
