@extends('layouts.dashboard')

@section('title', 'Dashboard Admin')

@section('content')

@php
    $jumlahPengguna = \App\Models\User::count();
    $jumlahTeknisi = \App\Models\User::where('role_user', 'teknisi')->count();
    $jumlahMenunggu = \App\Models\ProfileTeknisi::where('status_verifikasi', 'Menunggu')->count();
@endphp

<div class="space-y-8">

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-xs font-semibold text-emerald-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-xs font-semibold text-red-800 flex items-center gap-2">
            <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @php
        $pengajuanBatalCount = $orderPengajuanBatal ?? \App\Models\Order::where('status', 'Pengajuan_Batal')->count();
    @endphp

    {{-- ALERT URGENT PENGAJUAN BATAL TEKNISI --}}
    @if($pengajuanBatalCount > 0)
        <div class="rounded-3xl border border-rose-200 bg-gradient-to-r from-rose-500 via-red-500 to-rose-600 p-6 text-white shadow-md flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center shrink-0 text-2xl">
                    🚨
                </div>
                <div>
                    <h4 class="font-bold text-lg text-white">Ada {{ $pengajuanBatalCount }} Pengajuan Kendala / Batal Teknisi!</h4>
                    <p class="text-rose-100 text-sm mt-0.5">Teknisi membutuhkan persetujuan Admin untuk melepaskan order & me-reassign teknisi pengganti.</p>
                </div>
            </div>
            <a href="{{ route('admin.orders', ['status' => 'Pengajuan_Batal']) }}" class="px-5 py-3 rounded-2xl bg-white text-rose-600 font-bold text-sm hover:bg-rose-50 transition shrink-0 shadow-sm flex items-center gap-2">
                <span>Tinjau Pengajuan Batal</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    @endif

    {{-- =========================================================
         5 STATISTIK UTAMA (MUAT 1 BARIS - 5 KOLOM)
         ========================================================= --}}

    <div class="grid grid-cols-5 gap-2 sm:gap-3.5">

        {{-- MENUNGGU --}}
        <a href="{{ route('admin.orders', ['status' => 'Menunggu']) }}" class="rounded-2xl border border-slate-200 bg-white p-3 sm:p-4.5 shadow-2xs flex items-center justify-between hover:border-amber-400 hover:shadow-md transition cursor-pointer group block">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-amber-600 transition truncate">
                    MENUNGGU
                </p>
                <p class="mt-1 text-xl sm:text-2xl font-extrabold text-amber-500">
                    {{ $orderMenunggu ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-500 shrink-0 group-hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 h-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 7v5l3 2"/>
                </svg>
            </div>
        </a>

        {{-- DIPROSES --}}
        <a href="{{ route('admin.orders', ['status' => 'Diproses']) }}" class="rounded-2xl border border-slate-200 bg-white p-3 sm:p-4.5 shadow-2xs flex items-center justify-between hover:border-blue-400 hover:shadow-md transition cursor-pointer group block">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-blue-600 transition truncate">
                    DIPROSES
                </p>
                <p class="mt-1 text-xl sm:text-2xl font-extrabold text-blue-600">
                    {{ $sedangDikerjakan ?? $orderDikerjakan ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-500 shrink-0 group-hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 h-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 6v6l4 2"/>
                </svg>
            </div>
        </a>

        {{-- PENGAJUAN BATAL --}}
        <a href="{{ route('admin.orders', ['status' => 'Pengajuan_Batal']) }}" class="rounded-2xl border {{ $pengajuanBatalCount > 0 ? 'border-rose-400 bg-rose-50/40 ring-2 ring-rose-100' : 'border-slate-200 bg-white' }} p-3 sm:p-4.5 shadow-2xs flex items-center justify-between hover:border-rose-500 hover:shadow-md transition cursor-pointer group block">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-rose-500 group-hover:text-rose-600 transition truncate">
                    PENGAJUAN BATAL
                </p>
                <p class="mt-1 text-xl sm:text-2xl font-extrabold text-rose-600">
                    {{ $pengajuanBatalCount }}
                </p>
            </div>

            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-rose-100 text-rose-600 shrink-0 group-hover:scale-105 transition text-base sm:text-lg">
                🚨
            </div>
        </a>

        {{-- SELESAI --}}
        <a href="{{ route('admin.orders', ['status' => 'Selesai']) }}" class="rounded-2xl border border-slate-200 bg-white p-3 sm:p-4.5 shadow-2xs flex items-center justify-between hover:border-emerald-400 hover:shadow-md transition cursor-pointer group block">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-emerald-600 transition truncate">
                    SELESAI
                </p>
                <p class="mt-1 text-xl sm:text-2xl font-extrabold text-emerald-600">
                    {{ $pesananSelesai ?? $orderSelesai ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 shrink-0 group-hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 h-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
        </a>

        {{-- DIBATALKAN --}}
        <a href="{{ route('admin.orders', ['status' => 'Dibatalkan']) }}" class="rounded-2xl border border-slate-200 bg-white p-3 sm:p-4.5 shadow-2xs flex items-center justify-between hover:border-red-400 hover:shadow-md transition cursor-pointer group block">
            <div class="min-w-0">
                <p class="text-[10px] sm:text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-red-600 transition truncate">
                    DIBATALKAN
                </p>
                <p class="mt-1 text-xl sm:text-2xl font-extrabold text-red-500">
                    {{ $pesananDibatalkan ?? $orderDibatalkan ?? 0 }}
                </p>
            </div>

            <div class="flex h-8 w-8 sm:h-10 sm:w-10 items-center justify-center rounded-xl bg-red-50 text-red-500 shrink-0 group-hover:scale-105 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 h-4 sm:h-5 sm:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </div>
        </a>

    </div>

    {{-- =========================================================
         GRID 2x2 STATISTIK (GRAFIK PESANAN & PESANAN PER KATEGORI)
         ========================================================= --}}

    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- GRAFIK PESANAN (7 COLUMNS ON LARGE SCREENS) --}}
        <div class="lg:col-span-7 rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between gap-3 mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Grafik Pesanan</h3>
                </div>
                <select id="filterGrafik" class="rounded-xl border border-slate-200 bg-slate-50 px-3.5 py-2 text-xs font-semibold text-slate-700 outline-none shadow-2xs cursor-pointer hover:bg-slate-100 transition">
                    <option value="minggu">Per Minggu</option>
                    <option value="bulan">Per Bulan</option>
                </select>
            </div>

            {{-- CHART CANVAS --}}
            <div class="relative h-64 w-full">
                <canvas id="chartPesanan"></canvas>
            </div>
        </div>

        {{-- PESANAN PER KATEGORI (5 COLUMNS ON LARGE SCREENS) --}}
        <div class="lg:col-span-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-4">
                <h3 class="text-base font-bold text-slate-900">Pesanan per Kategori</h3>
            </div>

            @php
                $kategoriStatistik = $kategoriStatistik ?? collect();
                $totalKatSum = $kategoriStatistik->sum('jumlah');
                if ($totalKatSum <= 0) $totalKatSum = 1;

                $catNames = [];
                $catCounts = [];
                $catColors = ['#6366f1', '#06b6d4', '#f59e0b', '#10b981', '#ef4444'];

                foreach($kategoriStatistik as $idx => $kat) {
                    $catNames[] = $kat->nama_kategori;
                    $catCounts[] = $kat->jumlah;
                }

                if (empty($catNames)) {
                    $catNames = ['Layanan'];
                    $catCounts = [0];
                }
            @endphp

            <div class="flex flex-col sm:flex-row items-center gap-6 my-auto pt-2 pb-2">
                {{-- DONUT CANVAS --}}
                <div class="relative h-44 w-44 shrink-0 mx-auto">
                    <canvas id="chartKategori"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-2xl font-extrabold text-slate-800">
                            {{ $totalOrder }}
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                            Order
                        </span>
                    </div>
                </div>

                {{-- LEGEND LIST --}}
                <div class="w-full flex-1 space-y-3 min-w-0">
                    @forelse($kategoriStatistik as $idx => $kat)
                        @php
                            $pct = round(($kat->jumlah / $totalKatSum) * 100);
                            $dotColor = $catColors[$idx % count($catColors)];
                        @endphp
                        <div class="flex items-center justify-between text-xs min-w-0">
                            <div class="flex items-center gap-2.5 text-slate-700 font-medium min-w-0 pr-2">
                                <span class="h-3 w-3 rounded-full shrink-0" style="background-color: {{ $dotColor }};"></span>
                                <span class="font-semibold text-slate-800 truncate">{{ $kat->nama_kategori }}</span>
                            </div>
                            <span class="font-bold text-slate-900 shrink-0 text-right whitespace-nowrap">{{ $kat->jumlah }} ({{ $pct }}%)</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-400 text-center py-4">Belum ada data pesanan kategori.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- BARIS 2: TOP 5 LAYANAN & RINGKASAN PENDAPATAN --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">

        {{-- TOP LAYANAN TERBANYAK (7 COLUMNS) --}}
        <div class="lg:col-span-7 rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-5">
                <h3 class="text-base font-bold text-slate-900">Top Layanan Terbanyak</h3>
            </div>

            @php
                $topLayanan = $topLayanan ?? collect();
            @endphp

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/80 text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-4 py-3 w-12 text-center rounded-l-xl">No.</th>
                            <th class="px-4 py-3">Layanan</th>
                            <th class="px-4 py-3 text-right rounded-r-xl">Jumlah Pesanan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs font-semibold text-slate-800">
                        @forelse($topLayanan->take(5) as $index => $layanan)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-4 py-3.5 text-center text-slate-400 font-bold">{{ $index + 1 }}</td>
                                <td class="px-4 py-3.5 font-bold text-slate-900">
                                    {{ $layanan->nama_sub_kategori }}
                                </td>
                                <td class="px-4 py-3.5 text-right">
                                    <span class="inline-block px-3 py-1 rounded-xl bg-sky-50 text-sky-700 font-extrabold text-xs">
                                        {{ (int) ($layanan->jumlah_pesanan ?? 0) }} Pesanan
                                    </span>
                                </td>
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

        {{-- RINGKASAN PENDAPATAN (5 COLUMNS) --}}
        <div class="lg:col-span-5 rounded-3xl border border-slate-200 bg-white p-6 shadow-xs flex flex-col justify-between">
            <div class="mb-5">
                <h3 class="text-base font-bold text-slate-900">Ringkasan Pendapatan</h3>
            </div>

            <div class="space-y-3 text-xs">
                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-9h6a2 2 0 010 4H9a2 2 0 000 4h6" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-medium text-slate-500 block text-[11px]">Total Pendapatan</span>
                            <span class="font-extrabold text-slate-900 text-base">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-medium text-slate-500 block text-[11px]">Rata-rata per Pesanan</span>
                            <span class="font-extrabold text-slate-900 text-base">Rp {{ number_format($rataRataPerPesanan ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <div class="p-4 rounded-2xl border border-slate-100 bg-slate-50/60 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-medium text-slate-500 block text-[11px]">Pendapatan Selesai</span>
                            <span class="font-extrabold text-slate-900 text-base">Rp {{ number_format($pendapatanSelesai ?? 0, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 p-3 rounded-2xl bg-sky-50/70 border border-sky-100 flex items-center gap-2.5 text-xs text-sky-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="9"/>
                    <path stroke-linecap="round" d="M12 8v4M12 16h.01"/>
                </svg>
                <span>Data pendapatan dihitung otomatis dari transaksi pesanan selesai.</span>
            </div>
        </div>

    </div>

</div>

@php
    $grafikLabelsJson = json_encode($grafikLabels ?? []);
    $grafikTotalJson = json_encode($grafikTotal ?? []);
    $grafikSelesaiJson = json_encode($grafikSelesai ?? []);

    $grafikBulanLabelsJson = json_encode($grafikBulanLabels ?? []);
    $grafikBulanTotalJson = json_encode($grafikBulanTotal ?? []);
    $grafikBulanSelesaiJson = json_encode($grafikBulanSelesai ?? []);

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
        
        const dataWeekly = {
            labels: {!! $grafikLabelsJson !!},
            total: {!! $grafikTotalJson !!},
            selesai: {!! $grafikSelesaiJson !!}
        };

        const dataMonthly = {
            labels: {!! $grafikBulanLabelsJson !!},
            total: {!! $grafikBulanTotalJson !!},
            selesai: {!! $grafikBulanSelesaiJson !!}
        };

        const lineChart = new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: dataWeekly.labels,
                datasets: [
                    {
                        label: 'Total Pesanan',
                        data: dataWeekly.total,
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.08)',
                        pointBackgroundColor: '#4f46e5',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true,
                        borderWidth: 2.5
                    },
                    {
                        label: 'Pesanan Selesai',
                        data: dataWeekly.selesai,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.08)',
                        pointBackgroundColor: '#10b981',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        tension: 0.3,
                        fill: true,
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
                        align: 'end',
                        labels: {
                            usePointStyle: true,
                            boxWidth: 8,
                            padding: 15,
                            font: {
                                size: 11,
                                weight: '600',
                                family: 'Inter'
                            }
                        }
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Inter', size: 12, weight: '700' },
                        bodyFont: { family: 'Inter', size: 11 },
                        padding: 10,
                        cornerRadius: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grace: '10%',
                        ticks: {
                            precision: 0,
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
                            maxRotation: 0,
                            minRotation: 0,
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

        // Handler perubahan dropdown filter
        const filterSelect = document.getElementById('filterGrafik');
        if (filterSelect) {
            filterSelect.addEventListener('change', function () {
                const selected = this.value;
                const targetData = selected === 'bulan' ? dataMonthly : dataWeekly;

                lineChart.data.labels = targetData.labels;
                lineChart.data.datasets[0].data = targetData.total;
                lineChart.data.datasets[1].data = targetData.selesai;
                lineChart.update();
            });
        }

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
                cutout: '75%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#0f172a',
                        titleFont: { family: 'Inter', size: 12, weight: '700' },
                        bodyFont: { family: 'Inter', size: 11 },
                        padding: 10,
                        cornerRadius: 10
                    }
                }
            }
        });
    });
</script>

@endsection