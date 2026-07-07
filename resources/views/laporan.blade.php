<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - PLNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
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
        .sidebar-logo span{ font-size:15px; font-weight:700; color:#173a84; }

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
            display:flex; align-items:center; padding:0 28px; gap:8px;
        }

        .topbar h1{ font-size:21px; font-weight:700; color:#111827; flex:1; }

        .icon-btn{
            width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb;
            background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;
        }

        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }

        /* ── PROFILE DROPDOWN ───────────────────────────── */
        .profile-wrap{ position:relative; }

        .profile-btn{ padding:0; overflow:hidden; }

        .profile-img{
            width:100%; height:100%; object-fit:cover; border-radius:50%;
        }

        .profile-dropdown{
            display:none;
            position:absolute; top:calc(100% + 10px); right:0;
            background:#fff; border:1px solid #e5e7eb; border-radius:12px;
            box-shadow:0 10px 30px rgba(0,0,0,0.14);
            min-width:160px; padding:6px; z-index:200;
        }

        .profile-dropdown.show{ display:block; }

        .dropdown-item{
            display:flex; align-items:center; gap:9px;
            width:100%; padding:10px 12px; border:none; background:none;
            border-radius:8px; font-size:13px; font-weight:500; color:#dc2626;
            cursor:pointer; text-align:left; transition:background 0.15s;
        }

        .dropdown-item:hover{ background:#fef2f2; }

        .content{ padding:28px; flex:1; display:flex; flex-direction:column; gap:20px; }

        /* ── SUMMARY CARDS ───────────────────────────── */
        .summary-grid{
            display:grid; grid-template-columns:repeat(3, 1fr); gap:16px;
        }

        .summary-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:14px;
            padding:20px 22px; display:flex; align-items:center; gap:16px;
        }

        .summary-icon{
            width:46px; height:46px; border-radius:12px; flex-shrink:0;
            display:flex; align-items:center; justify-content:center;
        }

        .summary-icon.jam{ background:#eef2ff; color:#4338ca; }
        .summary-icon.hari{ background:#fff7ed; color:#c2410c; }
        .summary-icon.bulan{ background:#f0fdf4; color:#15803d; }
        .summary-icon svg{ width:22px; height:22px; }

        .summary-label{ font-size:12px; color:#6b7280; font-weight:500; }
        .summary-value{ font-size:22px; color:#111827; font-weight:700; margin-top:2px; }

        /* ── CHART CARD ───────────────────────────── */
        .chart-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:14px;
            padding:20px 24px;
        }

        .chart-head{
            display:flex; align-items:center; justify-content:space-between;
            margin-bottom:18px;
        }

        .chart-head h2{ font-size:16px; font-weight:700; color:#111827; }

        .tab-group{
            display:flex; background:#f3f4f6; border-radius:10px; padding:3px; gap:2px;
        }

        .tab-btn{
            border:none; background:none; padding:7px 16px; font-size:13px;
            font-weight:600; color:#6b7280; border-radius:8px; cursor:pointer;
            transition:all 0.15s;
        }

        .tab-btn.active{ background:#fff; color:#173a84; box-shadow:0 1px 3px rgba(0,0,0,0.08); }

        .chart-wrap{ height:320px; position:relative; }

        .chart-legend{
            display:flex; align-items:center; justify-content:center; gap:8px;
            margin-top:12px; font-size:12px; color:#374151; font-weight:500;
        }

        .legend-dot{
            width:12px; height:12px; border:2px solid #dc2626; border-radius:3px; background:#fff;
        }

        /* ── RECAP TABLE ───────────────────────────── */
        .table-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:14px;
            overflow:hidden;
        }

        .table-card-head{
            padding:18px 22px; border-bottom:1px solid #f3f4f6;
            font-size:15px; font-weight:700; color:#111827;
        }

        table{ border-collapse:collapse; width:100%; }
        thead th{
            padding:12px 22px; font-size:12px; font-weight:600; color:#6b7280;
            text-align:left; background:#fafafa; border-bottom:1px solid #e5e7eb;
        }

        tbody tr{ border-bottom:1px solid #f3f4f6; }
        tbody tr:last-child{ border-bottom:none; }
        tbody td{ padding:14px 22px; font-size:13px; color:#374151; }
        tbody td.strong{ font-weight:700; color:#111827; }

        .page-footer{
            text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af;
            border-top:1px solid #e5e7eb; background:#fff; line-height:1.8;
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo-plnetwork.png') }}" alt="PLNetwork">
    </div>
    <nav class="sidebar-nav">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="3" width="8" height="10" rx="1.5"/>
                <rect x="13" y="3" width="8" height="6" rx="1.5"/>
                <rect x="13" y="11" width="8" height="10" rx="1.5"/>
                <rect x="3" y="15" width="8" height="6" rx="1.5"/>
            </svg>
            Beranda
        </a>
        <a href="{{ route('riwayat.index') }}" class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Riwayat
        </a>
        <a href="{{ route('inputgangguan.index') }}" class="nav-item {{ request()->routeIs('inputgangguan.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Input Gangguan
        </a>
        <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3v18h18"/><path d="M18.7 8.3 14 13l-3-3-4.7 4.7"/></svg>
            Laporan
        </a>
    </nav>
</aside>

<div class="main">

    <header class="topbar">
        <h1>Laporan</h1>

        <button type="button" class="icon-btn" title="Notifikasi">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </button>

        <!-- ── PROFILE + LOGOUT DROPDOWN ── -->
        <div class="profile-wrap" id="profileWrap">
            <button type="button" class="icon-btn profile-btn" id="profileBtn" title="Akun Saya">
                @if(Auth::check() && Auth::user()->foto)
                    <img src="{{ asset('storage/'.Auth::user()->foto) }}" alt="Profile" class="profile-img">
                @else
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                @endif
            </button>

            <div class="profile-dropdown" id="profileDropdown">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>
                        Log out
                    </button>
                </form>
            </div>
        </div>
    </header>

    <div class="content">

        <!-- ── SUMMARY CARDS: PERJAM / HARIAN / BULANAN ── -->
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon jam">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="summary-label">Gangguan Per Jam (24 Jam Terakhir)</div>
                    <div class="summary-value">{{ $totalPerJam ?? 0 }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon hari">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <div>
                    <div class="summary-label">Gangguan Hari Ini</div>
                    <div class="summary-value">{{ $totalHariIni ?? 0 }}</div>
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-icon bulan">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                </div>
                <div>
                    <div class="summary-label">Gangguan Bulan Ini</div>
                    <div class="summary-value">{{ $totalBulanIni ?? 0 }}</div>
                </div>
            </div>
        </div>

        <!-- ── GRAFIK PEMANTAUAN ── -->
        <div class="chart-card">
            <div class="chart-head">
                <h2>Pemantauan Alarm DOWN</h2>
                <div class="tab-group">
                    <button type="button" class="tab-btn active" data-range="harian" onclick="gantiRange('harian', this)">Harian</button>
                    <button type="button" class="tab-btn" data-range="bulanan" onclick="gantiRange('bulanan', this)">Bulanan</button>
                    <button type="button" class="tab-btn" data-range="tahunan" onclick="gantiRange('tahunan', this)">Tahunan</button>
                </div>
            </div>
            <div class="chart-wrap">
                <canvas id="grafikDown"></canvas>
            </div>
            <div class="chart-legend">
                <span class="legend-dot"></span> Jumlah Perangkat DOWN
            </div>
        </div>

        <!-- ── TABEL REKAP HARIAN ── -->
        <div class="table-card">
            <div class="table-card-head">Rekap Gangguan Harian (7 Hari Terakhir)</div>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Gangguan</th>
                        <th>Jumlah Down</th>
                        <th>Jumlah Up</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapHarian ?? [] as $row)
                    <tr>
                        <td class="strong">{{ \Carbon\Carbon::parse($row->tanggal)->translatedFormat('d F Y') }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->down }}</td>
                        <td>{{ $row->up }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">
                            Belum ada data rekap.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ── TABEL REKAP BULANAN ── -->
        <div class="table-card">
            <div class="table-card-head">Rekap Gangguan Bulanan</div>
            <table>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Jumlah Gangguan</th>
                        <th>Jumlah Down</th>
                        <th>Jumlah Up</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rekapBulanan ?? [] as $row)
                    <tr>
                        <td class="strong">{{ \Carbon\Carbon::createFromDate($row->tahun, $row->bulan, 1)->translatedFormat('F Y') }}</td>
                        <td>{{ $row->total }}</td>
                        <td>{{ $row->down }}</td>
                        <td>{{ $row->up }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">
                            Belum ada data rekap.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <footer class="page-footer">
        <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
        <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
    </footer>

</div>

<script>
// ── PROFILE DROPDOWN ────
const profileBtn = document.getElementById('profileBtn');
const profileDropdown = document.getElementById('profileDropdown');
const profileWrap = document.getElementById('profileWrap');

profileBtn.addEventListener('click', function (e) {
    e.stopPropagation();
    profileDropdown.classList.toggle('show');
});

document.addEventListener('click', function (e) {
    if (!profileWrap.contains(e.target)) {
        profileDropdown.classList.remove('show');
    }
});

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        profileDropdown.classList.remove('show');
    }
});

// ── DATA GRAFIK ────
// Data ini idealnya dikirim dari controller via variabel Blade, di sini disediakan
// contoh fallback supaya grafik tetap tampil walau controller belum mengirim data.
const dataGrafik = {
    harian: {
        labels: {!! json_encode($labelHarian ?? ['00:00','02:00','04:00','06:00','08:00','10:00','12:00','14:00','16:00','18:00','20:00','22:00','24:00']) !!},
        data: {!! json_encode($dataHarian ?? [0,0,0,0,0,0,0,0,0,0,0,0,0]) !!}
    },
    bulanan: {
        labels: {!! json_encode($labelBulanan ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']) !!},
        data: {!! json_encode($dataBulanan ?? [0,0,0,0,0,0,0,0,0,0,0,0]) !!}
    },
    tahunan: {
        labels: {!! json_encode($labelTahunan ?? ['2022','2023','2024','2025','2026']) !!},
        data: {!! json_encode($dataTahunan ?? [0,0,0,0,0]) !!}
    }
};

const ctx = document.getElementById('grafikDown').getContext('2d');
let chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: dataGrafik.harian.labels,
        datasets: [{
            label: 'Jumlah Perangkat DOWN',
            data: dataGrafik.harian.data,
            borderColor: '#dc2626',
            backgroundColor: 'rgba(220,38,38,0.06)',
            pointBackgroundColor: '#fff',
            pointBorderColor: '#dc2626',
            pointBorderWidth: 2,
            pointRadius: 4,
            tension: 0.3,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        }
    }
});

function gantiRange(range, btn) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    chart.data.labels = dataGrafik[range].labels;
    chart.data.datasets[0].data = dataGrafik[range].data;
    chart.update();
}
</script>

</body>
</html>