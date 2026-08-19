@extends('layouts.dashboard')

@section('title', 'Statistik Layanan')

@section('content')

<style>
    .statistik-page {
        max-width: 1400px;
        margin: 0 auto;
    }

    .statistik-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 24px;
    }

    .statistik-title {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .statistik-subtitle {
        margin-top: 5px;
        font-size: 14px;
        color: #94a3b8;
    }

    .filter-form {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        border: 1px solid #dbe3ec;
        border-radius: 14px;
        padding: 10px 14px;
    }

    .filter-form input {
        border: none;
        outline: none;
        font-size: 13px;
        color: #334155;
        background: transparent;
    }

    .filter-form button {
        border: none;
        background: #0f172a;
        color: white;
        padding: 9px 16px;
        border-radius: 9px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .filter-form button:hover {
        background: #1e293b;
    }

    /* =========================================================
       STAT CARD
    ========================================================= */

    .stat-cards {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: white;
        border: 1px solid #dbe3ec;
        border-radius: 16px;
        padding: 20px;
        min-height: 138px;
        display: flex;
        align-items: flex-start;
        gap: 15px;
    }

    .stat-icon {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .stat-icon svg {
        width: 27px;
        height: 27px;
    }

    .icon-purple {
        background: #f1eafa;
        color: #7655a7;
    }

    .icon-blue {
        background: #e8f3fa;
        color: #4f91bc;
    }

    .icon-yellow {
        background: #fff4ca;
        color: #bd962f;
    }

    .icon-green {
        background: #e7f4ee;
        color: #559477;
    }

    .stat-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 5px;
    }

    .stat-number {
        font-size: 27px;
        line-height: 1;
        font-weight: 800;
        color: #111827;
    }

    .stat-change {
        margin-top: 13px;
        font-size: 12px;
        color: #64748b;
    }

    .change-up {
        color: #16a34a;
        font-weight: 700;
    }

    .change-down {
        color: #dc2626;
        font-weight: 700;
    }

    /* =========================================================
       GRID CONTENT
    ========================================================= */

    .stat-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.45fr) minmax(360px, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-box {
        background: white;
        border: 1px solid #dbe3ec;
        border-radius: 16px;
        overflow: hidden;
    }

    .box-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e5eaf0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .box-title {
        font-size: 17px;
        font-weight: 800;
        color: #111827;
        margin: 0;
    }

    .box-subtitle {
        font-size: 12px;
        color: #94a3b8;
        margin-top: 3px;
    }

    .period-select {
        border: 1px solid #dbe3ec;
        border-radius: 10px;
        padding: 8px 12px;
        font-size: 12px;
        color: #334155;
        background: white;
        outline: none;
    }

    /* =========================================================
       LINE CHART
    ========================================================= */

    .chart-wrapper {
        padding: 20px;
    }

    .chart-legend {
        display: flex;
        justify-content: center;
        gap: 25px;
        margin-bottom: 15px;
        font-size: 12px;
        color: #475569;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .legend-line {
        width: 17px;
        height: 4px;
        border-radius: 99px;
    }

    .legend-total {
        background: #3f227d;
    }

    .legend-selesai {
        background: #c489db;
    }

    .line-chart {
        width: 100%;
        height: 270px;
        position: relative;
    }

    .chart-y {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 30px;
        width: 40px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        font-size: 11px;
        color: #64748b;
    }

    .chart-area {
        position: absolute;
        left: 43px;
        right: 0;
        top: 0;
        bottom: 30px;
        border-bottom: 1px solid #cbd5e1;
        background:
            repeating-linear-gradient(
                to bottom,
                transparent 0,
                transparent calc(20% - 1px),
                #e5e7eb calc(20% - 1px),
                #e5e7eb 20%
            );
    }

    .chart-svg {
        width: 100%;
        height: 100%;
        overflow: visible;
    }

    .chart-labels {
        position: absolute;
        left: 43px;
        right: 0;
        bottom: 0;
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        text-align: center;
        gap: 4px;
    }

    .chart-labels span {
        font-size: 10px;
        color: #475569;
    }

    /* =========================================================
       DONUT
    ========================================================= */

    .category-content {
        padding: 22px 20px;
        min-height: 330px;
        display: flex;
        align-items: center;
        gap: 25px;
    }

    .donut {
        width: 185px;
        height: 185px;
        flex-shrink: 0;
        border-radius: 50%;
        position: relative;
        background: conic-gradient(
            #7960a9 0deg 97deg,
            #77a9ca 97deg 180deg,
            #ffd96b 180deg 250deg,
            #9dd0bb 250deg 307deg,
            #dc7777 307deg 360deg
        );
    }

    .donut::after {
        content: "";
        position: absolute;
        inset: 45px;
        background: white;
        border-radius: 50%;
    }

    .category-list {
        flex: 1;
    }

    .category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 17px;
    }

    .category-name {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 13px;
        color: #334155;
    }

    .category-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .category-value {
        font-size: 12px;
        font-weight: 700;
        color: #475569;
        white-space: nowrap;
    }

    .dot-1 { background: #7960a9; }
    .dot-2 { background: #77a9ca; }
    .dot-3 { background: #ffd96b; }
    .dot-4 { background: #9dd0bb; }
    .dot-5 { background: #dc7777; }

    /* =========================================================
       TOP 5
    ========================================================= */

    .top-services {
        margin-bottom: 22px;
    }

    .top-table-wrapper {
        padding: 18px 20px 20px;
    }

    .top-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        overflow: hidden;
        border: 1px solid #dbe3ec;
        border-radius: 10px;
    }

    .top-table th {
        background: #f8fafc;
        color: #334155;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 12px;
        border-bottom: 1px solid #dbe3ec;
    }

    .top-table td {
        padding: 11px 12px;
        font-size: 12px;
        color: #334155;
        border-bottom: 1px solid #e5eaf0;
    }

    .top-table tr:last-child td {
        border-bottom: none;
    }

    .top-table th:first-child,
    .top-table td:first-child {
        width: 60px;
        text-align: center;
    }

    .top-table th:last-child,
    .top-table td:last-child {
        width: 160px;
        text-align: center;
    }

    .rank-number {
        font-weight: 800;
        color: #64748b;
    }

    .service-name {
        font-weight: 600;
        color: #1e293b;
    }

    .service-count {
        font-weight: 700;
        color: #475569;
    }

    .progress-cell {
        min-width: 150px;
    }

    .progress-bar {
        height: 7px;
        width: 100%;
        border-radius: 99px;
        background: #e9edf2;
        overflow: hidden;
    }

    .progress-value {
        height: 100%;
        border-radius: 99px;
        background: #111827;
    }

    .empty-data {
        text-align: center;
        padding: 30px;
        color: #94a3b8;
        font-size: 13px;
    }

    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 1200px) {
        .stat-cards {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .stat-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 700px) {
        .statistik-header {
            flex-direction: column;
            align-items: stretch;
        }

        .statistik-title {
            font-size: 24px;
        }

        .stat-cards {
            grid-template-columns: 1fr;
        }

        .category-content {
            flex-direction: column;
        }

        .donut {
            width: 160px;
            height: 160px;
        }

        .donut::after {
            inset: 40px;
        }

        .top-table-wrapper {
            overflow-x: auto;
        }

        .top-table {
            min-width: 600px;
        }
    }
</style>


<div class="statistik-page">

    {{-- =========================================================
         HEADER
    ========================================================== --}}

    <div class="statistik-header">

        <div>
            <h1 class="statistik-title">
                Statistik Layanan
            </h1>
        </div>


        {{-- FILTER TANGGAL --}}

        <form
            action="{{ route('admin.statistik') }}"
            method="GET"
            class="filter-form"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <rect
                    x="3"
                    y="4"
                    width="18"
                    height="17"
                    rx="2"
                />

                <path d="M16 2v4M8 2v4M3 10h18"/>
            </svg>

            <input
                type="date"
                name="tanggal_mulai"
                value="{{ request('tanggal_mulai') }}"
            >

            <span class="text-slate-400 text-xs">
                -
            </span>

            <input
                type="date"
                name="tanggal_selesai"
                value="{{ request('tanggal_selesai') }}"
            >

            <button type="submit">
                Terapkan
            </button>

        </form>

    </div>


    {{-- =========================================================
         4 STATISTIK UTAMA
    ========================================================== --}}

    <div class="stat-cards">

        {{-- TOTAL PESANAN --}}

        <div class="stat-card">

            <div class="stat-icon icon-purple">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <rect
                        x="5"
                        y="3"
                        width="14"
                        height="18"
                        rx="2"
                    />

                    <path
                        stroke-linecap="round"
                        d="M9 3.5h6"
                    />

                    <path
                        stroke-linecap="round"
                        d="M9 9h6M9 13h6M9 17h3"
                    />
                </svg>

            </div>

            <div>

                <div class="stat-label">
                    Total Pesanan
                </div>

                <div class="stat-number">
                    {{ $totalPesanan ?? 0 }}
                </div>

                @if(isset($perubahanPesanan))
                    <div class="stat-change">
                        @if($perubahanPesanan >= 0)
                            <span class="change-up">
                                ▲ {{ abs($perubahanPesanan) }}%
                            </span>
                        @else
                            <span class="change-down">
                                ▼ {{ abs($perubahanPesanan) }}%
                            </span>
                        @endif

                        dari periode lalu
                    </div>
                @endif

            </div>

        </div>


        {{-- PESANAN SELESAI --}}

        <div class="stat-card">

            <div class="stat-icon icon-blue">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m8 12 2.5 2.5L16 9"
                    />
                </svg>

            </div>

            <div>

                <div class="stat-label">
                    Pesanan Selesai
                </div>

                <div class="stat-number">
                    {{ $pesananSelesai ?? 0 }}
                </div>

                @if(isset($perubahanSelesai))
                    <div class="stat-change">
                        @if($perubahanSelesai >= 0)
                            <span class="change-up">
                                ▲ {{ abs($perubahanSelesai) }}%
                            </span>
                        @else
                            <span class="change-down">
                                ▼ {{ abs($perubahanSelesai) }}%
                            </span>
                        @endif

                        dari periode lalu
                    </div>
                @endif

            </div>

        </div>


        {{-- SEDANG DIKERJAKAN --}}

        <div class="stat-card">

            <div class="stat-icon icon-yellow">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        d="M12 7v5l3 2"
                    />
                </svg>

            </div>

            <div>

                <div class="stat-label">
                    Sedang Dikerjakan
                </div>

                <div class="stat-number">
                    {{ $sedangDikerjakan ?? 0 }}
                </div>

                @if(isset($perubahanDikerjakan))
                    <div class="stat-change">
                        @if($perubahanDikerjakan >= 0)
                            <span class="change-up">
                                ▲ {{ abs($perubahanDikerjakan) }}%
                            </span>
                        @else
                            <span class="change-down">
                                ▼ {{ abs($perubahanDikerjakan) }}%
                            </span>
                        @endif

                        dari periode lalu
                    </div>
                @endif

            </div>

        </div>


        {{-- DIBATALKAN --}}

        <div class="stat-card">

            <div class="stat-icon icon-green">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7"
                >
                    <circle
                        cx="12"
                        cy="12"
                        r="9"
                    />

                    <path
                        stroke-linecap="round"
                        d="m9 9 6 6M15 9l-6 6"
                    />
                </svg>

            </div>

            <div>

                <div class="stat-label">
                    Dibatalkan
                </div>

                <div class="stat-number">
                    {{ $pesananDibatalkan ?? 0 }}
                </div>

                @if(isset($perubahanDibatalkan))
                    <div class="stat-change">
                        @if($perubahanDibatalkan >= 0)
                            <span class="change-up">
                                ▲ {{ abs($perubahanDibatalkan) }}%
                            </span>
                        @else
                            <span class="change-down">
                                ▼ {{ abs($perubahanDibatalkan) }}%
                            </span>
                        @endif

                        dari periode lalu
                    </div>
                @endif

            </div>

        </div>

    </div>


    {{-- =========================================================
         GRAFIK PESANAN + PESANAN PER KATEGORI
    ========================================================== --}}

    <div class="stat-grid">


        {{-- =====================================================
             GRAFIK PESANAN
        ====================================================== --}}

        <div class="stat-box">

            <div class="box-header">

                <div>
                    <h2 class="box-title">
                        Grafik Pesanan
                    </h2>

                    <p class="box-subtitle">
                        Perbandingan total pesanan dan pesanan selesai
                    </p>
                </div>

                <form
                    action="{{ route('admin.statistik') }}"
                    method="GET"
                >

                    @if(request('tanggal_mulai'))
                        <input
                            type="hidden"
                            name="tanggal_mulai"
                            value="{{ request('tanggal_mulai') }}"
                        >
                    @endif

                    @if(request('tanggal_selesai'))
                        <input
                            type="hidden"
                            name="tanggal_selesai"
                            value="{{ request('tanggal_selesai') }}"
                        >
                    @endif

                    <select
                        name="periode"
                        class="period-select"
                        onchange="this.form.submit()"
                    >

                        <option
                            value="minggu"
                            {{ request('periode', 'minggu') === 'minggu' ? 'selected' : '' }}
                        >
                            Per Minggu
                        </option>

                        <option
                            value="bulan"
                            {{ request('periode') === 'bulan' ? 'selected' : '' }}
                        >
                            Per Bulan
                        </option>

                    </select>

                </form>

            </div>


            <div class="chart-wrapper">

                <div class="chart-legend">

                    <div class="legend-item">
                        <span class="legend-line legend-total"></span>
                        Total Pesanan
                    </div>

                    <div class="legend-item">
                        <span class="legend-line legend-selesai"></span>
                        Pesanan Selesai
                    </div>

                </div>


                <div class="line-chart">

                    <div class="chart-y">

                        <span>50</span>
                        <span>40</span>
                        <span>30</span>
                        <span>20</span>
                        <span>10</span>
                        <span>0</span>

                    </div>


                    <div class="chart-area">

                        @php

                            $grafikLabels = $grafikLabels ?? [
                                'Minggu 1',
                                'Minggu 2',
                                'Minggu 3',
                                'Minggu 4',
                                'Minggu 5'
                            ];

                            $grafikTotal = $grafikTotal ?? [0, 0, 0, 0, 0];

                            $grafikSelesai = $grafikSelesai ?? [0, 0, 0, 0, 0];

                            $maxGrafik = max(
                                50,
                                ...$grafikTotal,
                                ...$grafikSelesai
                            );

                            $chartWidth = 100;
                            $chartHeight = 100;

                            $totalPoints = count($grafikTotal);

                            if ($totalPoints > 1) {
                                $step = $chartWidth / ($totalPoints - 1);
                            } else {
                                $step = 0;
                            }

                            $totalPolyline = [];

                            foreach ($grafikTotal as $i => $value) {

                                $x = $i * $step;

                                $y = $chartHeight -
                                    (($value / $maxGrafik) * $chartHeight);

                                $totalPolyline[] =
                                    round($x, 2) . ',' . round($y, 2);
                            }


                            $selesaiPolyline = [];

                            foreach ($grafikSelesai as $i => $value) {

                                $x = $i * $step;

                                $y = $chartHeight -
                                    (($value / $maxGrafik) * $chartHeight);

                                $selesaiPolyline[] =
                                    round($x, 2) . ',' . round($y, 2);
                            }

                        @endphp


                        <svg
                            class="chart-svg"
                            viewBox="0 0 100 100"
                            preserveAspectRatio="none"
                        >

                            {{-- GARIS TOTAL PESANAN --}}

                            <polyline
                                points="{{ implode(' ', $totalPolyline) }}"
                                fill="none"
                                stroke="#3f227d"
                                stroke-width="1.2"
                                vector-effect="non-scaling-stroke"
                            />

                            {{-- GARIS SELESAI --}}

                            <polyline
                                points="{{ implode(' ', $selesaiPolyline) }}"
                                fill="none"
                                stroke="#c489db"
                                stroke-width="1.2"
                                vector-effect="non-scaling-stroke"
                            />

                        </svg>


                        {{-- TITIK DATA --}}

                        <div
                            style="
                                position:absolute;
                                inset:0;
                                pointer-events:none;
                            "
                        >

                            @foreach($grafikTotal as $i => $value)

                                @php

                                    $left =
                                        $totalPoints > 1
                                        ? ($i / ($totalPoints - 1)) * 100
                                        : 50;

                                    $top =
                                        100 -
                                        (($value / $maxGrafik) * 100);

                                @endphp

                                <span
                                    style="
                                        position:absolute;
                                        width:9px;
                                        height:9px;
                                        border-radius:50%;
                                        background:#3f227d;
                                        left:calc({{ $left }}% - 4px);
                                        top:calc({{ $top }}% - 4px);
                                    "
                                ></span>

                            @endforeach


                            @foreach($grafikSelesai as $i => $value)

                                @php

                                    $left =
                                        $totalPoints > 1
                                        ? ($i / ($totalPoints - 1)) * 100
                                        : 50;

                                    $top =
                                        100 -
                                        (($value / $maxGrafik) * 100);

                                @endphp

                                <span
                                    style="
                                        position:absolute;
                                        width:9px;
                                        height:9px;
                                        border-radius:50%;
                                        background:#c489db;
                                        left:calc({{ $left }}% - 4px);
                                        top:calc({{ $top }}% - 4px);
                                    "
                                ></span>

                            @endforeach

                        </div>

                    </div>


                    <div class="chart-labels">

                        @foreach($grafikLabels as $label)

                            <span>
                                {{ $label }}
                            </span>

                        @endforeach

                    </div>

                </div>

            </div>

        </div>


        {{-- =====================================================
             PESANAN PER KATEGORI
        ====================================================== --}}

        <div class="stat-box">

            <div class="box-header">

                <div>
                    <h2 class="box-title">
                        Pesanan per Kategori
                    </h2>

                    <p class="box-subtitle">
                        Distribusi pesanan berdasarkan kategori layanan
                    </p>
                </div>

            </div>


            @php

                $kategoriStatistik =
                    $kategoriStatistik
                    ?? collect();

                $totalKategori =
                    $kategoriStatistik->sum('jumlah');

                if ($totalKategori <= 0) {
                    $totalKategori = 1;
                }

            @endphp


            <div class="category-content">


                {{-- DONUT --}}

                @php

                    $warnaKategori = [
                        '#7960a9',
                        '#77a9ca',
                        '#ffd96b',
                        '#9dd0bb',
                        '#dc7777'
                    ];

                    $startDeg = 0;

                    $gradientParts = [];

                    foreach ($kategoriStatistik as $index => $kategori) {

                        $jumlah = (int) ($kategori->jumlah ?? 0);

                        $persen =
                            ($jumlah / $totalKategori) * 100;

                        $endDeg =
                            $startDeg +
                            ($persen * 3.6);

                        $warna =
                            $warnaKategori[
                                $index % count($warnaKategori)
                            ];

                        $gradientParts[] =
                            "{$warna} {$startDeg}deg {$endDeg}deg";

                        $startDeg = $endDeg;
                    }

                    if (count($gradientParts) === 0) {
                        $gradientParts[] =
                            '#e2e8f0 0deg 360deg';
                    }

                @endphp


                <div
                    class="donut"
                    style="
                        background:
                        conic-gradient(
                            {{ implode(',', $gradientParts) }}
                        );
                    "
                ></div>


                {{-- LIST KATEGORI --}}

                <div class="category-list">

                    @forelse($kategoriStatistik as $index => $kategori)

                        @php

                            $jumlah =
                                (int) ($kategori->jumlah ?? 0);

                            $persen =
                                $totalKategori > 0
                                ? round(
                                    ($jumlah / $totalKategori) * 100
                                )
                                : 0;

                        @endphp

                        <div class="category-item">

                            <div class="category-name">

                                <span
                                    class="
                                        category-dot
                                        dot-{{ ($index % 5) + 1 }}
                                    "
                                ></span>

                                <span>
                                    {{ $kategori->nama_kategori ?? 'Kategori' }}
                                </span>

                            </div>

                            <div class="category-value">
                                {{ $jumlah }}
                                ({{ $persen }}%)
                            </div>

                        </div>

                    @empty

                        <div class="empty-data">
                            Belum ada data pesanan berdasarkan kategori.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- =========================================================
         TOP 5 LAYANAN & RINGKASAN PENDAPATAN
    ========================================================== --}}

    <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 mb-6">

        {{-- TOP 5 LAYANAN TERBANYAK --}}
        <div class="stat-box">

            <div class="box-header">

                <div>
                    <h2 class="box-title">
                        Top 5 Layanan Terbanyak
                    </h2>

                    <p class="box-subtitle">
                        Layanan yang paling banyak dipesan pelanggan
                    </p>
                </div>

            </div>


            @php

                $topLayanan =
                    $topLayanan
                    ?? collect();

                $maxOrder =
                    $topLayanan->max('jumlah_pesanan') ?? 1;

                if ($maxOrder <= 0) {
                    $maxOrder = 1;
                }

            @endphp


            <div class="top-table-wrapper">

                @if($topLayanan->count() > 0)

                    <table class="top-table">

                        <thead>

                            <tr>

                                <th>
                                    No.
                                </th>

                                <th>
                                    Layanan
                                </th>

                                <th>
                                    Jumlah Pesanan
                                </th>

                                <th>
                                    Popularitas
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($topLayanan->take(5) as $index => $layanan)

                                @php

                                    $jumlahPesanan =
                                        (int) (
                                            $layanan->jumlah_pesanan
                                            ?? 0
                                        );

                                    $progress =
                                        ($jumlahPesanan / $maxOrder)
                                        * 100;

                                @endphp

                                <tr>

                                    <td>
                                        <span class="rank-number">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>

                                    <td>

                                        <span class="service-name">
                                            {{
                                                $layanan->nama_sub_kategori
                                                ?? 'Layanan'
                                            }}
                                        </span>

                                    </td>

                                    <td>

                                        <span class="service-count">
                                            {{ $jumlahPesanan }}
                                        </span>

                                    </td>

                                    <td class="progress-cell">

                                        <div class="progress-bar">

                                            <div
                                                class="progress-value"
                                                style="
                                                    width:
                                                    {{ $progress }}%;
                                                "
                                            ></div>

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @else

                    <div class="empty-data">
                        Belum ada data layanan yang dipesan.
                    </div>

                @endif

            </div>

        </div>


        {{-- RINGKASAN PENDAPATAN --}}
        <div class="stat-box flex flex-col justify-between">

            <div class="box-header">
                <div>
                    <h2 class="box-title">
                        Ringkasan Pendapatan
                    </h2>
                    <p class="box-subtitle">
                        Gambaran total omset dan performa keuangan
                    </p>
                </div>
                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <div class="p-6 space-y-5">

                {{-- TOTAL PENDAPATAN --}}
                <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-4">
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">
                        Total Pendapatan
                    </p>
                    <p class="mt-1 text-2xl font-black text-slate-900">
                        Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    {{-- RATA RATA PER PESANAN --}}
                    <div class="rounded-2xl border border-slate-100 bg-white p-4 shadow-xs">
                        <p class="text-xs font-medium text-slate-400">
                            Rata-rata per Pesanan
                        </p>
                        <p class="mt-1 text-base font-bold text-slate-800">
                            Rp {{ number_format($rataRataPerPesanan ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- PENDAPATAN SELESAI --}}
                    <div class="rounded-2xl border border-emerald-100 bg-emerald-50/50 p-4">
                        <p class="text-xs font-medium text-emerald-700">
                            Pendapatan Selesai
                        </p>
                        <p class="mt-1 text-base font-bold text-emerald-800">
                            Rp {{ number_format($pendapatanSelesai ?? 0, 0, ',', '.') }}
                        </p>
                    </div>

                </div>

            </div>

            <div class="border-t border-slate-100 px-6 py-4 bg-slate-50/50">
                <p class="text-xs text-slate-500 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-sky-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M12 16v-4m0-4h.01" />
                    </svg>
                    Data pendapatan dihitung dari pesanan yang telah selesai.
                </p>
            </div>

        </div>

    </div>

</div>

@endsection