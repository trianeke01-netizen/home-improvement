<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pelanggan</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Work+Sans:wght@400;500;600&display=swap" rel="stylesheet">

    <style>

        body{
            font-family:'Work Sans',sans-serif;
            background:#f8f8f8;
        }

        .title{
            font-family:'Fraunces',serif;
        }

    </style>

</head>

<body>

<div class="min-h-screen flex">

    <!-- SIDEBAR -->

    <aside class="w-72 bg-white border-r flex flex-col">

        <div class="p-8 border-b">

            <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center border">

                <svg xmlns="http://www.w3.org/2000/svg"
                class="w-8 h-8 text-gray-500"
                fill="currentColor"
                viewBox="0 0 20 20">

                <path d="M10 10a4 4 0 100-8 4 4 0 000 8zm0 2c-3.3 0-6 2.7-6 6h12c0-3.3-2.7-6-6-6z"/>

                </svg>

            </div>

            <h2 class="font-bold text-xl mt-4">

                {{ Auth::user()->nama }}

            </h2>

            <p class="text-gray-500">

                Pelanggan

            </p>

        </div>

        <div class="p-4 space-y-2">

            <a href="#"
            class="block bg-black text-white rounded-xl px-5 py-3">

                Dashboard

            </a>

            <a href="#"
            class="block rounded-xl px-5 py-3 hover:bg-gray-100">

                Pesan Layanan

            </a>

            <a href="#"
            class="block rounded-xl px-5 py-3 hover:bg-gray-100">

                Riwayat Order

            </a>

            <a href="#"
            class="block rounded-xl px-5 py-3 hover:bg-gray-100">

                Profil Saya

            </a>

        </div>

        <div class="mt-auto p-4">

            <form action="{{ route('logout') }}" method="POST">

                @csrf

                <button
                class="w-full border rounded-xl py-3 hover:bg-gray-100">

                    Keluar

                </button>

            </form>

        </div>

    </aside>

    <!-- CONTENT -->

    <main class="flex-1 p-10">

        <h1 class="title text-3xl mb-8">

            Dashboard

        </h1>