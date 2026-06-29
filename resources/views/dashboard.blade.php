<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda - PLNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.umd.min.js"></script>
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

        body{ background:#f0f2f7; display:flex; min-height:100vh; }

        .sidebar{
            width:230px; min-height:100vh; background:#fff;
            border-right:1px solid #e5e7eb; display:flex;
            flex-direction:column; position:fixed; top:0; left:0; z-index:100;
        }

        .sidebar-logo{
            height:64px; padding:0 20px; border-bottom:1px solid #e5e7eb;
            display:flex; align-items:center; gap:10px;
        }

        .sidebar-logo img{ height:70px; }

        .sidebar-nav{ padding:16px 12px; display:flex; flex-direction:column; gap:4px; flex:1; }

        .nav-item{
            display:flex; align-items:center; gap:12px; padding:10px 14px;
            border-radius:10px; font-size:14px; font-weight:500; color:#6b7280;
            cursor:pointer; text-decoration:none; transition:all 0.2s;
        }

        .nav-item:hover{ background:#f3f4f6; color:#374151; }
        .nav-item.active{ background:#173a84; color:#fff; }
        .nav-item svg{ width:18px; height:18px; flex-shrink:0; }

        .main{ margin-left:230px; flex:1; display:flex; flex-direction:column; min-height:100vh; }

        .topbar{
            height:64px; background:#fff; border-bottom:1px solid #e5e7eb;
            display:flex; align-items:center; padding:0 28px; gap:16px;
            position:sticky; top:0; z-index:50;
        }

        .search-box{ flex:1; max-width:420px; position:relative; }

        .search-box input{
            width:100%; padding:9px 16px 9px 40px; border:1px solid #e5e7eb;
            border-radius:999px; background:#f9fafb; font-size:13px; outline:none; color:#374151;
        }

        .search-box svg{
            position:absolute; left:13px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:#9ca3af;
        }

        .topbar-right{ margin-left:auto; display:flex; align-items:center; gap:12px; }

        .icon-btn{
            width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb;
            background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;
        }

        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }

        .btn-laporan{
            background:#173a84; color:#fff; border:none; border-radius:10px;
            padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer;
            white-space:nowrap; text-decoration:none; display:inline-flex; align-items:center;
            transition: background 0.2s;
        }
        .btn-laporan:hover{ background:#1e4ba8; }

        .content{ padding:28px; flex:1; }

        .page-header{ display:flex; align-items:flex-start; justify-content:space-between; margin-bottom:24px; }
        .page-header h1{ font-size:24px; font-weight:700; color:#111827; }
        .page-header p{ font-size:13px; color:#6b7280; margin-top:4px; max-width:560px; }

        .status-badge{
            display:flex; align-items:center; gap:8px; background:#fff;
            border:1px solid #e5e7eb; border-radius:999px; padding:8px 16px;
            font-size:12px; font-weight:600; color:#374151; white-space:nowrap;
        }

        .status-dot{ width:8px; height:8px; border-radius:50%; background:#22c55e; }

        .grid-top{
            display:grid; grid-template-columns:1fr 1fr;
            gap:20px; margin-bottom:20px; align-items:stretch;
        }

        .grid-bottom{
            display:grid; grid-template-columns:1fr 1fr;
            gap:20px; margin-bottom:20px; align-items:stretch;
        }

        .card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px; }

        .card-title{
            font-size:13px; font-weight:700; color:#111827;
            display:flex; align-items:center; gap:8px; margin-bottom:4px;
        }

        .card-sub{ font-size:12px; color:#9ca3af; margin-bottom:18px; }

        .alarm-inner{ display:flex; align-items:center; gap:28px; }

        .donut-wrap{ position:relative; width:190px; height:190px; flex-shrink:0; }

        .donut-center{
            position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); text-align:center;
        }

        .donut-center .num{ font-size:34px; font-weight:700; color:#111827; line-height:1; }
        .donut-center .lbl{ font-size:10px; color:#6b7280; margin-top:4px; line-height:1.4; }

        .alarm-table{ width:100%; }
        .alarm-table table{ width:100%; border-collapse:collapse; }

        .alarm-table th{
            font-size:11px; font-weight:600; color:#9ca3af; text-align:left;
            padding:5px 0; border-bottom:1px solid #f3f4f6;
        }

        .alarm-table th:last-child{ text-align:right; }

        .alarm-row td{
            padding:8px 0; font-size:12px; border-bottom:1px solid #f9fafb; vertical-align:middle;
        }

        .alarm-row td:last-child{ text-align:right; font-weight:700; font-size:14px; }

        .badge{
            display:inline-flex; align-items:center; gap:5px;
            padding:3px 8px; border-radius:6px; font-size:11px; font-weight:600;
        }

        .badge-red{ background:#fef2f2; color:#dc2626; }
        .badge-green{ background:#f0fdf4; color:#16a34a; }

        .badge-icon{
            width:16px; height:16px; border-radius:4px; display:inline-flex;
            align-items:center; justify-content:center; font-size:9px;
            font-weight:700; color:#fff; flex-shrink:0;
        }

        .bi-red{ background:#dc2626; }
        .bi-green{ background:#16a34a; }

        .alarm-summary{
            margin-top:20px; padding-top:16px; border-top:1px solid #f3f4f6;
            display:flex; gap:10px;
        }

        .alarm-summary-item{
            flex:1; border-radius:10px; padding:12px; text-align:center;
        }

        .alarm-summary-item .s-num{ font-size:22px; font-weight:700; line-height:1; }
        .alarm-summary-item .s-lbl{ font-size:11px; color:#9ca3af; margin-top:3px; }

        .rekapan-card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; }

        .rekapan-header{
            background:#173a84; padding:14px 20px;
            display:flex; align-items:center; justify-content:space-between;
        }

        .rekapan-header h2{ font-size:13px; font-weight:700; color:#fff; letter-spacing:0.3px; }

        .rekapan-count{
            background:rgba(255,255,255,0.2); color:#fff;
            font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;
        }

        .rekapan-body{ padding:16px; }

        .rekapan-item{
            border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px;
            margin-bottom:10px; display:flex; align-items:flex-start; gap:10px;
        }

        .rekapan-item:last-child{ margin-bottom:0; }

        .rekapan-bar{ width:4px; border-radius:4px; background:#22c55e; align-self:stretch; flex-shrink:0; }
        .rekapan-bar.down{ background:#dc2626; }

        .rekapan-info{ flex:1; }
        .rekapan-info strong{ font-size:13px; font-weight:600; color:#111827; display:block; margin-bottom:4px; }
        .rekapan-info p{ font-size:12px; color:#6b7280; line-height:1.7; }

        .edit-btn{
            background:none; border:none; cursor:pointer; color:#9ca3af; padding:2px;
            text-decoration:none; display:inline-flex; align-items:center;
        }
        .edit-btn:hover{ color:#374151; }

        .tabel-card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px; display:flex; flex-direction:column; }

        .tabel-title{
            font-size:14px; font-weight:700; color:#111827; margin-bottom:16px;
            text-align:center; letter-spacing:0.2px;
        }

        .tabel-filters{ display:flex; gap:10px; margin-bottom:16px; }

        .filter-search{ flex:1; position:relative; }

        .filter-search input{
            width:100%; padding:8px 12px 8px 34px; border:1px solid #e5e7eb;
            border-radius:8px; font-size:12px; color:#374151; outline:none; background:#fff;
        }

        .filter-search svg{
            position:absolute; left:10px; top:50%; transform:translateY(-50%);
            width:14px; height:14px; color:#9ca3af;
        }

        .filter-select{
            padding:8px 32px 8px 12px; border:1px solid #e5e7eb;
            border-radius:8px; font-size:12px; color:#374151; outline:none;
            background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 10px center;
            appearance:none; cursor:pointer; min-width:140px;
        }

        .penyebab-table{ width:100%; border-collapse:collapse; }

        .penyebab-table th{
            font-size:11px; font-weight:700; color:#6b7280; text-align:left;
            padding:10px 12px; border-bottom:2px solid #f3f4f6; text-transform:uppercase; letter-spacing:0.5px;
        }

        .penyebab-table td{
            padding:14px 12px; font-size:13px; color:#374151; border-bottom:1px solid #f9fafb;
        }

        .penyebab-table tr:last-child td{ border-bottom:none; }
        .penyebab-table .no-col{ color:#9ca3af; font-size:12px; width:40px; }
        .penyebab-table .penyebab-name{ font-weight:600; color:#111827; }
        .penyebab-table .freq-col{ font-weight:600; color:#374151; }

        .status-up{
            background:#dcfce7; color:#15803d; font-size:11px; font-weight:700;
            padding:4px 12px; border-radius:999px; display:inline-block;
        }

        .status-down{
            background:#fef2f2; color:#dc2626; font-size:11px; font-weight:700;
            padding:4px 12px; border-radius:999px; display:inline-block;
        }

        .tabel-footer{
            margin-top:14px; padding-top:12px; border-top:1px solid #f3f4f6;
            font-size:12px; color:#9ca3af;
        }

        .chart-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px;
            display:flex; flex-direction:column;
        }

        .chart-card-title{
            font-size:13px; font-weight:700; color:#111827;
            text-align:center; margin-bottom:16px;
        }

        .chart-wrap{ flex:1; position:relative; min-height:280px; }

        .page-footer{
            text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af;
            border-top:1px solid #e5e7eb; background:#fff; line-height:1.8;
        }

        .empty-state{ text-align:center; padding:30px 0; color:#9ca3af; font-size:13px; }

        @media(max-width:1024px){
            .grid-top, .grid-bottom{ grid-template-columns:1fr; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo-plnetwork.png') }}" alt="PLNetwork">
    </div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item active">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Beranda
        </a>
        <a href="/riwayat" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Riwayat
        </a>
        <a href="/laporan" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Laporan
        </a>
        <a href="/pengaturan" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan
        </a>
    </nav>
</aside>

<div class="main">

    <header class="topbar">
        <div class="search-box">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" placeholder="Cari alamat IP atau lokasi...">
        </div>
        <div class="topbar-right">
            <a href="/riwayat" class="icon-btn" title="Lihat Riwayat Gangguan">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </a>
            <a href="/pengaturan" class="icon-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            </a>
            <a href="/laporan" class="btn-laporan">+ Laporan Baru</a>
        </div>
    </header>

    <div class="content">

        <div class="page-header">
            <div>
                <h1>Dasbor Sistem</h1>
                <p>Pemantauan infrastruktur jaringan secara real-time untuk memastikan performa, stabilitas, dan ketersediaan sistem.</p>
            </div>
            <div class="status-badge">
                <div class="status-dot"></div>
                SISTEM BEROPERASI &bull; PEMBARUAN TERAKHIR: {{ now()->format('H:i') }} WIB
            </div>
        </div>

        <!-- ROW 1: Alarm + Rekapan Gangguan -->
        <div class="grid-top">

            <!-- ALARM SAAT INI -->
            <div class="card">
                <div class="card-title">🔔 ALARM SAAT INI</div>
                <div class="card-sub">Ringkasan status UP dan DOWN perangkat secara real-time.</div>
                <div class="alarm-inner">
                    <div class="donut-wrap">
                        <canvas id="donutChart"></canvas>
                        <div class="donut-center">
                            <div class="num">{{ $total }}</div>
                            <div class="lbl">Total<br>Perangkat</div>
                        </div>
                    </div>
                    <div class="alarm-table">
                        <table>
                            <thead>
                                <tr><th>Status Alarm</th><th>Jumlah</th></tr>
                            </thead>
                            <tbody>
                                <tr class="alarm-row">
                                    <td>
                                        <span class="badge badge-green"><span class="badge-icon bi-green">▲</span>UP (Normal)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Perangkat aktif & terhubung</small>
                                    </td>
                                    <td>{{ $totalUp }}</td>
                                </tr>
                                <tr class="alarm-row">
                                    <td>
                                        <span class="badge badge-red"><span class="badge-icon bi-red">▼</span>DOWN (Gangguan)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Perangkat tidak merespons</small>
                                    </td>
                                    <td>{{ $totalDown }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="alarm-summary">
                    <div class="alarm-summary-item" style="background:#f0fdf4;">
                        <div class="s-num" style="color:#16a34a;">{{ $totalUp }}</div>
                        <div class="s-lbl">UP</div>
                    </div>
                    <div class="alarm-summary-item" style="background:#fef2f2;">
                        <div class="s-num" style="color:#dc2626;">{{ $totalDown }}</div>
                        <div class="s-lbl">DOWN</div>
                    </div>
                </div>
            </div>

            <!-- REKAPAN GANGGUAN UP — dari database -->
            <div class="rekapan-card">
                <div class="rekapan-header">
                    <h2>REKAPAN GANGGUAN UP</h2>
                    <span class="rekapan-count">{{ $rekapanUp->count() }} Teratas</span>
                </div>
                <div class="rekapan-body">
                    @forelse($rekapanUp as $item)
                    <div class="rekapan-item">
                        <div class="rekapan-bar"></div>
                        <div class="rekapan-info">
                            <strong>{{ $item->gardu_induk }}</strong>
                            <p>
                                Status : UP<br>
                                IP : {{ $item->ip_address ?? '-' }}<br>
                                Penyebab : {{ $item->jenis_gangguan ?? '-' }}<br>
                                Waktu : {{ \Carbon\Carbon::parse($item->waktu_kejadian)->diffForHumans() }}
                            </p>
                        </div>
                        <a href="{{ route('riwayat.show', $item->id) }}" class="edit-btn">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                            </svg>
                        </a>
                    </div>
                    @empty
                    <div class="empty-state">
                        Belum ada laporan dengan status UP.
                    </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- ROW 2: Tabel + Chart -->
        <div class="grid-bottom">

            <!-- TABEL REKAPAN PENYEBAB GANGGUAN — dari database -->
            <div class="tabel-card">
                <div class="tabel-title">TABEL REKAPAN PENYEBAB GANGGUAN</div>
                <div class="tabel-filters">
                    <div class="filter-search">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari Penyebab Gangguan" oninput="filterTabel()">
                    </div>
                    <select class="filter-select" id="filterStatus" onchange="filterTabel()">
                        <option value="">Semua Status</option>
                        <option value="UP">UP</option>
                        <option value="DOWN">DOWN</option>
                    </select>
                </div>
                <table class="penyebab-table">
                    <thead>
                        <tr>
                            <th class="no-col">NO</th>
                            <th>PENYEBAB GANGGUAN</th>
                            <th>FREKUENSI</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody id="tabelBody">
                        @forelse($penyebabStats as $i => $row)
                        <tr data-penyebab="{{ strtoupper($row->jenis_gangguan) }}" data-status="{{ $row->status_jaringan }}">
                            <td class="no-col">{{ $i + 1 }}.</td>
                            <td class="penyebab-name">{{ strtoupper($row->jenis_gangguan ?? '-') }}</td>
                            <td class="freq-col">{{ $row->frekuensi }} KALI</td>
                            <td>
                                @if($row->status_jaringan === 'UP')
                                    <span class="status-up">UP</span>
                                @else
                                    <span class="status-down">DOWN</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="text-align:center;padding:20px;color:#9ca3af;font-size:13px;">
                                Belum ada data penyebab gangguan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="tabel-footer" id="showingInfo">
                    Showing 1 to {{ $penyebabStats->count() }} of {{ $penyebabStats->count() }} results
                </div>
            </div>

            <!-- CHART 24 JAM -->
            <div class="chart-card">
                <div class="chart-card-title">Pemantauan Alarm DOWN 24 Jam</div>
                <div class="chart-wrap">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

        </div>

    </div>

    <footer class="page-footer">
        <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
        <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
    </footer>

</div>

<script>
// ── DONUT CHART — dari database ──────────────────────────
const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [{{ $totalUp }}, {{ $totalDown }}],
            backgroundColor: ['#16a34a', '#dc2626'],
            borderWidth: 0,
            hoverOffset: 4
        }]
    },
    options: {
        cutout: '70%',
        plugins: { legend: { display: false } },
        responsive: true,
        maintainAspectRatio: true
    }
});

// ── LINE CHART — data DOWN 24 jam ─────────────────────────────
const lineCtx = document.getElementById('lineChart').getContext('2d');
const labels = ['00:00','02:00','04:00','06:00','08:00','10:00','12:00','14:00','16:00','18:00','20:00','22:00','24:00'];
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels,
        datasets: [
            {
                label: 'Jumlah Perangkat DOWN',
                data: {!! json_encode($chartDown) !!},
                borderColor: '#dc2626',
                backgroundColor: 'rgba(220,38,38,0.12)',
                fill: true,
                tension: 0.4,
                borderWidth: 2.5,
                pointRadius: 3,
                pointBackgroundColor: '#dc2626'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: { font: { size: 11 }, boxWidth: 14, padding: 10 }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y} perangkat DOWN`
                }
            }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 10 } } },
            y: {
                grid: { color: '#f3f4f6' },
                ticks: { font: { size: 10 }, stepSize: 1 },
                min: 0,
                title: { display: true, text: 'Jumlah DOWN', font: { size: 10 }, color: '#9ca3af' }
            }
        }
    }
});

// ── FILTER TABEL ─────────────────────────────────────────────
function filterTabel() {
    const keyword = document.getElementById('searchInput').value.toUpperCase().trim();
    const statusFilter = document.getElementById('filterStatus').value.toUpperCase();
    const rows = document.querySelectorAll('#tabelBody tr');

    let visibleCount = 0;
    let rowNumber = 1;

    rows.forEach(row => {
        const penyebab = row.getAttribute('data-penyebab') || '';
        const status   = row.getAttribute('data-status') || '';

        const matchKeyword = penyebab.includes(keyword);
        const matchStatus  = statusFilter === '' || status === statusFilter;

        if (matchKeyword && matchStatus) {
            row.style.display = '';
            const noCol = row.querySelector('.no-col');
            if (noCol) noCol.textContent = rowNumber + '.';
            rowNumber++;
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });

    const total = rows.length;
    const info = document.getElementById('showingInfo');
    if (visibleCount === 0) {
        info.textContent = 'Tidak ada hasil ditemukan';
    } else {
        info.textContent = `Showing 1 to ${visibleCount} of ${total} results`;
    }
}
</script>

</body>
</html>