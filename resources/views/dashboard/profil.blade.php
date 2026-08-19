@extends('layouts.dashboard')

@section('title', 'Profil Saya')

@section('content')

<div class="space-y-6">
    
    @if(session('success'))

        <div
            class="rounded-2xl
                   border border-green-200
                   bg-green-50
                   px-5 py-4">

            <div class="flex items-center gap-3">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5 text-green-600 shrink-0"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    viewBox="0 0 24 24">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"/>

                </svg>

                <span class="text-green-700 font-medium">
                    {{ session('success') }}
                </span>

            </div>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- VALIDATION ERROR --}}
    {{-- ===================================================== --}}

    @if($errors->any())

        <div
            class="rounded-2xl
                   border border-red-200
                   bg-red-50
                   px-5 py-4">

            <div class="space-y-1">

                @foreach($errors->all() as $error)

                    <p class="text-sm text-red-700">
                        {{ $error }}
                    </p>

                @endforeach

            </div>

        </div>

    @endif


    {{-- ===================================================== --}}
    {{-- PROFILE CARD --}}
    {{-- ===================================================== --}}

    <div
        class="bg-white
               rounded-3xl
               border border-slate-200
               shadow-sm
               overflow-hidden">


        {{-- ================================================= --}}
        {{-- PROFILE HEADER --}}
        {{-- ================================================= --}}

        <div
            class="bg-sky-50
                   px-7 py-6
                   border-b border-sky-100">

            <div
                class="flex
                       items-center
                       justify-between
                       gap-5">


                {{-- USER INFO --}}

                <div class="flex items-center gap-5">

                    {{-- ICON --}}

                    <div
                        class="w-16 h-16
                               rounded-full
                               bg-sky-100
                               flex
                               items-center
                               justify-center
                               shrink-0">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-8 h-8 text-sky-600"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.8"
                            viewBox="0 0 24 24">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M20 21a8 8 0 00-16 0"/>

                            <circle
                                cx="12"
                                cy="7"
                                r="4"/>

                        </svg>

                    </div>


                    {{-- NAME --}}

                    <div>

                        <h2
                            class="text-2xl
                                   font-bold
                                   text-slate-800">

                            {{ auth()->user()->nama }}

                        </h2>

                        <p
                            class="text-slate-500
                                   mt-1">

                            {{ ucfirst(auth()->user()->role_user) }}

                        </p>

                    </div>

                </div>


                {{-- EDIT BUTTON --}}

                <button
                    type="button"
                    onclick="toggleEditProfile()"
                    class="inline-flex
                           items-center
                           gap-2
                           px-5 py-3
                           rounded-xl
                           bg-gradient-to-r
                           from-sky-500
                           to-blue-600
                           hover:from-sky-600
                           hover:to-blue-700
                           text-white
                           font-semibold
                           shadow-md
                           transition
                           shrink-0">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        viewBox="0 0 24 24">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M12 20h9"/>

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/>

                    </svg>

                    Edit Profil

                </button>

            </div>

        </div>


        {{-- ================================================= --}}
        {{-- PROFILE INFORMATION --}}
        {{-- ================================================= --}}

        <div class="px-7 py-5">

            {{-- VIEW MODE --}}

            <div
                id="profileView"
                class="divide-y divide-slate-100">


                {{-- NAMA --}}

                <div class="py-4 first:pt-0">

                    <p
                        class="text-sm
                               text-slate-400">

                        Nama Lengkap

                    </p>

                    <p
                        class="text-base
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ auth()->user()->nama }}

                    </p>

                </div>


                {{-- EMAIL --}}

                <div class="py-4">

                    <p
                        class="text-sm
                               text-slate-400">

                        Email

                    </p>

                    <p
                        class="text-base
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ auth()->user()->email }}

                    </p>

                </div>


                {{-- TELEPON --}}

                <div class="py-4">

                    <p
                        class="text-sm
                               text-slate-400">

                        No. Telepon / WhatsApp

                    </p>

                    <p
                        class="text-base
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ auth()->user()->no_hp }}

                    </p>

                </div>


                {{-- ALAMAT --}}

                <div class="py-4 last:pb-0">

                    <p
                        class="text-sm
                               text-slate-400">

                        Alamat

                    </p>

                    <p
                        class="text-base
                               font-semibold
                               text-slate-800
                               mt-1">

                        {{ auth()->user()->alamat }}

                    </p>

                </div>

            </div>


            {{-- ================================================= --}}
            {{-- EDIT MODE --}}
            {{-- ================================================= --}}

            <div
                id="profileEdit"
                class="hidden">

                <form
                    method="POST"
                    action="{{ route('profil.update') }}"
                    class="space-y-5">

                    @csrf

                    @method('PUT')


                    {{-- NAMA --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-medium
                                   text-slate-600
                                   mb-2">

                            Nama Lengkap

                        </label>

                        <input
                            type="text"
                            name="nama"
                            value="{{ old('nama', auth()->user()->nama) }}"
                            class="w-full
                                   rounded-xl
                                   border border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-800
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-sky-500
                                   focus:border-sky-500">

                    </div>


                    {{-- EMAIL --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-medium
                                   text-slate-600
                                   mb-2">

                            Email

                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', auth()->user()->email) }}"
                            class="w-full
                                   rounded-xl
                                   border border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-800
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-sky-500
                                   focus:border-sky-500">

                    </div>


                    {{-- TELEPON --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-medium
                                   text-slate-600
                                   mb-2">

                            No. Telepon / WhatsApp

                        </label>

                        <input
                            type="text"
                            name="no_hp"
                            value="{{ old('no_hp', auth()->user()->no_hp) }}"
                            class="w-full
                                   rounded-xl
                                   border border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-800
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-sky-500
                                   focus:border-sky-500">

                    </div>


                    {{-- ALAMAT --}}

                    <div>

                        <label
                            class="block
                                   text-sm
                                   font-medium
                                   text-slate-600
                                   mb-2">

                            Alamat

                        </label>

                        <textarea
                            name="alamat"
                            rows="3"
                            class="w-full
                                   rounded-xl
                                   border border-slate-200
                                   px-4 py-3
                                   text-sm
                                   text-slate-800
                                   resize-none
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-sky-500
                                   focus:border-sky-500">{{ old('alamat', auth()->user()->alamat) }}</textarea>

                    </div>


                    {{-- BUTTON --}}

                    <div
                        class="flex
                               items-center
                               justify-end
                               gap-3
                               pt-2">

                        <button
                            type="button"
                            onclick="toggleEditProfile()"
                            class="px-5 py-3
                                   rounded-xl
                                   border border-slate-200
                                   text-slate-600
                                   font-semibold
                                   hover:bg-slate-50
                                   transition">

                            Batal

                        </button>


                        <button
                            type="submit"
                            class="px-5 py-3
                                   rounded-xl
                                   bg-gradient-to-r
                                   from-sky-500
                                   to-blue-600
                                   hover:from-sky-600
                                   hover:to-blue-700
                                   text-white
                                   font-semibold
                                   shadow-md
                                   transition">

                            Simpan Perubahan

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


{{-- ===================================================== --}}
{{-- JAVASCRIPT --}}
{{-- ===================================================== --}}

<script>

function toggleEditProfile()
{
    const view = document.getElementById('profileView');
    const edit = document.getElementById('profileEdit');

    view.classList.toggle('hidden');
    edit.classList.toggle('hidden');
}

</script>

@endsection