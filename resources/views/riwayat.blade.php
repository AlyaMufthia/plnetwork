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
            display:flex; align-items:center; padding:0 28px; gap:16px;
        }

        .topbar h1{ font-size:22px; font-weight:700; color:#111827; flex:1; }

        .icon-btn{
            width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb;
            background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;
        }

        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }

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

        .btn-ekspor{
            display:flex; align-items:center; gap:8px; padding:9px 18px;
            background:#173a84; border:none; border-radius:10px;
            font-size:13px; font-weight:600; color:#fff; cursor:pointer;
            text-decoration:none;
        }

        .btn-ekspor svg{ width:16px; height:16px; }

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
        .no-tiket{
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
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Beranda
        </a>
        <a href="{{ route('riwayat.index') }}" class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Riwayat
        </a>
        <a href="{{ route('laporan.index') }}" class="nav-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            Laporan
        </a>
        <a href="{{ route('pengaturan.index') }}" class="nav-item {{ request()->routeIs('pengaturan.*') ? 'active' : '' }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
            Pengaturan
        </a>
    </nav>
</aside>

<div class="main">

    <header class="topbar">
        <h1>Riwayat Gangguan</h1>
        <div class="icon-btn">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
        </div>
        <a href="/pengaturan" class="icon-btn">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
    </svg>
</a>
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
            <a href="/riwayat/ekspor-pdf?{{ http_build_query(request()->query()) }}" class="btn-ekspor">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Ekspor PDF
            </a>
        </form>

        <div class="table-card">
            <div class="table-scroll">
                <table>
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Status</th>
                            <th>Catatan Perbaikan</th>
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
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                    @else
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="9 12 11 14 15 10"/></svg>
                                    @endif
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td>
                                <span class="catatan">{{ $item->catatan_perbaikan ?? '-' }}</span>
                            </td>
                            <td>
                                <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;">
                                    @if(!empty($item->no_tiket))
                                        <span class="no-tiket">{{ $item->no_tiket }}</span>
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
                            <td colspan="4" style="text-align:center;padding:40px;color:#9ca3af;">
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

</body>
</html>