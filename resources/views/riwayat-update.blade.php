<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Update - PLNetwork</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; font-family:'Poppins',sans-serif; }

        body{ background:#f0f2f7; display:flex; min-height:100vh; }

        /* ── SIDEBAR (disamakan persis dengan riwayat.blade.php) ── */
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

        /* ── MAIN ── */
        .main{ margin-left:230px; flex:1; display:flex; flex-direction:column; min-height:100vh; }

        /* ── TOPBAR ── */
        .topbar{
            height:64px; background:#fff; border-bottom:1px solid #e5e7eb;
            display:flex; align-items:center; padding:0 28px; gap:16px;
            position:sticky; top:0; z-index:50;
        }
        .topbar-left{ display:flex; align-items:center; gap:12px; flex:1; }
        .back-btn{
            display:flex; align-items:center; gap:6px; color:#6b7280;
            font-size:13px; font-weight:500; text-decoration:none; cursor:pointer;
            padding:6px 10px; border-radius:8px; transition:all 0.2s;
        }
        .back-btn:hover{ background:#f3f4f6; color:#374151; }
        .back-btn svg{ width:16px; height:16px; }
        .topbar-title{ font-size:18px; font-weight:700; color:#111827; }
        .topbar-right{ display:flex; align-items:center; gap:12px; }
        .icon-btn{
            width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb;
            background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;
        }
        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }

        /* ── CONTENT ── */
        .content{ padding:28px; flex:1; }

        /* ── GRID LAYOUT ── */
        .content-grid{
            display:block;
        }

        .left-col{
            display:flex;
            flex-direction:column;
            gap:20px;
            margin-right:320px;
        }

        .right-col{
            position:fixed;
            top:84px;
            right:28px;
            width:300px;
            display:flex;
            flex-direction:column;
            gap:16px;
            z-index:40;
        }

        /* ── CARD ── */
        .card{
            background:#fff; border:1px solid #e5e7eb; border-radius:16px; overflow:hidden;
        }
        .card-header{
            padding:16px 20px; border-bottom:1px solid #e5e7eb;
            display:flex; align-items:center; gap:10px;
        }
        .card-bar{ width:4px; height:20px; background:#173a84; border-radius:4px; flex-shrink:0; }
        .card-title{ font-size:14px; font-weight:700; color:#173a84; }
        .card-body{ padding:20px; }

        /* ── STATUS SELECTOR ── */
        .status-grid{
            display:grid; grid-template-columns:repeat(2,1fr); gap:16px;
            margin-bottom:24px;
        }
        .status-card{
            border:2px solid #e5e7eb; border-radius:14px;
            padding:22px 16px;
            display:flex; flex-direction:column; align-items:center; gap:10px;
            cursor:pointer; transition:all 0.2s;
            background:#fff; position:relative;
            user-select:none;
        }
        .status-card:hover{ border-color:#173a84; background:#f0f4ff; }
        .status-card.selected{ border-color:#173a84; background:#eef2ff; }
        .status-card.selected .sc-icon-wrap{ background:#173a84; }
        .status-card.selected .sc-name{ color:#173a84; font-weight:700; }
        .sc-icon-wrap{
            width:56px; height:56px; border-radius:50%;
            background:#f3f4f6;
            display:flex; align-items:center; justify-content:center;
            transition:background 0.2s;
        }
        .sc-icon-wrap svg{ width:26px; height:26px; stroke:#9ca3af; color:#9ca3af; fill:none; stroke-width:1.8; transition:stroke 0.2s, color 0.2s; }
        .sc-name{ font-size:15px; font-weight:700; color:#374151; transition:color 0.2s; }
        .sc-desc{ font-size:11.5px; color:#9ca3af; text-align:center; line-height:1.4; }
        .sc-check{
            position:absolute; top:-9px; right:-9px;
            width:22px; height:22px; border-radius:50%;
            background:#173a84; border:2px solid #fff;
            box-shadow:0 1px 3px rgba(0,0,0,.15);
            display:none; align-items:center; justify-content:center;
        }
        .sc-check svg{ width:11px; height:11px; stroke:#fff; fill:none; stroke-width:3; }
        .status-card.selected .sc-check{ display:flex; }

        .status-card[data-status="DOWN"]:hover{ border-color:#dc2626; background:#fef2f2; }
        .status-card[data-status="DOWN"].selected{ border-color:#dc2626; background:#fef2f2; }
        .status-card[data-status="DOWN"].selected .sc-icon-wrap{ background:#dc2626; }
        .status-card[data-status="DOWN"].selected .sc-name{ color:#dc2626; }
        .status-card[data-status="DOWN"].selected .sc-check{ background:#dc2626; }
        .status-card[data-status="DOWN"] .sc-icon-wrap{ background:#fee2e2; }
        .status-card[data-status="DOWN"] .sc-icon-wrap svg{ stroke:#dc2626; color:#dc2626; }
        .status-card[data-status="DOWN"].selected .sc-icon-wrap svg{ stroke:#fff; color:#fff; }

        .status-card[data-status="UP"]:hover{ border-color:#10b981; background:#ecfdf5; }
        .status-card[data-status="UP"].selected{ border-color:#10b981; background:#ecfdf5; }
        .status-card[data-status="UP"].selected .sc-icon-wrap{ background:#10b981; }
        .status-card[data-status="UP"].selected .sc-name{ color:#10b981; }
        .status-card[data-status="UP"].selected .sc-check{ background:#10b981; }
        .status-card[data-status="UP"] .sc-icon-wrap{ background:#f3f4f6; }
        .status-card[data-status="UP"] .sc-icon-wrap svg{ stroke:#10b981; color:#10b981; }
        .status-card[data-status="UP"].selected .sc-icon-wrap svg{ stroke:#fff; color:#fff; }

        /* ── STEP TRACKER ── */
        .step-section-label{
            font-size:12px; font-weight:600; color:#6b7280;
            letter-spacing:0.3px; margin-bottom:16px;
        }
        .step-row{ display:flex; align-items:flex-start; }
        .step-item{
            display:flex; flex-direction:column; align-items:center; gap:6px;
            flex:1; cursor:pointer;
        }
        .step-dot{
            width:34px; height:34px; border-radius:50%;
            border:2px solid #e5e7eb; background:#f3f4f6;
            display:flex; align-items:center; justify-content:center;
            font-size:12px; font-weight:700; color:#9ca3af;
            transition:all 0.2s; position:relative; z-index:1;
        }
        .step-item.done .step-dot{ background:#10b981; border-color:#10b981; color:#fff; }
        .step-item.active .step-dot{ background:#173a84; border-color:#173a84; color:#fff; }
        .step-label{ font-size:10.5px; color:#9ca3af; font-weight:500; text-align:center; }
        .step-item.active .step-label{ color:#173a84; font-weight:700; }
        .step-item.done  .step-label{ color:#10b981; }
        .step-connector{ flex:1; padding-top:18px; }
        .step-line{ height:2px; background:#e5e7eb; transition:background 0.2s; }
        .step-line.done{ background:#10b981; }

        /* ── FORM FIELDS ── */
        .field-label{
            font-size:13px; font-weight:600; color:#374151; margin-bottom:8px;
            display:flex; align-items:center; gap:4px;
        }
        .field-label .req{ color:#dc2626; }
        textarea{
            width:100%; border:1.5px solid #e5e7eb; border-radius:10px;
            padding:13px 15px; font-family:'Poppins',sans-serif; font-size:13px;
            color:#374151; background:#f9fafb; resize:vertical;
            min-height:100px; outline:none; line-height:1.7;
            transition:border-color 0.2s, background 0.2s;
        }
        textarea::placeholder{ color:#9ca3af; }
        textarea:focus{ border-color:#173a84; background:#fff; }

        .input-text{
            width:100%; border:1.5px solid #e5e7eb; border-radius:10px;
            padding:10px 14px; font-family:'Poppins',sans-serif; font-size:13px;
            color:#374151; background:#f9fafb; outline:none;
            transition:border-color 0.2s, background 0.2s;
        }
        .input-text:focus{ border-color:#173a84; background:#fff; }

        /* ── LOG FOTO (kecil, kayak tombol Hapus) ── */
        .log-foto-row{
            display:flex; align-items:center; gap:14px;
        }
        .log-foto-btn{
            display:inline-flex; align-items:center; gap:6px;
            background:none; border:none; color:#173a84; cursor:pointer;
            font-size:12px; font-weight:600; padding:0; font-family:'Poppins',sans-serif;
        }
        .log-foto-btn:hover{ color:#122d6e; text-decoration:underline; }
        .log-foto-btn svg{ width:15px; height:15px; stroke:currentColor; fill:none; stroke-width:2; }
        .log-foto-view-btn{
            display:inline-flex; align-items:center; gap:6px;
            background:none; border:none; color:#6b7280; cursor:pointer;
            font-size:12px; font-weight:600; padding:0; font-family:'Poppins',sans-serif;
        }
        .log-foto-view-btn:hover{ color:#173a84; text-decoration:underline; }
        .log-foto-view-btn svg{ width:15px; height:15px; stroke:currentColor; fill:none; stroke-width:2; }

        /* ── MODAL PREVIEW FOTO LOG ── */
        .foto-modal-overlay{
            display:none; position:fixed; inset:0; background:rgba(0,0,0,.75);
            align-items:center; justify-content:center; z-index:300; padding:40px;
        }
        .foto-modal-overlay.show{ display:flex; }
        .foto-modal-overlay img{
            max-width:90vw; max-height:88vh; border-radius:12px;
            box-shadow:0 20px 60px rgba(0,0,0,.5);
        }
        .foto-modal-close{
            position:absolute; top:24px; right:32px;
            width:40px; height:40px; border-radius:50%;
            background:rgba(255,255,255,.15); border:none; color:#fff;
            font-size:22px; cursor:pointer; display:flex; align-items:center; justify-content:center;
            transition:background 0.2s;
        }
        .foto-modal-close:hover{ background:rgba(255,255,255,.3); }

        /* ── ACTION BAR ── */
        .action-bar{
            padding:16px 20px; border-top:1px solid #e5e7eb;
            display:flex; align-items:center; gap:10px;
        }
        .btn-save{
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 22px; border-radius:10px;
            background:#173a84; color:#fff; border:none;
            font-family:'Poppins',sans-serif; font-size:13px; font-weight:600;
            cursor:pointer; transition:background 0.2s;
        }
        .btn-save:hover{ background:#122d6e; }
        .btn-save svg{ width:16px; height:16px; stroke:#fff; fill:none; stroke-width:2; }
        .btn-cancel{
            display:inline-flex; align-items:center; gap:8px;
            padding:10px 22px; border-radius:10px;
            background:#fff; color:#6b7280;
            border:1.5px solid #e5e7eb;
            font-family:'Poppins',sans-serif; font-size:13px; font-weight:600;
            cursor:pointer; transition:all 0.2s; text-decoration:none;
        }
        .btn-cancel:hover{ background:#f3f4f6; color:#374151; }
        .btn-cancel svg{ width:16px; height:16px; stroke:currentColor; fill:none; stroke-width:2; }

        /* ── RIGHT SIDEBAR ── */
        .info-card{
            background:#173a84; border-radius:16px; padding:20px; color:#fff;
        }
        .info-card-title{
            font-size:13px; font-weight:700; margin-bottom:16px;
            display:flex; align-items:center; gap:8px; opacity:.95;
        }
        .info-card-title svg{ width:16px; height:16px; stroke:#fff; fill:none; stroke-width:2; }
        .info-field{ margin-bottom:14px; }
        .info-field:last-child{ margin-bottom:0; }
        .info-field-label{
            font-size:10px; opacity:.6; margin-bottom:5px;
            font-weight:600; letter-spacing:.06em; text-transform:uppercase;
        }
        .info-field-input{
            width:100%; background:rgba(255,255,255,.12);
            border:1px solid rgba(255,255,255,.2); border-radius:8px;
            padding:8px 12px; font-family:'Poppins',sans-serif;
            font-size:13px; font-weight:600; color:#fff; outline:none;
            transition:background 0.2s;
        }
        .info-field-input::placeholder{ color:rgba(255,255,255,.4); font-weight:400; }
        .info-field-input:focus{ background:rgba(255,255,255,.25); border-color:rgba(255,255,255,.5); }
        .info-field-input[readonly]{ cursor:default; opacity:.8; }

        /* ── FOTO UPLOAD ── */
        .foto-upload-grid{
            display:grid; grid-template-columns:1fr 1fr; gap:16px;
        }
        .foto-upload-item{ display:flex; flex-direction:column; gap:8px; }
        .foto-upload-label-title{
            font-size:13px; font-weight:600; color:#374151;
            display:flex; align-items:center; gap:6px;
        }
        .foto-upload-label-title svg{ width:15px; height:15px; stroke:#173a84; fill:none; stroke-width:2; }

        .foto-dropzone{
            border:2px dashed #d1d5db; border-radius:12px;
            background:#f9fafb; aspect-ratio:16/9;
            display:flex; flex-direction:column; align-items:center; justify-content:center;
            gap:8px; cursor:pointer; transition:all 0.2s; position:relative; overflow:hidden;
        }
        .foto-dropzone:hover{ border-color:#173a84; background:#f0f4ff; }
        .foto-dropzone.has-preview{ border-color:#173a84; border-style:solid; }
        .foto-dropzone svg{ width:28px; height:28px; stroke:#9ca3af; fill:none; stroke-width:1.5; }
        .foto-dropzone span{
            font-size:12px; color:#9ca3af; font-weight:500; text-align:center; padding:0 12px;
        }
        .foto-dropzone input[type="file"]{
            position:absolute; inset:0; opacity:0; cursor:pointer; width:100%; height:100%;
        }
        .foto-preview{
            position:absolute; inset:0; width:100%; height:100%;
            object-fit:cover; border-radius:10px;
        }
        .foto-preview-overlay{
            position:absolute; inset:0; background:rgba(0,0,0,0.45);
            display:flex; align-items:center; justify-content:center; gap:8px;
            opacity:0; transition:opacity 0.2s; border-radius:10px;
        }
        .foto-dropzone:hover .foto-preview-overlay{ opacity:1; }
        .foto-preview-overlay span{
            color:#fff; font-size:12px; font-weight:600; padding:0;
        }

        .foto-existing{
            position:absolute; inset:0;
        }
        .foto-existing img{
            width:100%; height:100%; object-fit:cover;
        }
        .foto-badge-upload{
            position:absolute; top:8px; left:8px;
            background:rgba(23,58,132,0.85); color:#fff;
            font-size:10px; font-weight:600; padding:3px 8px; border-radius:6px;
        }

        /* ── FOOTER ── */
        .page-footer{
            text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af;
            border-top:1px solid #e5e7eb; background:#fff; line-height:1.8;
            margin-top:20px;
        }

        /* ── TOAST ── */
        .toast{
            position:fixed; bottom:24px; right:24px;
            background:#173a84; color:#fff;
            padding:12px 20px; border-radius:12px;
            font-size:13px; font-weight:600;
            display:flex; align-items:center; gap:8px;
            opacity:0; transform:translateY(10px);
            transition:all .25s; z-index:200; pointer-events:none;
        }
        .toast.show{ opacity:1; transform:translateY(0); }
        .toast svg{ width:18px; height:18px; stroke:#6ee7b7; fill:none; stroke-width:2; }

        /* ── LOG ENTRY: highlight sesaat setelah dituju dari stepper ── */
        .log-entry.just-linked{
            animation:justLinkedPulse 1.2s ease;
            border-radius:12px;
        }
        @keyframes justLinkedPulse{
            0%   { background:#eef2ff; }
            100% { background:transparent; }
        }
        .log-stage-tag{
            display:inline-flex; align-items:center; gap:4px;
            background:#eef2ff; color:#173a84;
            font-size:10.5px; font-weight:700;
            padding:2px 8px; border-radius:6px;
            margin-left:8px; letter-spacing:.02em;
        }
    </style>
</head>
<body>

<!-- ── SIDEBAR (disamakan persis dengan riwayat.blade.php) ── -->
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

<!-- ── MAIN ── -->
<div class="main">

    <header class="topbar">
        <div class="topbar-left">
            <a href="{{ route('riwayat.show', $gangguan->id) }}" class="back-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
                Kembali
            </a>
            <span class="topbar-title">Update Aktivitas</span>
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
        <div class="content-grid">

            <form id="updateForm"
                  action="{{ route('riwayat.update', $gangguan->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  style="display:contents;">
                @csrf
                @method('PUT')

                {{-- Field ini menampung status JARINGAN (DOWN/UP), bukan status kerja tiket.
                     Namanya sekarang "status_jaringan" supaya cocok dengan kolom database
                     dan validasi di controller. --}}
                <input type="hidden" name="status_jaringan" id="inputStatus" value="{{ strtoupper($gangguan->status_jaringan ?? 'DOWN') }}">
                <input type="hidden" name="tahapan" id="inputTahapan" value="{{ $gangguan->tahapan ?? 1 }}">

                <!-- ── KOLOM KIRI ── -->
                <div class="left-col">

                    <!-- STATUS & TAHAPAN -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-bar"></div>
                            <div class="card-title">Status &amp; Tahapan Kerja</div>
                        </div>
                        <div class="card-body">

                            <div class="field-label" style="margin-bottom:12px;">Status Saat Ini</div>
                            <div class="status-grid">
                                <div class="status-card {{ strtoupper($gangguan->status_jaringan ?? 'DOWN') === 'DOWN' ? 'selected' : '' }}"
                                     data-status="DOWN"
                                     onclick="pickStatus(this,'DOWN')">
                                    <div class="sc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="sc-icon-wrap">
                                        <svg viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                            <line x1="12" y1="7" x2="12" y2="13"/>
                                            <circle cx="12" cy="16.5" r="0.9" fill="currentColor" stroke="none"/>
                                        </svg>
                                    </div>
                                    <div class="sc-name">DOWN</div>
                                    <div class="sc-desc">Layanan terputus total (Critical)</div>
                                </div>
                                <div class="status-card {{ strtoupper($gangguan->status_jaringan ?? '') === 'UP' ? 'selected' : '' }}"
                                     data-status="UP"
                                     onclick="pickStatus(this,'UP')">
                                    <div class="sc-check"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
                                    <div class="sc-icon-wrap">
                                        <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                                    </div>
                                    <div class="sc-name">UP</div>
                                    <div class="sc-desc">Layanan berjalan normal</div>
                                </div>
                            </div>

                            <div class="step-section-label">TAHAPAN PENGERJAAN &mdash; klik salah satu untuk menulis catatan pada tahap itu</div>
                            @php $tahapanNow = $gangguan->tahapan ?? 1; @endphp
                            <div class="step-row" id="stepRow">
                                @foreach(['Down','Persiapan','Mobilisasi','Eksekusi','Finalisasi','Up'] as $idx => $label)
                                    @php $n = $idx + 1; @endphp
                                    <div class="step-item {{ $tahapanNow > $n ? 'done' : ($tahapanNow == $n ? 'active' : '') }}"
                                         onclick="pickStep({{ $n }})">
                                        <div class="step-dot">{{ $tahapanNow > $n ? '✓' : $n }}</div>
                                        <div class="step-label">{{ $label }}</div>
                                    </div>
                                    @if(!$loop->last)
                                        <div class="step-connector"><div class="step-line {{ $tahapanNow > $n ? 'done' : '' }}" id="sl{{ $n }}"></div></div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                    </div>

                    <!-- FOTO DOKUMENTASI UPLOAD -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-bar"></div>
                            <div class="card-title">Dokumentasi Lapangan</div>
                        </div>
                        <div class="card-body">
                            <div class="foto-upload-grid">

                                <!-- Foto Lokasi -->
                                <div class="foto-upload-item">
                                    <div class="foto-upload-label-title">
                                        <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        Foto Lokasi Kejadian
                                    </div>
                                    <div class="foto-dropzone" id="dropzone-lokasi"
                                         onclick="document.getElementById('foto_lokasi').click()">
                                        @if($gangguan->foto_lokasi)
                                            <div class="foto-existing">
                                                <img src="{{ asset('storage/' . $gangguan->foto_lokasi) }}" alt="Foto Lokasi">
                                            </div>
                                            <div class="foto-badge-upload">Lokasi</div>
                                            <div class="foto-preview-overlay">
                                                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:#fff;fill:none;stroke-width:2;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                <span>Ganti Foto</span>
                                            </div>
                                        @else
                                            <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                            <span>Klik untuk upload<br>foto lokasi kejadian</span>
                                        @endif
                                        <input type="file" id="foto_lokasi" name="foto_lokasi"
                                               accept="image/*" onchange="previewFoto(this,'dropzone-lokasi')" onclick="event.stopPropagation()">
                                    </div>
                                    <div style="font-size:11px;color:#9ca3af;">Format: JPG, PNG, WEBP. Maks 5MB.</div>
                                </div>

                                <!-- Foto Petugas -->
                                <div class="foto-upload-item">
                                    <div class="foto-upload-label-title">
                                        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                        Foto Petugas di Lapangan
                                    </div>
                                    <div class="foto-dropzone" id="dropzone-petugas"
                                         onclick="document.getElementById('foto_petugas').click()">
                                        @if($gangguan->foto_petugas)
                                            <div class="foto-existing">
                                                <img src="{{ asset('storage/' . $gangguan->foto_petugas) }}" alt="Foto Petugas">
                                            </div>
                                            <div class="foto-badge-upload">Petugas</div>
                                            <div class="foto-preview-overlay">
                                                <svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:#fff;fill:none;stroke-width:2;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                <span>Ganti Foto</span>
                                            </div>
                                        @else
                                            <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                                            <span>Klik untuk upload<br>foto petugas lapangan</span>
                                        @endif
                                        <input type="file" id="foto_petugas" name="foto_petugas"
                                               accept="image/*" onchange="previewFoto(this,'dropzone-petugas')" onclick="event.stopPropagation()">
                                    </div>
                                    <div style="font-size:11px;color:#9ca3af;">Format: JPG, PNG, WEBP. Maks 5MB.</div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- LOG AKTIVITAS -->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-bar"></div>
                            <div class="card-title">Catatan Log Aktivitas</div>
                        </div>
                        <div class="card-body" id="logContainer">

                            @if($errors->any())
                                <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:8px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#dc2626;">
                                    @foreach($errors->all() as $error)
                                        <div>• {{ $error }}</div>
                                    @endforeach
                                </div>
                            @endif

                            @php
                                $tahapanLabelsPhp = ['','Down','Persiapan','Mobilisasi','Eksekusi','Finalisasi','Up'];
                            @endphp

                            @forelse($gangguan->logs as $i => $log)
                            <div class="log-entry" id="entry-{{ $i }}" data-stage="{{ $log->tahapan ?? $tahapanNow }}">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                    <div style="font-size:12px;font-weight:600;color:#173a84;">
                                        Catatan #{{ $i + 1 }}
                                        <span class="log-stage-tag" id="logstagelabel-{{ $i }}">
                                            {{ $tahapanLabelsPhp[$log->tahapan ?? $tahapanNow] ?? '' }}
                                        </span>
                                    </div>
                                    <button type="button" onclick="removeEntry({{ $i }})"
                                        style="background:none;border:none;color:#dc2626;cursor:pointer;font-size:12px;display:flex;align-items:center;gap:4px;">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                        Hapus
                                    </button>
                                </div>

                                <div style="margin-bottom:12px;">
                                    <div class="field-label">Tanggal</div>
                                    <input type="date" name="logs[{{ $i }}][tanggal]"
                                           value="{{ $log->tanggal }}" class="input-text" style="max-width:260px;">
                                </div>

                                <div>
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                        <div class="field-label" style="margin-bottom:0;">Deskripsi Kegiatan <span class="req">*</span></div>
                                        <div class="log-foto-row" id="logfotorow-{{ $i }}">
                                            <button type="button" class="log-foto-btn" onclick="document.getElementById('logfotoinput-{{ $i }}').click()">
                                                <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                {{ $log->foto ? 'Ganti Foto' : 'Tambah Foto' }}
                                            </button>
                                            <button type="button" class="log-foto-view-btn" id="logfotoview-{{ $i }}"
                                                    style="{{ $log->foto ? '' : 'display:none' }}"
                                                    onclick="openFotoModal('{{ $log->foto ? asset('storage/'.$log->foto) : '' }}')">
                                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                Lihat Foto
                                            </button>
                                            <input type="file" id="logfotoinput-{{ $i }}" name="logs[{{ $i }}][foto]"
                                                   accept="image/*" style="display:none" onchange="previewLogFoto(this, {{ $i }})">
                                            <input type="hidden" name="logs[{{ $i }}][existing_foto]" value="{{ $log->foto }}">
                                            {{-- ✅ Tahapan milik catatan ini sendiri, diisi otomatis saat klik stepper --}}
                                            <input type="hidden" name="logs[{{ $i }}][tahapan]" id="logtahapan-{{ $i }}" value="{{ $log->tahapan ?? $tahapanNow }}">
                                        </div>
                                    </div>
                                    <textarea name="logs[{{ $i }}][deskripsi]"
                                        placeholder="Tuliskan temuan lapangan dan langkah yang sudah dilakukan...">{{ $log->deskripsi }}</textarea>
                                </div>

                                <hr style="border:none;border-top:1px dashed #e5e7eb;margin:16px 0 0;">
                            </div>
                            @empty
                            <div class="log-entry" id="entry-0" data-stage="{{ $tahapanNow }}">
                                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                                    <div style="font-size:12px;font-weight:600;color:#173a84;">
                                        Catatan #1
                                        <span class="log-stage-tag" id="logstagelabel-0">
                                            {{ $tahapanLabelsPhp[$tahapanNow] ?? '' }}
                                        </span>
                                    </div>
                                </div>

                                <div style="margin-bottom:12px;">
                                    <div class="field-label">Tanggal</div>
                                    <input type="date" name="logs[0][tanggal]" value="{{ date('Y-m-d') }}" class="input-text" style="max-width:260px;">
                                </div>

                                <div>
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                                        <div class="field-label" style="margin-bottom:0;">Deskripsi Kegiatan <span class="req">*</span></div>
                                        <div class="log-foto-row" id="logfotorow-0">
                                            <button type="button" class="log-foto-btn" onclick="document.getElementById('logfotoinput-0').click()">
                                                <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                                Tambah Foto
                                            </button>
                                            <button type="button" class="log-foto-view-btn" id="logfotoview-0" style="display:none" onclick="openFotoModal('')">
                                                <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                                Lihat Foto
                                            </button>
                                            <input type="file" id="logfotoinput-0" name="logs[0][foto]"
                                                   accept="image/*" style="display:none" onchange="previewLogFoto(this, 0)">
                                            <input type="hidden" name="logs[0][existing_foto]" value="">
                                            <input type="hidden" name="logs[0][tahapan]" id="logtahapan-0" value="{{ $tahapanNow }}">
                                        </div>
                                    </div>
                                    <textarea name="logs[0][deskripsi]"
                                        placeholder="Tuliskan temuan lapangan dan langkah yang sudah dilakukan..."></textarea>
                                </div>

                                <hr style="border:none;border-top:1px dashed #e5e7eb;margin:16px 0 0;">
                            </div>
                            @endforelse

                        </div>

                        <div style="padding:0 20px 16px;">
                            <button type="button" onclick="addEntry()"
                                style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border:1.5px dashed #173a84;border-radius:10px;background:#f0f4ff;color:#173a84;font-family:'Poppins',sans-serif;font-size:13px;font-weight:600;cursor:pointer;">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:16px;height:16px;"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                Tambah Catatan
                            </button>
                        </div>

                        <div class="action-bar">
                            <button type="submit" class="btn-save">
                                <svg viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                                Simpan Perubahan
                            </button>
                            <a href="{{ route('riwayat.show', $gangguan->id) }}" class="btn-cancel">
                                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                Batalkan
                            </a>
                        </div>
                    </div>

                </div>
                {{-- /left-col --}}

                <!-- ── KOLOM KANAN ── -->
                <div class="right-col">
                    <div class="info-card">
                        <div class="info-card-title">
                            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Ringkasan Insiden
                        </div>

                        <div class="info-field">
                            <div class="info-field-label">No Tiket</div>
                            <input class="info-field-input" type="text"
                                name="no_tiket"
                                value="{{ $gangguan->no_tiket ?? '' }}"
                                placeholder="Contoh: FLT-20260614-001">
                        </div>

                        <div class="info-field">
                            <div class="info-field-label">Lokasi / Gardu Induk</div>
                            <input class="info-field-input" type="text"
                                   name="gardu_induk"
                                   value="{{ $gangguan->gardu_induk ?? '' }}"
                                   placeholder="Contoh: UP3 MEDAN UTARA">
                        </div>

                        <div class="info-field">
                            <div class="info-field-label">Waktu Mulai Kejadian</div>
                            <input class="info-field-input" type="datetime-local"
                                   name="waktu_kejadian"
                                   value="{{ $gangguan->waktu_kejadian ? \Carbon\Carbon::parse($gangguan->waktu_kejadian)->format('Y-m-d\TH:i') : '' }}">
                        </div>

                        <div class="info-field">
                            <div class="info-field-label">Catatan Perbaikan</div>
                            <textarea
                                name="catatan_perbaikan"
                                rows="3"
                                placeholder="Masukkan catatan perbaikan..."
                                style="
                                    width:100%;
                                    background:rgba(255,255,255,.12);
                                    border:1px solid rgba(255,255,255,.2);
                                    border-radius:8px;
                                    padding:8px 12px;
                                    font-family:'Poppins',sans-serif;
                                    font-size:13px;
                                    font-weight:500;
                                    color:#fff;
                                    outline:none;
                                    resize:vertical;
                                    min-height:80px;
                                    line-height:1.6;
                                    transition:background 0.2s;
                                "
                                onfocus="this.style.background='rgba(255,255,255,.25)';this.style.borderColor='rgba(255,255,255,.5)'"
                                onblur="this.style.background='rgba(255,255,255,.12)';this.style.borderColor='rgba(255,255,255,.2)'"
                            >{{ old('catatan_perbaikan', $gangguan->catatan_perbaikan) }}</textarea>
                        </div>
                    </div>
                </div>
                {{-- /right-col --}}

            </form>

        </div>
        {{-- /content-grid --}}

        <footer class="page-footer">
            <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
            <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
        </footer>

    </div>
</div>

<!-- MODAL PREVIEW FOTO LOG -->
<div class="foto-modal-overlay" id="fotoModalOverlay" onclick="closeFotoModal(event)">
    <button type="button" class="foto-modal-close" onclick="closeFotoModal(event)">&times;</button>
    <img id="fotoModalImg" src="" alt="Preview foto log" onclick="event.stopPropagation()">
</div>

<!-- TOAST -->
<div class="toast" id="toast">
    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    <span id="toastMsg">Perubahan berhasil disimpan!</span>
</div>

<script>
    let entryCount = {{ $gangguan->logs->count() ?: 1 }};

    // Label tahapan dipakai bareng oleh addEntry(), pickStep(), dan goToStageNote()
    const tahapanLabels = ['', 'Down', 'Persiapan', 'Mobilisasi', 'Eksekusi', 'Finalisasi', 'Up'];
    window.currentTahapan = {{ $tahapanNow }};

    function previewFoto(input, dropzoneId) {
        const dz = document.getElementById(dropzoneId);
        if (!input.files || !input.files[0]) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            dz.querySelectorAll('svg, span, .foto-existing, .foto-badge-upload').forEach(el => el.remove());

            const img = document.createElement('img');
            img.src = e.target.result;
            img.className = 'foto-preview';
            dz.insertBefore(img, dz.querySelector('input'));

            let overlay = dz.querySelector('.foto-preview-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.className = 'foto-preview-overlay';
                overlay.innerHTML = `<svg viewBox="0 0 24 24" style="width:20px;height:20px;stroke:#fff;fill:none;stroke-width:2;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg><span>Ganti Foto</span>`;
                dz.insertBefore(overlay, dz.querySelector('input'));
            }

            dz.classList.add('has-preview');
        };
        reader.readAsDataURL(input.files[0]);
    }

    function previewLogFoto(input, i) {
        if (!input.files || !input.files[0]) return;
        const addBtn = document.getElementById('logfotorow-' + i).querySelector('.log-foto-btn');
        const viewBtn = document.getElementById('logfotoview-' + i);

        const reader = new FileReader();
        reader.onload = function(e) {
            viewBtn.style.display = 'inline-flex';
            viewBtn.onclick = function () { openFotoModal(e.target.result); };
            addBtn.lastChild.textContent = ' Ganti Foto';
        };
        reader.readAsDataURL(input.files[0]);
    }

    function openFotoModal(src) {
        if (!src) return;
        document.getElementById('fotoModalImg').src = src;
        document.getElementById('fotoModalOverlay').classList.add('show');
    }

    function closeFotoModal(e) {
        if (e) e.stopPropagation();
        document.getElementById('fotoModalOverlay').classList.remove('show');
    }

    function addEntry() {
        const i = entryCount;
        const today = new Date().toISOString().split('T')[0];
        const html = `
        <div class="log-entry" id="entry-${i}" data-stage="${window.currentTahapan}">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
                <div style="font-size:12px;font-weight:600;color:#173a84;">
                    Catatan #${i + 1}
                    <span class="log-stage-tag" id="logstagelabel-${i}">${tahapanLabels[window.currentTahapan]}</span>
                </div>
                <button type="button" onclick="removeEntry(${i})"
                    style="background:none;border:none;color:#dc2626;cursor:pointer;font-size:12px;display:flex;align-items:center;gap:4px;">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="width:14px;height:14px;">
                        <polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/>
                    </svg>
                    Hapus
                </button>
            </div>

            <div style="margin-bottom:12px;">
                <div class="field-label">Tanggal</div>
                <input type="date" name="logs[${i}][tanggal]" value="${today}" class="input-text" style="max-width:260px;">
            </div>

            <div>
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;">
                    <div class="field-label" style="margin-bottom:0;">Deskripsi Kegiatan <span class="req">*</span></div>
                    <div class="log-foto-row" id="logfotorow-${i}">
                        <button type="button" class="log-foto-btn" onclick="document.getElementById('logfotoinput-${i}').click()">
                            <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" style="width:15px;height:15px;"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            Tambah Foto
                        </button>
                        <button type="button" class="log-foto-view-btn" id="logfotoview-${i}" style="display:none" onclick="openFotoModal('')">
                            <svg viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-width="2" style="width:15px;height:15px;"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            Lihat Foto
                        </button>
                        <input type="file" id="logfotoinput-${i}" name="logs[${i}][foto]" accept="image/*" style="display:none" onchange="previewLogFoto(this, ${i})">
                        <input type="hidden" name="logs[${i}][existing_foto]" value="">
                        <input type="hidden" name="logs[${i}][tahapan]" id="logtahapan-${i}" value="${window.currentTahapan}">
                    </div>
                </div>
                <textarea name="logs[${i}][deskripsi]"
                    placeholder="Tuliskan temuan lapangan dan langkah yang sudah dilakukan..."
                    style="width:100%;border:1.5px solid #e5e7eb;border-radius:10px;padding:13px 15px;font-family:'Poppins',sans-serif;font-size:13px;color:#374151;background:#f9fafb;resize:vertical;min-height:100px;outline:none;line-height:1.7;"></textarea>
            </div>
            <hr style="border:none;border-top:1px dashed #e5e7eb;margin:16px 0 0;">
        </div>`;
        document.getElementById('logContainer').insertAdjacentHTML('beforeend', html);
        entryCount++;
    }

    function removeEntry(i) {
        if (document.querySelectorAll('.log-entry').length <= 1) {
            showToast('Minimal harus ada 1 catatan!'); return;
        }
        const el = document.getElementById('entry-' + i);
        if (el) el.remove();
    }

    function pickStatus(el, value) {
        document.querySelectorAll('.status-card').forEach(c => c.classList.remove('selected'));
        el.classList.add('selected');
        document.getElementById('inputStatus').value = value;
    }

    // ✅ Klik salah satu bulatan tahap di stepper:
    //    1) update tampilan stepper (done/active) seperti sebelumnya
    //    2) update input tersembunyi 'tahapan' tiket
    //    3) sambungkan ke Catatan Log Aktivitas lewat goToStageNote()
    function pickStep(n) {
        const items = document.querySelectorAll('.step-item');
        items.forEach((s, i) => {
            s.classList.remove('done','active');
            const dot = s.querySelector('.step-dot');
            if (i + 1 < n)        { s.classList.add('done');   dot.textContent = '✓'; }
            else if (i + 1 === n) { s.classList.add('active'); dot.textContent = i + 1; }
            else                   { dot.textContent = i + 1; }
        });
        for (let i = 1; i <= 5; i++) {
            const l = document.getElementById('sl' + i);
            if (l) l.classList.toggle('done', i < n);
        }
        document.getElementById('inputTahapan').value = n;
        window.currentTahapan = n;

        // ✅ "Finalisasi" (n=5) dianggap satu paket dengan "Up" (n=6) —
        //    klik Finalisasi cuma menggeser stepper, tidak perlu bikin/buka
        //    catatan baru. Catatan baru hanya dibuka saat "Up" yang diklik.
        if (n === 5) return;

        goToStageNote(n);
    }

    // ✅ Menyambungkan klik stepper ke form Catatan Log Aktivitas:
    //    - Kalau catatan terakhir masih kosong (belum ditulis apa-apa), catatan itu
    //      dipakai ulang dan dilabeli ulang sesuai tahap yang baru diklik.
    //    - Kalau catatan terakhir sudah terisi, otomatis dibuatkan Catatan baru
    //      khusus untuk tahap ini, supaya riwayat tiap tahap tetap terpisah.
    //    - Textarea-nya langsung difokuskan & di-scroll ke tampilan supaya user
    //      tinggal mengetik deskripsi kegiatan untuk tahap tersebut.
    function goToStageNote(n) {
        const entries = document.querySelectorAll('.log-entry');
        const last = entries[entries.length - 1];
        const lastTextarea = last ? last.querySelector('textarea') : null;

        let targetEntry;
        if (lastTextarea && lastTextarea.value.trim() === '') {
            targetEntry = last;
        } else {
            addEntry();
            const all = document.querySelectorAll('.log-entry');
            targetEntry = all[all.length - 1];
        }

        const idx = targetEntry.id.replace('entry-', '');
        const tahapanInput = document.getElementById('logtahapan-' + idx);
        const label = document.getElementById('logstagelabel-' + idx);
        if (tahapanInput) tahapanInput.value = n;
        if (label) label.textContent = tahapanLabels[n];
        targetEntry.setAttribute('data-stage', n);

        targetEntry.classList.remove('just-linked');
        void targetEntry.offsetWidth; // restart animasi highlight
        targetEntry.classList.add('just-linked');

        targetEntry.scrollIntoView({ behavior: 'smooth', block: 'center' });
        const ta = targetEntry.querySelector('textarea');
        if (ta) ta.focus();
    }

    function showToast(msg) {
        const t = document.getElementById('toast');
        document.getElementById('toastMsg').textContent = msg;
        t.classList.add('show');
        setTimeout(() => t.classList.remove('show'), 3000);
    }

    @if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        showToast('{{ session('success') }}');
    });
    @endif
</script>
</body>
</html>