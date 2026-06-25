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

        .sidebar-logo img{ height:45px; }

        .sidebar-nav{ padding:16px 12px; display:flex; flex-direction:column; gap:4px; flex:1; }

        .nav-item{
            display:flex; align-items:center; gap:12px; padding:10px 14px;
            border-radius:10px; font-size:14px; font-weight:500; color:#6b7280;
            cursor:pointer; text-decoration:none; transition:all 0.2s;
        }

        .nav-item:hover{ background:#f3f4f6; color:#374151; }
        .nav-item.active{ background:#173a84; color:#fff; }
        .nav-item svg{ width:18px; height:18px; flex-shrink:0; }

        .main{ margin-left:230px; flex:1; display:flex; flex-direction:column; min-height:100vh; justify-content:space-between; }

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
            padding:9px 18px; font-size:13px; font-weight:600; cursor:pointer; white-space:nowrap;
        }

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

        .grid-2{
            display:grid; grid-template-columns:1fr 1fr;
            gap:20px; margin-bottom:20px; align-items:stretch;
        }

        .card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:22px; }

        .card-title{
            font-size:13px; font-weight:700; color:#111827;
            display:flex; align-items:center; gap:8px; margin-bottom:4px;
        }

        .card-sub{ font-size:12px; color:#9ca3af; margin-bottom:18px; }

        /* --- ALARM SECTION REVAMPED --- */
        .alarm-inner{
            display:flex; align-items:center; gap:28px;
        }

        .donut-wrap{
            position:relative; width:190px; height:190px; flex-shrink:0;
        }

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
        .badge-orange{ background:#fff7ed; color:#ea580c; }
        .badge-yellow{ background:#fefce8; color:#ca8a04; }
        .badge-blue{ background:#eff6ff; color:#2563eb; }

        .badge-icon{
            width:16px; height:16px; border-radius:4px; display:inline-flex;
            align-items:center; justify-content:center; font-size:9px;
            font-weight:700; color:#fff; flex-shrink:0;
        }

        .bi-red{ background:#dc2626; }
        .bi-orange{ background:#ea580c; }
        .bi-yellow{ background:#ca8a04; }
        .bi-blue{ background:#2563eb; }

        .alarm-summary{
            margin-top:20px; padding-top:16px; border-top:1px solid #f3f4f6;
            display:flex; gap:10px;
        }

        .alarm-summary-item{
            flex:1; border-radius:10px; padding:12px; text-align:center;
        }

        .alarm-summary-item .s-num{ font-size:22px; font-weight:700; line-height:1; }
        .alarm-summary-item .s-lbl{ font-size:11px; color:#9ca3af; margin-top:3px; }

        .chart-wrap{ position:relative; height:300px; }

        .gangguan-card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; }

        .gangguan-header{
            background:#173a84; padding:14px 20px;
            display:flex; align-items:center; justify-content:space-between;
        }

        .gangguan-header h2{ font-size:13px; font-weight:700; color:#fff; letter-spacing:0.3px; }

        .gangguan-count{
            background:rgba(255,255,255,0.2); color:#fff;
            font-size:12px; font-weight:600; padding:4px 12px; border-radius:999px;
        }

        .gangguan-body{ padding:16px; }

        .gangguan-item{
            border:1px solid #e5e7eb; border-radius:10px; padding:12px 14px;
            margin-bottom:10px; display:flex; align-items:flex-start; gap:10px;
        }

        .gangguan-item:last-child{ margin-bottom:0; }

        .gangguan-bar{ width:4px; border-radius:4px; background:#22c55e; align-self:stretch; flex-shrink:0; }

        .gangguan-info{ flex:1; }
        .gangguan-info strong{ font-size:13px; font-weight:600; color:#111827; display:block; margin-bottom:4px; }
        .gangguan-info p{ font-size:12px; color:#6b7280; line-height:1.7; }

        .edit-btn{ background:none; border:none; cursor:pointer; color:#9ca3af; padding:2px; }
        .edit-btn:hover{ color:#374151; }

        /* --- LOKASI SECTION --- */
        .lokasi-header{
            display:flex; align-items:center; gap:8px;
            font-size:14px; font-weight:600; color:#111827; margin-bottom:14px;
        }

        .lokasi-item{
            display:flex; align-items:center; gap:12px;
            padding:10px 0; border-bottom:1px solid #f3f4f6;
        }

        .lokasi-item:last-child{ border-bottom:none; }

        .lokasi-badge{
            width:40px; height:40px; border-radius:10px; background:#173a84;
            color:#fff; font-size:10px; font-weight:700;
            display:flex; align-items:center; justify-content:center; flex-shrink:0;
        }

        .lokasi-badge.gi{ background:#0f766e; }
        .lokasi-badge.spv{ background:#7c3aed; }

        .lokasi-info{ flex:1; }
        .lokasi-info strong{ font-size:13px; font-weight:600; color:#111827; display:block; }
        .lokasi-info span{ font-size:11px; color:#9ca3af; }

        .lokasi-meta{ text-align:right; }

        .lokasi-tag{
            display:inline-block; padding:3px 10px; border-radius:999px;
            font-size:11px; font-weight:600; margin-bottom:3px;
        }

        .tag-red{ background:#fef2f2; color:#dc2626; }
        .tag-olive{ background:#f0fdf4; color:#15803d; }
        .tag-blue{ background:#eff6ff; color:#1d4ed8; }
        .tag-purple{ background:#faf5ff; color:#7c3aed; }
        .tag-orange{ background:#fff7ed; color:#ea580c; }

        .lokasi-time{ font-size:11px; color:#9ca3af; display:block; }

        .page-footer{
    text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af;
    border-top:1px solid #e5e7eb; background:#fff; line-height:1.8;
}

        @media(max-width:1024px){
            .grid-2{ grid-template-columns:1fr; }
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
            <div class="icon-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                </svg>
            </div>
            <div class="icon-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <button class="btn-laporan">+ Laporan Baru</button>
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
                SISTEM BEROPERASI &bull; PEMBARUAN TERAKHIR: 12:45 WIB
            </div>
        </div>

        <div class="grid-2">

            <!-- ALARM SAAT INI -->
            <div class="card">
                <div class="card-title">🔔 ALARM SAAT INI</div>
                <div class="card-sub">Ringkasan alarm aktif pada sistem secara real-time.</div>
                <div class="alarm-inner">
                    <div class="donut-wrap">
                        <canvas id="donutChart"></canvas>
                        <div class="donut-center">
                            <div class="num">15</div>
                            <div class="lbl">Total Alarm<br>Aktif</div>
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
                                        <span class="badge badge-red"><span class="badge-icon bi-red">!!</span>Down (Critical)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Kritis</small>
                                    </td>
                                    <td>5</td>
                                </tr>
                                <tr class="alarm-row">
                                    <td>
                                        <span class="badge badge-orange"><span class="badge-icon bi-orange">!</span>Down (Acknowledged)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Diakui</small>
                                    </td>
                                    <td>0</td>
                                </tr>
                                <tr class="alarm-row">
                                    <td>
                                        <span class="badge badge-yellow"><span class="badge-icon bi-yellow">W</span>Warning (Peringatan)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Peringatan</small>
                                    </td>
                                    <td>0</td>
                                </tr>
                                <tr class="alarm-row">
                                    <td>
                                        <span class="badge badge-blue"><span class="badge-icon bi-blue">U</span>Unusual (Tidak Normal)</span><br>
                                        <small style="color:#9ca3af;font-weight:400;font-size:10px;padding-left:4px;">Tidak Normal</small>
                                    </td>
                                    <td>11</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Summary boxes -->
                <div class="alarm-summary">
                    <div class="alarm-summary-item" style="background:#fef2f2;">
                        <div class="s-num" style="color:#dc2626;">5</div>
                        <div class="s-lbl">Kritis</div>
                    </div>
                    <div class="alarm-summary-item" style="background:#fff7ed;">
                        <div class="s-num" style="color:#ea580c;">0</div>
                        <div class="s-lbl">Diakui</div>
                    </div>
                    <div class="alarm-summary-item" style="background:#fefce8;">
                        <div class="s-num" style="color:#ca8a04;">0</div>
                        <div class="s-lbl">Peringatan</div>
                    </div>
                    <div class="alarm-summary-item" style="background:#eff6ff;">
                        <div class="s-num" style="color:#2563eb;">11</div>
                        <div class="s-lbl">Tidak Normal</div>
                    </div>
                </div>
            </div>

            <!-- GANGGUAN DIPERBAIKI -->
            <div class="gangguan-card">
                <div class="gangguan-header">
                    <h2>GANGGUAN YANG SUDAH DIPERBAIKI</h2>
                    <span class="gangguan-count">3 Teratas</span>
                </div>
                <div class="gangguan-body">
                    <div class="gangguan-item">
                        <div class="gangguan-bar"></div>
                        <div class="gangguan-info">
                            <strong>Investigasi ULP Natal New</strong>
                            <p>Status : Down<br>IP : 10.16.218.1<br>Gangguan : Ping Timeout<br>Durasi : 6 jam 7 menit</p>
                        </div>
                        <button class="edit-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                    </div>
                    <div class="gangguan-item">
                        <div class="gangguan-bar"></div>
                        <div class="gangguan-info">
                            <strong>Investigasi Gudang Logistik ULP Sidempuan</strong>
                            <p>Status : Down<br>IP : 10.16.219.1<br>Gangguan : Ping Timeout<br>Durasi : 1 jam 14 menit</p>
                        </div>
                        <button class="edit-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                    </div>
                    <div class="gangguan-item">
                        <div class="gangguan-bar"></div>
                        <div class="gangguan-info">
                            <strong>Investigasi GI Labuhan Bilik</strong>
                            <p>Status : Down<br>IP : 10.43.68.193<br>Gangguan : Ping Timeout<br>Durasi : 1 jam 22 menit</p>
                        </div>
                        <button class="edit-btn"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg></button>
                    </div>
                </div>
            </div>

        </div>

        <div class="grid-2">

            <!-- CHART 24 JAM -->
            <div class="card">
                <div class="card-title" style="justify-content:center;">Pemantauan Alarm 24 Jam</div>
                <div class="chart-wrap">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>

            <!-- LOKASI SERING TERJADI -->
            <div class="card">
                <div class="lokasi-header">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#173a84" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Lokasi Sering Terjadi
                </div>
                <div class="lokasi-item">
                    <div class="lokasi-badge">ULP</div>
                    <div class="lokasi-info"><strong>ULP GLUGUR</strong><span>10.16.176.1</span></div>
                    <div class="lokasi-meta"><span class="lokasi-tag tag-red">14 Termasuk</span><span class="lokasi-time">Terakhir : 2 Jam lalu</span></div>
                </div>
                <div class="lokasi-item">
                    <div class="lokasi-badge">ULP</div>
                    <div class="lokasi-info"><strong>ULP SIPIROK</strong><span>10.16.213.1</span></div>
                    <div class="lokasi-meta"><span class="lokasi-tag tag-olive">14 Termasuk</span><span class="lokasi-time">Terakhir : 2 Jam lalu</span></div>
                </div>
                <div class="lokasi-item">
                    <div class="lokasi-badge">ULP</div>
                    <div class="lokasi-info"><strong>ULTG KISARAN</strong><span>10.43.61.161</span></div>
                    <div class="lokasi-meta"><span class="lokasi-tag tag-blue">14 Termasuk</span><span class="lokasi-time">Terakhir : 2 Jam lalu</span></div>
                </div>
                <div class="lokasi-item">
                    <div class="lokasi-badge gi">GI</div>
                    <div class="lokasi-info"><strong>GI LABUHAN BILIK</strong><span>10.43.68.193</span></div>
                    <div class="lokasi-meta"><span class="lokasi-tag tag-orange">11 Termasuk</span><span class="lokasi-time">Terakhir : 3 Jam lalu</span></div>
                </div>
            </div>

    </div>

    <footer class="page-footer">
        <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
        <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
    </footer>

</div>

<script>
const donutCtx = document.getElementById('donutChart').getContext('2d');
new Chart(donutCtx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [5, 0, 0, 11],
            backgroundColor: ['#dc2626', '#ea580c', '#ca8a04', '#2563eb'],
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

const lineCtx = document.getElementById('lineChart').getContext('2d');
const labels = ['00:00','04:00','08:00','12:00','16:00','20:00','24:00'];
new Chart(lineCtx, {
    type: 'line',
    data: {
        labels,
        datasets: [
            { label:'Alarm Kritis (%)', data:[3,8,15,37,28,20,5], borderColor:'#dc2626', backgroundColor:'rgba(220,38,38,0.1)', fill:true, tension:0.4, borderWidth:2, pointRadius:0 },
            { label:'Alarm Peringatan (%)', data:[2,4,6,10,8,5,2], borderColor:'#ec4899', backgroundColor:'rgba(236,72,153,0.05)', fill:true, tension:0.4, borderWidth:1.5, pointRadius:0 },
            { label:'Ketersediaan Sistem (%)', data:[1,1,2,3,2,1,1], borderColor:'#22c55e', backgroundColor:'rgba(34,197,94,0.05)', fill:true, tension:0.4, borderWidth:1.5, pointRadius:0 },
            { label:'Waktu Respons Perangkat (%)', data:[0.5,1,1.5,2,1.5,1,0.5], borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,0.05)', fill:true, tension:0.4, borderWidth:1.5, pointRadius:0 }
        ]
    },
    options: {
        responsive:true, maintainAspectRatio:false,
        plugins: { legend: { position:'bottom', labels:{ font:{size:10}, boxWidth:12, padding:12 } } },
        scales: {
            x:{ grid:{display:false}, ticks:{font:{size:10}} },
            y:{ grid:{color:'#f3f4f6'}, ticks:{font:{size:10}}, min:0 }
        }
    }
});
</script>

</body>
</html>