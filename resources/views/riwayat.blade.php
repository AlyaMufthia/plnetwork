<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat - PLNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
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

        .content{ padding:28px; flex:1; display:flex; flex-direction:column; }

        .toolbar{
            background:#fff; border:1px solid #e5e7eb; border-radius:14px;
            padding:16px 20px; display:flex; align-items:center; gap:12px;
            margin-bottom:20px;
        }

        .search-box{ flex:1; position:relative; }

        .search-box input{
            width:100%; padding:9px 16px 9px 40px; border:1px solid #e5e7eb;
            border-radius:10px; background:#f9fafb; font-size:13px; outline:none; color:#374151;
        }

        .search-box svg{
            position:absolute; left:13px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:#9ca3af;
        }

        .select-status{
            padding:9px 36px 9px 14px; border:1px solid #e5e7eb; border-radius:10px;
            background:#fff; font-size:13px; color:#374151; outline:none; cursor:pointer;
            appearance:none; background-image:url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat:no-repeat; background-position:right 12px center;
        }

        .export-wrap{ position:relative; }

        .btn-ekspor{
            display:flex; align-items:center; gap:8px; padding:9px 18px;
            background:#173a84; border:none; border-radius:10px;
            font-size:13px; font-weight:600; color:#fff; cursor:pointer;
            text-decoration:none;
        }

        .btn-ekspor svg{ width:16px; height:16px; }

        .export-menu{
            display:none; position:absolute; right:0; top:calc(100% + 6px);
            background:#fff; border:1px solid #e5e7eb; border-radius:10px;
            box-shadow:0 8px 20px rgba(0,0,0,0.08); min-width:170px;
            overflow:hidden; z-index:20;
        }

        .export-menu a{
            display:flex; align-items:center; gap:10px; padding:11px 14px;
            font-size:13px; color:#374151; text-decoration:none;
        }

        .export-menu a:hover{ background:#f9fafb; }
        .export-menu a + a{ border-top:1px solid #f3f4f6; }
        .export-menu svg{ flex-shrink:0; }

        .table-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:14px;
            overflow:hidden; flex:1; display:flex; flex-direction:column;
        }

        /* Wrapper supaya body tabel bisa di-scroll, header tetap & halaman tidak makin panjang */
        .table-scroll{
            max-height:560px;
            overflow-y:auto;
        }

        table{ border-collapse:collapse; width:100%; table-layout:fixed; }
        thead th, tbody td{ padding:18px 16px; }
        thead th:nth-child(1), tbody td:nth-child(1){ width:300px; }
        thead th:nth-child(2), tbody td:nth-child(2){ width:140px; white-space:nowrap; }
        thead th:nth-child(3), tbody td:nth-child(3){ width:280px; white-space:normal; }
        thead th:nth-child(4), tbody td:nth-child(4){ width:auto; }
        thead th:nth-child(5), tbody td:nth-child(5){ width:auto; }

        thead{ position:sticky; top:0; z-index:5; background:#fff; }
        thead tr{ border-bottom:1px solid #e5e7eb; }

        thead th{
            padding:14px 20px; font-size:12px; font-weight:600; color:#6b7280;
            text-align:left; background:#fff;
        }

        tbody tr{
            border-bottom:1px solid #f3f4f6; transition:background 0.15s;
            cursor:pointer;
        }

        tbody tr:last-child{ border-bottom:none; }
        tbody tr:hover{ background:#f9fafb; }

        tbody td{
            padding:18px 20px; font-size:13px; color:#374151; vertical-align:middle;
        }

        .td-unit{ font-weight:700; color:#111827; font-size:14px; }
        .td-date{ font-size:11px; color:#9ca3af; margin-top:4px; }

        .left-bar{ display:flex; gap:16px; align-items:flex-start; }

        .bar-line{
            width:4px; background:#173a84; border-radius:4px;
            align-self:stretch; flex-shrink:0;
        }

        .status-badge{
            display:inline-flex; align-items:center; gap:6px;
            padding:5px 14px; border-radius:999px; font-size:12px; font-weight:600;
            background:#f3f4f6; color:#374151;
        }

        .status-badge svg{ width:14px; height:14px; }
        .status-badge.down{ background:#fef2f2; color:#dc2626; }
        .status-badge.up{ background:#f0fdf4; color:#15803d; }

        .catatan{ color:#374151; font-size:13px; word-break:break-word; }
        .id-laporan{
            color:#6b7280; font-size:11px; font-weight:600;
            background:#f3f4f6; padding:3px 10px; border-radius:999px;
            white-space:nowrap;
        }

        .chevron-btn{
            background:none; border:none; cursor:pointer; color:#9ca3af; padding:4px;
            text-decoration:none; display:inline-flex; align-items:center;
            flex-shrink:0;
        }

        .chevron-btn:hover{ color:#173a84; }

        .table-footer{
            padding:14px 20px; border-top:1px solid #f3f4f6;
            display:flex; align-items:center; justify-content:space-between;
            margin-top:auto;
        }

        .showing{ font-size:12px; color:#6b7280; }

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
    </nav>
</aside>

<div class="main">

    <header class="topbar">
        <h1>Riwayat Gangguan</h1>

        <a href="/riwayat" class="icon-btn" title="Lihat Riwayat Gangguan">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </a>

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

        <form method="GET" action="{{ route('riwayat.index') }}" class="toolbar">
            <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari sesuai Unit atau Gardu Induk...">
            </div>
            <select class="select-status" name="status" onchange="this.form.submit()">
                <option value="" {{ request('status') == '' ? 'selected' : '' }}>Status</option>
                <option value="DOWN" {{ request('status') == 'DOWN' ? 'selected' : '' }}>Down</option>
                <option value="UP" {{ request('status') == 'UP' ? 'selected' : '' }}>Up</option>
            </select>

            <div class="export-wrap" id="exportWrap">
                <button type="button" class="btn-ekspor" onclick="toggleExportMenu()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Ekspor
                </button>
                <div class="export-menu" id="exportMenu">
                    <a href="{{ route('riwayat.eksporPdf') }}?{{ http_build_query(request()->query()) }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" fill="#fef2f2" stroke="#dc2626" stroke-width="1.5"/>
                            <path d="M15 2v5h5" fill="none" stroke="#dc2626" stroke-width="1.5"/>
                            <text x="12" y="17" text-anchor="middle" font-size="6.5" font-weight="700" fill="#dc2626">PDF</text>
                        </svg>
                        Ekspor PDF
                    </a>
                    <a href="{{ route('riwayat.eksporCsv') }}?{{ http_build_query(request()->query()) }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" fill="#f0fdf4" stroke="#16a34a" stroke-width="1.5"/>
                            <path d="M15 2v5h5" fill="none" stroke="#16a34a" stroke-width="1.5"/>
                            <text x="12" y="17" text-anchor="middle" font-size="6.5" font-weight="700" fill="#16a34a">CSV</text>
                        </svg>
                        Ekspor CSV
                    </a>
                    <a href="{{ route('riwayat.eksporExcel') }}?{{ http_build_query(request()->query()) }}">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path d="M6 2h9l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2z" fill="#f0fdf4" stroke="#15803d" stroke-width="1.5"/>
                            <path d="M15 2v5h5" fill="none" stroke="#15803d" stroke-width="1.5"/>
                            <text x="12" y="17" text-anchor="middle" font-size="6" font-weight="700" fill="#15803d">XLS</text>
                        </svg>
                        Ekspor Excel
                    </a>
                </div>
            </div>
        </form>

        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Kategori</th>
                            <th>Penyebab Kendala</th>
                            <th>No. Tiket</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($gangguans as $item)
                        <tr onclick="window.location='{{ route('riwayat.show', $item->id) }}'">
                            <td>
                                <div class="left-bar">
                                    <div class="bar-line"></div>
                                    <div>
                                        <div class="td-unit">{{ $item->gardu_induk }}</div>
                                        <div class="td-date">{{ \Carbon\Carbon::parse($item->waktu_kejadian)->translatedFormat('d F Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php
                                    $statusClass = match($item->status_jaringan) {
                                    'DOWN' => 'down',
                                    'UP'   => 'up',
                                    default => 'down',
                                };
                                $statusLabel = match($item->status_jaringan) {
                                    'DOWN' => 'Down',
                                    'UP'   => 'Up',
                                    default => 'Down',
                                };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                @if($statusClass === 'down')
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="11" fill="#dc2626"/>
                                        <line x1="12" y1="7" x2="12" y2="13" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                                        <circle cx="12" cy="17" r="1.3" fill="#fff"/>
                                    </svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="11" fill="#16a34a"/>
                                        <polyline points="7,12 11,16 17,9" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                @endif
                                {{ $statusLabel }}
                            </span>
                            </td>
                           <td>
                         <span class="catatan">{{ $item->jenis_gangguan ?? '-' }}</span>
                        </td>
                        <td>
                        <span class="catatan">{{ $item->catatan_perbaikan ?? '-' }}</span>
                        </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                    @if(!empty($item->no_tiket))
                                        <span class="id-laporan">{{ $item->no_tiket }}</span>
                                    @else
                                        <span class="catatan">-</span>
                                    @endif
                                    <a href="{{ route('riwayat.show', $item->id) }}"
                                       class="chevron-btn"
                                       onclick="event.stopPropagation()">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
<tr>
    <td colspan="5" style="text-align:center;padding:40px;color:#9ca3af;">
        Tidak ada data gangguan.
    </td>
</tr>
@endforelse
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span class="showing">
                    Showing {{ $gangguans->firstItem() }} to {{ $gangguans->lastItem() }} of {{ $gangguans->total() }} results
                </span>
                {{ $gangguans->links() }}
            </div>
        </div>

    </div>

    <footer class="page-footer">
        <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
        <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
    </footer>

</div>

<script>
function toggleExportMenu() {
    const menu = document.getElementById('exportMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}
document.addEventListener('click', function (e) {
    const wrap = document.getElementById('exportWrap');
    if (!wrap.contains(e.target)) {
        document.getElementById('exportMenu').style.display = 'none';
    }
});

// ── PROFILE DROPDOWN (buka/tutup + auto-close di luar area) ────
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
</script>

</body>
</html>