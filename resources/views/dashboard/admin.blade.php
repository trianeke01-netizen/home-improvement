@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')

@php
    $jumlahPengguna = \App\Models\User::count();
    $jumlahTeknisi = \App\Models\User::where('role_user', 'teknisi')->count();
    $jumlahMenunggu = \App\Models\ProfileTeknisi::where('status_verifikasi', 'Menunggu')->count();
@endphp

<div class="space-y-6">

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-semibold text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-xs font-semibold text-red-800">
            {{ session('error') }}
        </div>
    @endif

    {{-- =========================================================
         4 STATISTIK UTAMA (MENUNGGU, DIPROSES, SELESAI, DIBATALKAN)
         ========================================================= --}}

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- MENUNGGU --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    MENUNGGU
                </p>
                <p class="mt-2 text-3xl font-extrabold text-amber-500">
                    {{ $orderMenunggu ?? 0 }}
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-amber-50 text-amber-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 7v5l3 2"/>
                </svg>
            </div>
        </div>

        {{-- DIPROSES --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    DIPROSES
                </p>
                <p class="mt-2 text-3xl font-extrabold text-blue-600">
                    {{ $sedangDikerjakan ?? $orderDikerjakan ?? 0 }}
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 6v6l4 2"/>
                </svg>
            </div>
        </div>

        {{-- SELESAI --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    SELESAI
                </p>
                <p class="mt-2 text-3xl font-extrabold text-emerald-600">
                    {{ $pesananSelesai ?? $orderSelesai ?? 0 }}
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </div>

        {{-- DIBATALKAN --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-wider text-slate-400">
                    DIBATALKAN
                </p>
                <p class="mt-2 text-3xl font-extrabold text-red-500">
                    {{ $pesananDibatalkan ?? $orderDibatalkan ?? 0 }}
                </p>
            </div>

            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 text-red-500 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- =========================================================
         GRID 2x2 STATISTIK (GRAFIK PESANAN, KATEGORI, TOP LAYANAN, PENDAPATAN)
         ========================================================= --}}

    {{-- BARIS 1: GRAFIK PESANAN & PESANAN PER KATEGORI --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- GRAFIK PESANAN --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-4">
                <h3 class="text-base font-bold text-slate-900">Grafik Pesanan</h3>
                <select class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 outline-none shadow-2xs">
                    <option value="minggu">Per Minggu</option>
                    <option value="bulan">Per Bulan</option>
                </select>
            </div>

            {{-- CHART CANVAS --}}
            <div class="relative h-64 w-full">
                <canvas id="chartPesanan"></canvas>
            </div>
        </div>

        {{-- PESANAN PER KATEGORI --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">Pesanan per Kategori</h3>
            </div>

            @php
                $kategoriStatistik = $kategoriStatistik ?? collect();
                $totalKatSum = $kategoriStatistik->sum('jumlah');
                if ($totalKatSum <= 0) $totalKatSum = 1;

                $catNames = [];
                $catCounts = [];
                $catColors = ['#7c65c1', '#72b5d7', '#f6d563', '#a1d6be', '#e57a7a'];

                foreach($kategoriStatistik as $idx => $kat) {
                    $catNames[] = $kat->nama_kategori;
                    $catCounts[] = $kat->jumlah;
                }

                if (empty($catNames)) {
                    $catNames = ['Layanan'];
                    $catCounts = [0];
                }
            @endphp

            <div class="flex flex-col sm:flex-row items-center gap-6 my-auto">
                {{-- DONUT CANVAS --}}
                <div class="relative h-44 w-44 shrink-0 mx-auto sm:mx-0">
                    <canvas id="chartKategori"></canvas>
                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                        <span class="text-xs font-bold text-slate-700">
                            {{ $totalOrder }} Order
                        </span>
                    </div>
                </div>

                {{-- LEGEND LIST --}}
                <div class="w-full flex-1 space-y-3">
                    @forelse($kategoriStatistik as $idx => $kat)
                        @php
                            $pct = round(($kat->jumlah / $totalKatSum) * 100);
                            $dotColor = $catColors[$idx % count($catColors)];
                        @endphp
                        <div class="flex items-center justify-between text-xs">
                            <div class="flex items-center gap-2.5 text-slate-700 font-medium">
                                <span class="h-3 w-3 rounded-full shrink-0" style="background-color: {{ $dotColor }};"></span>
                                <span class="font-semibold text-slate-800">{{ $kat->nama_kategori }}</span>
                            </div>
                            <span class="font-bold text-slate-900">{{ $kat->jumlah }} ({{ $pct }}%)</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center">Belum ada data pesanan kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- BARIS 2: TOP 5 LAYANAN & RINGKASAN PENDAPATAN --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-2">

        {{-- TOP 5 LAYANAN TERBANYAK --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">Top 5 Layanan Terbanyak</h3>
            </div>

            @php
                $topLayanan = $topLayanan ?? collect();
            @endphp

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 text-[11px] font-bold text-slate-600">
                            <th class="px-4 py-3 w-12 text-center">No.</th>
                            <th class="px-4 py-3">Layanan</th>
                            <th class="px-4 py-3 text-right">Jumlah Pesanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-800">
                        @forelse($topLayanan->take(5) as $index => $layanan)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-4 py-3.5 text-center text-slate-500 font-normal">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-bold text-slate-900">{{ $layanan->nama_sub_kategori }}</td>
                                <td class="px-4 py-3.5 text-right font-extrabold text-slate-900">{{ (int) ($layanan->jumlah_pesanan ?? 0) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400 text-xs">Belum ada data layanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- RINGKASAN PENDAPATAN --}}
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">Ringkasan Pendapatan</h3>
            </div>

            <div class="rounded-2xl border border-slate-100 bg-white divide-y divide-slate-100 text-xs">
                <div class="p-4 flex items-center justify-between">
                    <span class="font-medium text-slate-600">Total Pendapatan</span>
                    <span class="font-extrabold text-slate-900 text-sm">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <span class="font-medium text-slate-600">Rata-rata per Pesanan</span>
                    <span class="font-extrabold text-slate-900 text-sm">Rp {{ number_format($rataRataPerPesanan ?? 0, 0, ',', '.') }}</span>
                </div>

                <div class="p-4 flex items-center justify-between">
                    <span class="font-medium text-slate-600">Pendapatan Selesai</span>
                    <span class="font-extrabold text-slate-900 text-sm">Rp {{ number_format($pendapatanSelesai ?? 0, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-xl bg-slate-50 border border-slate-100 flex items-center gap-2 text-xs text-slate-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 8v4M12 16h.01"/>
                </svg>
                <span>Data pendapatan dihitung dari pesanan yang telah selesai.</span>
            </div>
        </div>

    </div>

</div>

@php
    $grafikLabelsJson = json_encode($grafikLabels ?? ['27 Apr - 3 Mei', '4 - 10 Mei', '11 - 17 Mei', '18 - 24 Mei', '25 - 27 Mei']);
    $grafikTotalJson = json_encode($grafikTotal ?? [20, 30, 42, 28, 16]);
    $grafikSelesaiJson = json_encode($grafikSelesai ?? [14, 22, 30, 18, 10]);

    $catNamesJson = json_encode($catNames);
    $catCountsJson = json_encode($catCounts);
    $catColorsSliceJson = json_encode(array_slice($catColors, 0, count($catNames)));
@endphp

{{-- SCRIPT CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // GRAFIK PESANAN (LINE CHART)
        const ctxLine = document.getElementById('chartPesanan').getContext('2d');
        const labelsLine = {!! $grafikLabelsJson !!};
        const dataTotal = {!! $grafikTotalJson !!};
        const dataSelesai = {!! $grafikSelesaiJson !!};

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: labelsLine,
                datasets: [
                    {
                        label: 'Total Pesanan',
                        data: dataTotal,
                        borderColor: '#312e81',
                        backgroundColor: 'rgba(49, 46, 129, 0.05)',
                        pointBackgroundColor: '#312e81',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Pesanan Selesai',
                        data: dataSelesai,
                        borderColor: '#c084fc',
                        backgroundColor: 'rgba(192, 132, 252, 0.05)',
                        pointBackgroundColor: '#c084fc',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        tension: 0.3,
                        borderWidth: 2.5
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        align: 'center',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 20,
                            font: {
                                size: 12,
                                weight: '600',
                                family: 'Inter'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: 50,
                        ticks: {
                            stepSize: 10,
                            font: {
                                size: 11,
                                family: 'Inter'
                            },
                            color: '#94a3b8'
                        },
                        grid: {
                            color: '#f1f5f9'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                                weight: '600',
                                family: 'Inter'
                            },
                            color: '#64748b'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // PESANAN PER KATEGORI (DONUT CHART)
        const ctxDonut = document.getElementById('chartKategori').getContext('2d');
        const catLabels = {!! $catNamesJson !!};
        const catData = {!! $catCountsJson !!};
        const catColors = {!! $catColorsSliceJson !!};

        new Chart(ctxDonut, {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catData,
                    backgroundColor: catColors,
                    borderWidth: 3,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    });
</script>

@endsection