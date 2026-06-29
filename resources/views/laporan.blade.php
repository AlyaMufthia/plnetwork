<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - PLNetwork</title>
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
        .topbar-right{ margin-left:auto; display:flex; align-items:center; gap:12px; }
        .icon-btn{
            width:38px; height:38px; border-radius:50%; border:1px solid #e5e7eb;
            background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer;
        }
        .icon-btn svg{ width:18px; height:18px; color:#6b7280; }

        .content{ padding:32px 28px; flex:1; }
        .page-title{ font-size:26px; font-weight:700; color:#111827; }
        .page-sub{ font-size:13px; color:#6b7280; margin-top:6px; margin-bottom:28px; }

        .alert-success{
            display:flex; align-items:center; gap:10px;
            background:#f0fdf4; border:1px solid #16a34a; border-radius:10px;
            padding:12px 16px; margin-bottom:20px;
        }
        .alert-success svg{ flex-shrink:0; }
        .alert-success span{ font-size:13px; font-weight:600; color:#16a34a; }

        .alert-error{
            background:#fef2f2; border:1px solid #dc2626; border-radius:10px;
            padding:12px 16px; margin-bottom:20px;
        }
        .alert-error p{ font-size:13px; color:#dc2626; margin-bottom:4px; }
        .alert-error p:last-child{ margin-bottom:0; }

        .layout{ display:grid; grid-template-columns:1fr 320px; gap:24px; align-items:start; }

        .form-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:28px;
        }

        .field-group{ margin-bottom:20px; }
        .field-group:last-child{ margin-bottom:0; }

        .field-label{
            font-size:13px; font-weight:600; color:#374151; margin-bottom:8px; display:block;
        }

        /* Combobox */
        .combo-wrap{ position:relative; }
        .input-wrap{ position:relative; }
        .input-wrap svg{
            position:absolute; left:13px; top:50%; transform:translateY(-50%);
            width:16px; height:16px; color:#9ca3af; pointer-events:none;
        }
        .input-search{
            width:100%; padding:11px 40px 11px 42px; border:1.5px solid #e5e7eb;
            border-radius:10px; font-size:13px; color:#374151; outline:none;
            background:#fff; transition:border-color 0.2s; font-family:inherit;
        }
        .input-search:focus{ border-color:#173a84; }
        .combo-clear{
            position:absolute; right:12px; top:50%; transform:translateY(-50%);
            width:18px; height:18px; border-radius:50%; background:#e5e7eb;
            border:none; cursor:pointer; display:none; align-items:center;
            justify-content:center; color:#6b7280; font-size:11px; line-height:1;
        }
        .combo-clear.visible{ display:flex; }
        .combo-dropdown{
            position:absolute; top:calc(100% + 6px); left:0; right:0;
            background:#fff; border:1.5px solid #e5e7eb; border-radius:12px;
            overflow:hidden; z-index:200; box-shadow:0 8px 24px rgba(0,0,0,.1);
            display:none;
        }
        .combo-dropdown.open{ display:block; }
        .dd-item{
            padding:11px 16px; font-size:13px; color:#374151; cursor:pointer;
            display:flex; align-items:center; justify-content:space-between; gap:8px;
            transition:background 0.15s;
        }
        .dd-item:hover{ background:#f3f4f6; }
        .dd-item-name{ font-weight:600; }
        .dd-item-ip{
            font-size:11px; color:#9ca3af; font-family:monospace;
            background:#f3f4f6; padding:2px 7px; border-radius:5px;
        }
        .dd-empty{ padding:14px 16px; font-size:13px; color:#9ca3af; text-align:center; }

        .input-field{
            width:100%; padding:11px 14px; border:1.5px solid #e5e7eb;
            border-radius:10px; font-size:13px; color:#374151; outline:none;
            background:#fff; transition:border-color 0.2s; font-family:inherit;
        }
        .input-field:focus{ border-color:#173a84; }
        .input-field::placeholder{ color:#b0b7c3; }

        .select-wrap{ position:relative; }
        .select-field{
            width:100%; padding:11px 40px 11px 14px; border:1.5px solid #e5e7eb;
            border-radius:10px; font-size:13px; color:#374151; outline:none;
            background:#fff; appearance:none; cursor:pointer; font-family:inherit;
            transition:border-color 0.2s;
        }
        .select-field:focus{ border-color:#173a84; }
        .select-wrap::after{
            content:''; position:absolute; right:14px; top:50%; transform:translateY(-50%);
            width:0; height:0; border-left:5px solid transparent;
            border-right:5px solid transparent; border-top:5px solid #6b7280;
            pointer-events:none;
        }

        .textarea-field{
            width:100%; padding:12px 14px; border:1.5px solid #e5e7eb;
            border-radius:10px; font-size:13px; color:#374151; outline:none;
            resize:vertical; min-height:120px; font-family:inherit;
            transition:border-color 0.2s; line-height:1.6;
        }
        .textarea-field:focus{ border-color:#173a84; }
        .textarea-field::placeholder{ color:#b0b7c3; }

        .status-grid{ display:grid; grid-template-columns:repeat(2,1fr); gap:12px; }

        .status-option{
            border:2px solid #e5e7eb; border-radius:12px; padding:14px;
            cursor:pointer; transition:all 0.2s; position:relative; overflow:hidden;
        }
        .status-option:hover{ border-color:#d1d5db; background:#fafafa; }
        .status-option.selected-down{ border-color:#dc2626; background:#fff8f8; }
        .status-option.selected-up{ border-color:#16a34a; background:#f0fdf9; }

        .status-icon{
            width:36px; height:36px; border-radius:8px;
            display:flex; align-items:center; justify-content:center;
            font-size:18px; margin-bottom:10px;
        }
        .icon-down{ background:#fef2f2; }
        .icon-up{ background:#f0fdf4; }

        .status-name{
            font-size:13px; font-weight:700; letter-spacing:0.3px; margin-bottom:4px;
        }
        .status-name.down{ color:#dc2626; }
        .status-name.up{ color:#16a34a; }

        .status-desc{ font-size:11px; color:#9ca3af; line-height:1.5; }

        .status-option .check{
            position:absolute; top:10px; right:10px;
            width:18px; height:18px; border-radius:50%;
            display:flex; align-items:center; justify-content:center;
            font-size:10px; color:#fff; opacity:0; transition:opacity 0.2s;
        }
        .status-option.selected-down .check{ background:#dc2626; opacity:1; }
        .status-option.selected-up .check{ background:#16a34a; opacity:1; }

        .form-footer{
            display:flex; justify-content:flex-end; gap:10px;
            margin-top:24px; padding-top:20px; border-top:1px solid #f3f4f6;
        }

        .btn-batal{
            padding:10px 22px; border:1.5px solid #e5e7eb; border-radius:10px;
            font-size:13px; font-weight:600; color:#374151; background:#fff;
            cursor:pointer; font-family:inherit; transition:all 0.2s;
        }
        .btn-batal:hover{ background:#f9fafb; border-color:#d1d5db; }

        .btn-kirim{
            padding:10px 22px; border:none; border-radius:10px;
            font-size:13px; font-weight:600; color:#fff; background:#173a84;
            cursor:pointer; font-family:inherit; display:flex; align-items:center;
            gap:8px; transition:all 0.2s;
        }
        .btn-kirim:hover{ background:#1e4ba0; }
        .btn-kirim svg{ width:15px; height:15px; }

        .side-col{ display:flex; flex-direction:column; gap:16px; }

        .side-card{
            background:#fff; border:1px solid #e5e7eb; border-radius:16px; padding:20px;
        }

        .side-card-title{
            font-size:15px; font-weight:700; color:#111827;
            display:flex; align-items:center; gap:8px; margin-bottom:14px;
        }
        .side-card-title svg{ width:18px; height:18px; color:#173a84; }
        .side-card-title span.teal{ color:#0f766e; }

        .panduan-list{ list-style:none; display:flex; flex-direction:column; gap:12px; }
        .panduan-list li{
            display:flex; align-items:flex-start; gap:10px;
            font-size:12px; color:#6b7280; line-height:1.6;
        }
        .panduan-num{
            width:20px; height:20px; border-radius:50%; border:1.5px solid #d1d5db;
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:700; color:#6b7280; flex-shrink:0; margin-top:1px;
        }
        .panduan-list li b{ color:#dc2626; }

        .bantuan-desc{ font-size:12px; color:#6b7280; line-height:1.6; margin-bottom:14px; }

        .btn-dispatcher{
            width:100%; padding:11px; border:1.5px solid #111827; border-radius:10px;
            background:#fff; font-size:13px; font-weight:700; color:#111827;
            cursor:pointer; display:flex; align-items:center; justify-content:center;
            gap:8px; font-family:inherit; transition:all 0.2s;
        }
        .btn-dispatcher:hover{ background:#111827; color:#fff; }
        .btn-dispatcher svg{ width:16px; height:16px; }

        .page-footer{
            text-align:center; padding:16px 28px; font-size:12px; color:#9ca3af;
            border-top:1px solid #e5e7eb; background:#fff; line-height:1.8;
        }

        @media(max-width:1024px){
            .layout{ grid-template-columns:1fr; }
            .side-col{ flex-direction:row; flex-wrap:wrap; }
            .side-card{ flex:1; min-width:240px; }
        }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <img src="{{ asset('images/logo-plnetwork.png') }}" alt="PLNetwork">
    </div>
    <nav class="sidebar-nav">
        <a href="/dashboard" class="nav-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
            Beranda
        </a>
        <a href="/riwayat" class="nav-item">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Riwayat
        </a>
        <a href="/laporan" class="nav-item active">
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
        <div style="font-size:14px;font-weight:600;color:#6b7280;">Laporan</div>
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
        </div>
    </header>

    <div class="content">

        <h1 class="page-title">Buat Laporan Baru</h1>
        <p class="page-sub">Input detail gangguan atau temuan pemeliharaan unit</p>

        {{-- Notif sukses --}}
        @if(session('success'))
        <div class="alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        {{-- Notif error validasi --}}
        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>⚠ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="layout">

            <!-- FORM -->
            <div class="form-card">
                <form action="{{ route('laporan.store') }}" method="POST">
                    @csrf

                    <!-- Hidden status input -->
                    <input type="hidden" name="status" id="status-input" value="DOWN">

                    <!-- Unit / Lokasi Utama (Combobox) -->
                    <div class="field-group">
                        <label class="field-label">Unit / Lokasi Utama <span style="color:#dc2626">*</span></label>
                        <div class="combo-wrap" id="combo">
                            <div class="input-wrap">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                </svg>
                                <input type="text" id="combo-input" class="input-search"
                                    placeholder="Ketik nama unit atau IP address..."
                                    autocomplete="off"
                                    value="{{ old('unit') }}">
                                <button type="button" class="combo-clear" id="combo-clear">✕</button>
                            </div>
                            <div class="combo-dropdown" id="combo-dropdown"></div>
                        </div>
                        <input type="hidden" name="unit" id="unit-hidden" value="{{ old('unit') }}">
                    </div>

                    <!-- Status Gangguan -->
                    <div class="field-group">
                        <label class="field-label">Status Gangguan</label>
                        <div class="status-grid">
                            <div class="status-option selected-down" onclick="selectStatus(this,'selected-down')">
                                <div class="check">✓</div>
                                <div class="status-icon icon-down">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="11" fill="#dc2626"/>
                                        <line x1="12" y1="7" x2="12" y2="13" stroke="#fff" stroke-width="2.5" stroke-linecap="round"/>
                                        <circle cx="12" cy="17" r="1.3" fill="#fff"/>
                                    </svg>
                                </div>
                                <div class="status-name down">DOWN</div>
                                <div class="status-desc">Layanan terputus total (Critical)</div>
                            </div>
                            <div class="status-option" onclick="selectStatus(this,'selected-up')">
                                <div class="check">✓</div>
                                <div class="status-icon icon-up">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none">
                                        <circle cx="12" cy="12" r="11" fill="#16a34a"/>
                                        <polyline points="7,12 11,16 17,9" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>
                                <div class="status-name up">UP</div>
                                <div class="status-desc">Layanan berjalan normal</div>
                            </div>
                        </div>
                    </div>

                    <!-- Lokasi Gardu -->
                    <div class="field-group">
                        <label class="field-label">Lokasi Gardu</label>
                        <input type="text" name="lokasi_gardu" class="input-field"
                            placeholder="Mandailing Natal"
                            value="{{ old('lokasi_gardu') }}">
                    </div>

                    <!-- Penyebab Kendala -->
                    <div class="field-group">
                        <label class="field-label">Penyebab Kendala <span style="color:#dc2626">*</span></label>
                        <div class="select-wrap">
                            <select name="penyebab" class="select-field">
                                <option value="Beban Berlebih" {{ old('penyebab') == 'Beban Berlebih' ? 'selected' : '' }}>Beban Berlebih</option>
                                <option value="Ping Timeout" {{ old('penyebab') == 'Ping Timeout' ? 'selected' : '' }}>Ping Timeout</option>
                                <option value="Tegangan Drop" {{ old('penyebab') == 'Tegangan Drop' ? 'selected' : '' }}>Tegangan Drop</option>
                                <option value="Kerusakan Perangkat" {{ old('penyebab') == 'Kerusakan Perangkat' ? 'selected' : '' }}>Kerusakan Perangkat</option>
                                <option value="Gangguan Jaringan" {{ old('penyebab') == 'Gangguan Jaringan' ? 'selected' : '' }}>Gangguan Jaringan</option>
                                <option value="Lainnya" {{ old('penyebab') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <!-- Detail Tambahan -->
                    <div class="field-group">
                        <label class="field-label">Detail Tambahan</label>
                        <textarea name="detail" class="textarea-field"
                            placeholder="Jelaskan secara detail temuan atau masalah di lapangan...">{{ old('detail') }}</textarea>
                    </div>

                    <!-- Footer -->
                    <div class="form-footer">
                        <a href="/dashboard"><button type="button" class="btn-batal">Batal</button></a>
                        <button type="submit" class="btn-kirim">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/>
                            </svg>
                            Kirim Laporan
                        </button>
                    </div>

                </form>
            </div>

            <!-- RIGHT SIDEBAR -->
            <div class="side-col">

                <div class="side-card">
                    <div class="side-card-title">
                        <svg viewBox="0 0 24 24" fill="none" stroke="#173a84" stroke-width="2" width="20" height="20">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="16" x2="12" y2="12"/>
                            <line x1="12" y1="8" x2="12.01" y2="8" stroke-linecap="round" stroke-width="2.5"/>
                        </svg>
                        Panduan Input
                    </div>
                    <ul class="panduan-list">
                        <li>
                            <span class="panduan-num">1</span>
                            <span>Pastikan unit yang dipilih sesuai dengan lokasi fisik saat ini.</span>
                        </li>
                        <li>
                            <span class="panduan-num">2</span>
                            <span>Status <b>DOWN</b> hanya digunakan jika terjadi gangguan pasokan jaringan total.</span>
                        </li>
                        <li>
                            <span class="panduan-num">3</span>
                            <span>Pastikan bahwa data laporan yang dimasukkan merupakan fakta dan benar terjadi.</span>
                        </li>
                    </ul>
                </div>

            <div class="side-card">
                <div class="side-card-title">
                    <svg viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2">
                        <path d="M14.5 10c-.83 0-1.5-.67-1.5-1.5v-5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5z"/><path d="M20.5 10H19V8.5c0-.83.67-1.5 1.5-1.5s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z"/><path d="M9.5 14c.83 0 1.5.67 1.5 1.5v5c0 .83-.67 1.5-1.5 1.5S8 21.33 8 20.5v-5c0-.83.67-1.5 1.5-1.5z"/><path d="M3.5 14H5v1.5c0 .83-.67 1.5-1.5 1.5S2 16.33 2 15.5 2.67 14 3.5 14z"/><path d="M14 14.5c0-.83.67-1.5 1.5-1.5h5c.83 0 1.5.67 1.5 1.5s-.67 1.5-1.5 1.5h-5c-.83 0-1.5-.67-1.5-1.5z"/><path d="M15.5 19H14v1.5c0 .83.67 1.5 1.5 1.5s1.5-.67 1.5-1.5-.67-1.5-1.5-1.5z"/><path d="M10 9.5C10 8.67 9.33 8 8.5 8h-5C2.67 8 2 8.67 2 9.5S2.67 11 3.5 11h5c.83 0 1.5-.67 1.5-1.5z"/><path d="M8.5 5H10V3.5C10 2.67 9.33 2 8.5 2S7 2.67 7 3.5 7.67 5 8.5 5z"/>
                    </svg>
                    <span class="teal">Bantuan Teknis</span>
                </div>
                <p class="bantuan-desc">Jika mengalami kesulitan sistem, hubungi dispatcher pusat.</p>
                <a href="https://wa.me/6281269982628?text=Halo,%20saya%20perlu%20bantuan%20teknis%20terkait%20sistem%20PLNetwork." 
                target="_blank" 
                style="text-decoration: none;">
                    <button class="btn-dispatcher">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.4 2 2 0 0 1 3.6 1.22h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.8a16 16 0 0 0 6.29 6.29l.95-.95a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                        </svg>
                        Hubungi Dispatcher
                    </button>
                </a>
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
const unitData = [
    {name:"GI Simangkuk",          ip:"10.43.61.81",  gardu:"ULTG TOBA"},
    {name:"GI Sei Mangke",         ip:"10.43.66.129", gardu:"ULTG KISARAN"},
    {name:"GI Tanjung Pura",       ip:"10.43.57.33",  gardu:"ULTG/GI"},
    {name:"GI Martabe",            ip:"10.43.65.97",  gardu:"ULTG PADANG SIDEM"},
    {name:"GI Pangururan",         ip:"10.43.68.1",   gardu:"ULTG DOLOK SANGGUL"},
    {name:"Gudang UPT P.Siantar",  ip:"10.43.62.33",  gardu:"UPT SIANTAR"},
    {name:"GI Porsea",             ip:"10.43.61.241", gardu:"ULTG TOBA"},
    {name:"GI Asahan 1",           ip:"10.43.66.97",  gardu:"ULTG TOBA"},
];

const comboInput = document.getElementById('combo-input');
const unitHidden = document.getElementById('unit-hidden');
const comboDD    = document.getElementById('combo-dropdown');
const comboClear = document.getElementById('combo-clear');
const garduInput = document.querySelector('[name="lokasi_gardu"]');

function renderDropdown(list) {
    comboDD.innerHTML = list.length
        ? list.map(u => `<div class="dd-item" onclick="pickUnit(${unitData.indexOf(u)})">
            <span class="dd-item-name">${u.name}</span>
            <span class="dd-item-ip">${u.ip}</span>
          </div>`).join('')
        : '<div class="dd-empty">Unit tidak ditemukan</div>';
    comboDD.classList.add('open');
}

function pickUnit(idx) {
    const u = unitData[idx];
    comboInput.value = u.name;
    unitHidden.value = u.name;
    garduInput.value = u.gardu;
    comboDD.classList.remove('open');
    comboClear.classList.add('visible');
}

comboInput.addEventListener('input', () => {
    const q = comboInput.value.toLowerCase();
    unitHidden.value = comboInput.value;
    comboClear.classList.toggle('visible', q.length > 0);
    if (!q) { comboDD.classList.remove('open'); return; }
    renderDropdown(unitData.filter(u =>
        u.name.toLowerCase().includes(q) || u.ip.includes(q)
    ));
});

comboInput.addEventListener('focus', () => {
    if (!comboInput.value) renderDropdown(unitData);
});

comboClear.addEventListener('click', () => {
    comboInput.value = unitHidden.value = garduInput.value = '';
    comboClear.classList.remove('visible');
    comboDD.classList.remove('open');
    comboInput.focus();
});

document.addEventListener('click', e => {
    if (!document.getElementById('combo').contains(e.target))
        comboDD.classList.remove('open');
});

function selectStatus(el, cls) {
    document.querySelectorAll('.status-option').forEach(o =>
        o.classList.remove('selected-down','selected-up'));
    el.classList.add(cls);
    document.getElementById('status-input').value =
        cls === 'selected-down' ? 'DOWN' : 'UP';
}
</script>

</body>
</html>