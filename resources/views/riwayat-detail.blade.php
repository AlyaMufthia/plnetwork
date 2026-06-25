<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Riwayat - PLNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }
        body{ background:#f0f2f7; display:flex; min-height:100vh; }
        .sidebar{ width:230px; min-height:100vh; background:#fff; border-right:1px solid #e5e7eb; display:flex; flex-direction:column; position:fixed; top:0; left:0; z-index:100; }
        .sidebar-logo{ height:64px; padding:0 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; gap:10px; }
        .sidebar-logo img{ height:75px; }
        .sidebar-nav{ padding:16px 12px; display:flex; flex-direction:column; gap:4px; flex:1; }
        .nav-item{ display:flex; align-items:center; gap:12px; padding:10px 14px; border-radius:10px; font-size:14px; font-weight:500; color:#6b7280; cursor:pointer; text-decoration:none; transition:all 0.2s; }
        .nav-item:hover{ background:#f3f4f6; color:#374151; }
        .nav-item.active{ background:#173a84; color:#fff; }
        .nav-item svg{ width:18px; height:18px; flex-shrink:0; }
        .main{ margin-left:230px; flex:1; display:flex; flex-direction:column; min-height:100vh; }
        .topbar{ height:64px; background:#fff; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; padding:0 28px; gap:16px; position:sticky; top:0; z-index:50; }
        .topbar-left{ display:flex; align-items:center; gap:12px; flex:1; }
        .back-btn{ display:flex; align-items:center; gap:6px; color:#6b7280; font-size:13px; font-weight:500; text-decoration:none; cursor:pointer; padding:6px 10px; border-radius:8px; transition:all 0.2s; }
        .back-btn:hover{ background:#f3f4f6; color:#374151; }
        .back-btn svg{ width:16px; height:16px; }
        .topbar-title{ font-size:16px; font-weight:700; color:#111827; }
        .topbar-right{ display:flex; align-items:center; gap:12px; }
        .icon-btn{ width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; }
        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }
        .content{ padding:28px; flex:1; display:flex; flex-direction:column; gap:20px; }

        .detail-header-card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:24px; border-left:5px solid #dc2626; }
        .detail-id{ font-size:11px; font-weight:600; color:#9ca3af; letter-spacing:0.5px; margin-bottom:8px; }
        .detail-title-row{ display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }
        .detail-title{ font-size:20px; font-weight:700; color:#111827; }
        .badge-ditangani{ display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:8px; font-size:12px; font-weight:600; white-space:nowrap; border:1px solid; }
        .badge-ditangani svg{ width:14px; height:14px; }

        /* ✅ meta-col: catatan di atas, waktu di bawah */
        .meta-col{ display:flex; flex-direction:column; align-items:flex-start; gap:10px; }
        .detail-meta{ display:inline-flex; align-items:center; gap:10px; background:#f9fafb; border:1px solid #e5e7eb; border-radius:10px; padding:10px 16px; width:fit-content; max-width:100%; }
        .detail-meta svg{ width:16px; height:16px; color:#173a84; flex-shrink:0; }
        .detail-meta-label{ font-size:10px; color:#9ca3af; font-weight:500; }
        .detail-meta-value{ font-size:13px; font-weight:700; color:#111827; }

        .log-card{ background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden; }
        .log-header{ background:#173a84; padding:14px 20px; display:flex; align-items:center; justify-content:space-between; }
        .log-header-left{ display:flex; align-items:center; gap:10px; }
        .log-header-left svg{ width:18px; height:18px; color:#fff; }
        .log-header h2{ font-size:13px; font-weight:700; color:#fff; letter-spacing:0.3px; }
        .log-update{ font-size:11px; color:rgba(255,255,255,0.7); font-style:italic; }
        .log-body{ padding:24px; }
        .timeline{ position:relative; padding-left:32px; }
        .timeline::before{ content:''; position:absolute; left:10px; top:0; bottom:0; width:2px; background:#e5e7eb; }
        .timeline-item{ position:relative; margin-bottom:24px; }
        .timeline-item:last-child{ margin-bottom:0; }
        .timeline-dot{ position:absolute; left:-27px; top:2px; width:20px; height:20px; border-radius:50%; background:#173a84; border:3px solid #fff; box-shadow:0 0 0 2px #173a84; display:flex; align-items:center; justify-content:center; }
        .timeline-dot.active{ background:#2563eb; box-shadow:0 0 0 2px #2563eb; }
        .timeline-dot svg{ width:10px; height:10px; color:#fff; }
        .timeline-title{ font-size:14px; font-weight:600; color:#111827; margin-bottom:8px; }
        .timeline-title.active{ color:#2563eb; }
        .timeline-desc{ background:#f9fafb; border:1px solid #f3f4f6; border-radius:10px; padding:12px 16px; font-size:12px; color:#6b7280; line-height:1.7; }
        .log-footer{ padding:16px 24px; border-top:1px solid #f3f4f6; display:flex; justify-content:flex-end; }
        .btn-update{ display:inline-flex; align-items:center; gap:8px; background:#173a84; color:#fff; border:none; border-radius:10px; padding:10px 22px; font-size:13px; font-weight:600; cursor:pointer; text-decoration:none; transition:background 0.2s; }
        .btn-update:hover{ background:#122d6e; }
        .btn-update svg{ width:16px; height:16px; stroke:#fff; fill:none; stroke-width:2; }

        .foto-section-title{ font-size:14px; font-weight:700; color:#173a84; margin-bottom:14px; }
        .foto-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:16px; }
        .foto-item{ border-radius:14px; overflow:hidden; position:relative; aspect-ratio:16/9; }
        .foto-item img{ width:100%; height:100%; object-fit:cover; transition:transform 0.3s; }
        .foto-item:hover img{ transform:scale(1.05); }
        .foto-label{ position:absolute; bottom:0; left:0; right:0; background:linear-gradient(transparent, rgba(0,0,0,0.75)); padding:24px 14px 12px; font-size:12px; font-weight:600; color:#fff; }
        .foto-badge{ position:absolute; top:10px; left:10px; background:rgba(23,58,132,0.85); color:#fff; font-size:10px; font-weight:600; padding:3px 8px; border-radius:6px; display:flex; align-items:center; gap:4px; }
        .foto-empty{ text-align:center; padding:32px 24px; background:#fff; border:1px solid #e5e7eb; border-radius:16px; color:#9ca3af; font-size:13px; }
        .page-footer{ text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af; border-top:1px solid #e5e7eb; background:#fff; line-height:1.8; }
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
        <div class="topbar-left">
            <a href="{{ route('riwayat.index') }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Kembali
            </a>
            <span class="topbar-title">Detail Riwayat Gangguan</span>
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
        </div>
    </header>

    <div class="content">

        <!-- HEADER INFO -->
        <div class="detail-header-card">
            <div class="detail-id">ID LAPORAN: #{{ $gangguan->id_laporan ?? '-' }}</div>
            <div class="detail-title-row">
                <div class="detail-title">Gangguan {{ $gangguan->gardu_induk ?? '-' }}</div>
                @php
                    $statusLabel = ['on_progress' => 'DITANGANI', 'paused' => 'DITUNDA', 'resolved' => 'SELESAI'][$gangguan->status ?? 'on_progress'] ?? 'DITANGANI';
                    $statusColor = ['on_progress' => '#dc2626', 'paused' => '#d97706', 'resolved' => '#16a34a'][$gangguan->status ?? 'on_progress'] ?? '#dc2626';
                    $statusBg    = ['on_progress' => '#fef2f2', 'paused' => '#fffbeb', 'resolved' => '#f0fdf4'][$gangguan->status ?? 'on_progress'] ?? '#fef2f2';
                    $statusBd    = ['on_progress' => '#fecaca', 'paused' => '#fde68a', 'resolved' => '#bbf7d0'][$gangguan->status ?? 'on_progress'] ?? '#fecaca';
                @endphp
                <span class="badge-ditangani" style="background:{{ $statusBg }};color:{{ $statusColor }};border-color:{{ $statusBd }};">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    {{ $statusLabel }}
                </span>
            </div>

            {{-- ✅ Catatan Perbaikan di atas, Waktu Kejadian di bawah --}}
            <div class="meta-col">

                @if($gangguan->catatan_perbaikan)
                <div class="detail-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                        <polyline points="14 2 14 8 20 8"/>
                        <line x1="16" y1="13" x2="8" y2="13"/>
                        <line x1="16" y1="17" x2="8" y2="17"/>
                    </svg>
                    <div>
                        <div class="detail-meta-label">Catatan Perbaikan</div>
                        <div class="detail-meta-value">{{ $gangguan->catatan_perbaikan }}</div>
                    </div>
                </div>
                @endif

                <div class="detail-meta">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <line x1="16" y1="2" x2="16" y2="6"/>
                        <line x1="8" y1="2" x2="8" y2="6"/>
                        <line x1="3" y1="10" x2="21" y2="10"/>
                    </svg>
                    <div>
                        <div class="detail-meta-label">Waktu Kejadian</div>
                        <div class="detail-meta-value">
                            {{ $gangguan->waktu_kejadian ? \Carbon\Carbon::parse($gangguan->waktu_kejadian)->locale('id')->translatedFormat('l, d F Y | H.i') . ' WIB' : '-' }}
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- LOG AKTIVITAS -->
        <div class="log-card">
            <div class="log-header">
                <div class="log-header-left">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <h2>LOG AKTIVITAS PETUGAS</h2>
                </div>
                <span class="log-update" id="realtime-clock">Memuat waktu...</span>
            </div>
            <div class="log-body">
                <div class="timeline">
                    @forelse($gangguan->logs->sortBy('id') as $log)
                        <div class="timeline-item">
                            <div class="timeline-dot {{ $loop->last ? 'active' : '' }}">
                                @if($loop->last)
                                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
                                @else
                                    <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="4"/></svg>
                                @endif
                            </div>
                            <div class="timeline-title {{ $loop->last ? 'active' : '' }}">
                                {{ \Carbon\Carbon::parse($log->tanggal)->translatedFormat('d F Y') }}
                                &mdash;
                                {{ ['1' => 'Persiapan', '2' => 'Mobilisasi', '3' => 'Eksekusi', '4' => 'Finalisasi'][$log->tahapan] ?? 'Tahapan ' . $log->tahapan }}
                            </div>
                            <div class="timeline-desc">{{ $log->deskripsi }}</div>
                        </div>
                    @empty
                        <div style="text-align:center; padding:32px 24px; color:#9ca3af; font-size:13px;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                 style="width:36px;height:36px;margin-bottom:10px;display:block;margin-inline:auto;color:#d1d5db;">
                                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                            </svg>
                            Belum ada log aktivitas.<br>Klik <strong>UPDATE</strong> untuk menambahkan catatan.
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="log-footer">
                <a href="{{ route('riwayat.edit', $gangguan->id) }}" class="btn-update">
                    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    UPDATE
                </a>
            </div>
        </div>

        <!-- FOTO DOKUMENTASI -->
        <div>
            <div class="foto-section-title">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     style="vertical-align:middle; margin-right:6px; display:inline;">
                    <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                    <circle cx="12" cy="13" r="4"/>
                </svg>
                Dokumentasi Lapangan
            </div>

            @if($gangguan->foto_lokasi || $gangguan->foto_petugas)
                <div class="foto-grid">
                    @if($gangguan->foto_lokasi)
                    <div class="foto-item">
                        <img src="{{ asset('storage/' . $gangguan->foto_lokasi) }}" alt="Foto Lokasi Kejadian">
                        <div class="foto-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                            </svg>
                            Lokasi
                        </div>
                        <div class="foto-label">Foto Lokasi Kejadian</div>
                    </div>
                    @endif

                    @if($gangguan->foto_petugas)
                    <div class="foto-item">
                        <img src="{{ asset('storage/' . $gangguan->foto_petugas) }}" alt="Foto Petugas">
                        <div class="foto-badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                            </svg>
                            Petugas
                        </div>
                        <div class="foto-label">Foto Petugas di Lapangan</div>
                    </div>
                    @endif
                </div>
            @else
                <div class="foto-empty">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                         style="width:36px;height:36px;margin-bottom:10px;display:block;margin-inline:auto;color:#d1d5db;">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/>
                        <circle cx="12" cy="13" r="4"/>
                    </svg>
                    Belum ada foto dokumentasi.<br>Klik <strong>UPDATE</strong> untuk menambahkan foto.
                </div>
            @endif
        </div>

        <footer class="page-footer">
            <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
            <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
        </footer>

    </div>
</div>

<script>
    function updateClock() {
        const now = new Date();
        const h = String(now.getHours()).padStart(2, '0');
        const m = String(now.getMinutes()).padStart(2, '0');
        const s = String(now.getSeconds()).padStart(2, '0');
        const el = document.getElementById('realtime-clock');
        if (el) el.textContent = 'Update Terakhir: ' + h + ':' + m + ':' + s + ' WIB (Real Time)';
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>

</body>
</html>