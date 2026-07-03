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

        /* Unit list scrollbar */
        #unit-list::-webkit-scrollbar{ width:6px; }
        #unit-list::-webkit-scrollbar-track{ background:transparent; }
        #unit-list::-webkit-scrollbar-thumb{ background:#d1d5db; border-radius:3px; }

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

        @if(session('success'))
        <div class="alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>⚠ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <div class="layout">

            <div class="form-card">
                <form action="{{ route('laporan.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="status" id="status-input" value="DOWN">

                    <!-- Unit / Lokasi Utama -->
                    <div class="field-group">
                        <label class="field-label">Unit / Lokasi Utama <span style="color:#dc2626">*</span></label>
                        <div style="border:1.5px solid #e5e7eb;border-radius:10px;overflow:hidden;background:#fff;">

                            <!-- Search bar -->
                            <div style="display:flex;align-items:center;border-bottom:1px solid #e5e7eb;">
                                <span style="padding:0 12px;flex-shrink:0;color:#9ca3af;">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                                    </svg>
                                </span>
                                <input type="text" id="combo-input"
                                    placeholder="Ketik nama unit atau IP address..."
                                    autocomplete="off"
                                    style="flex:1;padding:11px 0;border:none;outline:none;font-size:13px;color:#374151;font-family:inherit;background:transparent;">
                                <div style="width:1px;height:20px;background:#e5e7eb;margin:0 4px;flex-shrink:0;"></div>
                                <span id="unit-count" style="padding:0 12px;font-size:11px;color:#9ca3af;white-space:nowrap;flex-shrink:0;"></span>
                            </div>

                            <!-- Scrollable list -->
                            <div id="unit-list" style="height:220px;overflow-y:auto;overflow-x:hidden;"></div>

                            <!-- Selected bar -->
                            <div id="unit-selected-bar" style="display:none;align-items:center;gap:8px;padding:9px 14px;background:#eff6ff;border-top:1px solid #bfdbfe;font-size:12px;color:#1d4ed8;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="flex-shrink:0;">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                                <span id="unit-selected-text" style="flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"></span>
                                <button type="button" id="unit-clear-btn"
                                    style="background:none;border:none;cursor:pointer;color:#9ca3af;font-size:18px;line-height:1;padding:0 2px;flex-shrink:0;"
                                    title="Hapus pilihan">×</button>
                            </div>

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
                        <input type="text" name="lokasi_gardu" id="lokasi-gardu" class="input-field"
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
                        target="_blank" style="text-decoration:none;">
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
    {name:"10.1.8.20 (DNS)",ip:"10.1.8.20",gardu:"Network Infrastructure"},
    {name:"DNS GOOGLE",ip:"",gardu:"Network Infrastructure"},
    {name:"10.43.10.1 (Palo Alto)",ip:"10.43.10.1",gardu:"Network Infrastructure"},
    {name:"10.43.50.240 (Controller Unifi)",ip:"10.43.50.240",gardu:"SERVER UPT MEDAN"},
    {name:"10.43.50.17 (VMWare Host 1)",ip:"10.43.50.17",gardu:"SERVER UPT MEDAN"},
    {name:"10.43.50.109 (VMWare Host 2)",ip:"10.43.50.109",gardu:"SERVER UPT MEDAN"},
    {name:"AMR",ip:"10.16.1.40",gardu:"SERVER UID SUMUT"},
    {name:"APEOS",ip:"",gardu:"SERVER UID SUMUT"},
    {name:"CONTROLER UNIFI",ip:"",gardu:"SERVER UID SUMUT"},
    {name:"SIODIS",ip:"",gardu:"SERVER UID SUMUT"},
    {name:"Portal UIDSU",ip:"",gardu:"SERVER UID SUMUT"},
    {name:"REDEMPTION (RENHAR UP2D)",ip:"",gardu:"SERVER UID SUMUT"},
    {name:"AV WILSU",ip:"10.16.1.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"AV UP3 MEDAN",ip:"10.16.2.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"AV UP3 PAKAM",ip:"10.16.83.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"AV UP3 BINJAI",ip:"10.16.3.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"AV UP3 SIBOLGA",ip:"10.16.5.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"AV UP3 SIDEMPUAN",ip:"10.16.6.66",gardu:"SERVER ANTI VIRUS UIDSUMUT"},
    {name:"10.43.10.240 (VMWare Host-1)",ip:"10.43.10.240",gardu:"SERVER UP2B SBU"},
    {name:"10.43.10.1 (UP2B SUMBAGUT)",ip:"10.43.10.1",gardu:"UP2B SUMBAGUT"},
    {name:"10.43.10.10 (UniFi-CloudKey)",ip:"10.43.10.10",gardu:"UP2B SUMBAGUT"},
    {name:"10.43.50.1 (FORTIGATE UPT MEDAN)",ip:"10.43.50.1",gardu:"ULTG/GI"},
    {name:"10.43.51.17 (GIS GLUGUR)",ip:"10.43.51.17",gardu:"ULTG/GI"},
    {name:"10.43.51.81 (ULTG PAYA PASIR)",ip:"10.43.51.81",gardu:"ULTG/GI"},
    {name:"10.43.53.161 (ULTG SEI ROTAN)",ip:"10.43.53.161",gardu:"ULTG/GI"},
    {name:"10.43.51.1 (GI BINJAI 150)",ip:"10.43.51.1",gardu:"ULTG/GI"},
    {name:"10.43.52.1 (GIS LISTRIK)",ip:"10.43.52.1",gardu:"ULTG/GI"},
    {name:"10.43.55.193 (GI GUNUNG SITOLI)",ip:"10.43.55.193",gardu:"ULTG/GI"},
    {name:"10.43.55.225 (GI TELUK DALAM)",ip:"10.43.55.225",gardu:"ULTG/GI"},
    {name:"10.43.55.129 (GI GALANG)",ip:"10.43.55.129",gardu:"ULTG/GI"},
    {name:"10.43.53.65 (GI TITI KUNING)",ip:"10.43.53.65",gardu:"ULTG/GI"},
    {name:"10.43.51.65 (GI PAYA GELI)",ip:"10.43.51.65",gardu:"ULTG/GI"},
    {name:"10.43.51.225 (GI BELAWAN)",ip:"10.43.51.225",gardu:"ULTG/GI"},
    {name:"10.43.52.17 (GI NAMURAMBE)",ip:"10.43.52.17",gardu:"ULTG/GI"},
    {name:"10.43.56.1 (GI KUALANAMU)",ip:"10.43.56.1",gardu:"ULTG/GI"},
    {name:"10.43.51.177 (GI LABUHAN)",ip:"10.43.51.177",gardu:"ULTG/GI"},
    {name:"10.43.51.97 (GI PANGKALAN BRANDAN)",ip:"10.43.51.97",gardu:"ULTG/GI"},
    {name:"10.43.56.33 (GI PANGKALAN SUSU)",ip:"10.43.56.33",gardu:"ULTG/GI"},
    {name:"10.43.56.17 (GI BINJAI 275)",ip:"10.43.56.17",gardu:"ULTG/GI"},
    {name:"10.43.51.113 (GI TAMORA)",ip:"10.43.51.113",gardu:"ULTG/GI"},
    {name:"10.43.51.129 (GIS MABAR)",ip:"10.43.51.129",gardu:"ULTG/GI"},
    {name:"10.43.51.145 (GI KIM)",ip:"10.43.51.145",gardu:"ULTG/GI"},
    {name:"10.43.51.193 (GI PERBAUNGAN)",ip:"10.43.51.193",gardu:"ULTG/GI"},
    {name:"10.43.57.1 (GI NEGERI DOLOK)",ip:"10.43.57.1",gardu:"ULTG/GI"},
    {name:"10.43.57.33 (GI TANJUNG PURA)",ip:"10.43.57.33",gardu:"ULTG/GI"},
    {name:"10.43.57.65 (GI SELAYANG)",ip:"10.43.57.65",gardu:"ULTG/GI"},
    {name:"10.43.51.209 (GI DENAI)",ip:"10.43.51.209",gardu:"ULTG/GI"},
    {name:"GATEWAY ICON NET UID SUMUT",ip:"10.16.19.2",gardu:"UID SUMUT"},
    {name:"FIREWALL FORTIGATE UIDSUMUT",ip:"10.16.19.2",gardu:"UID SUMUT"},
    {name:"10.16.19.1 (Mikrotik UID SUMUT)",ip:"10.16.19.1",gardu:"UID SUMUT"},
    {name:"10.16.116.250 (Mikrotik Ruang M-UP2D SUMUT)",ip:"10.16.116.250",gardu:"UID SUMUT"},
    {name:"10.16.103.216 (Mikrotik Ruang SRM DISTRIBUSI)",ip:"10.16.103.216",gardu:"UID SUMUT"},
    {name:"10.16.252.1 (ZoneDirector Ruckus)",ip:"10.16.252.1",gardu:"UID SUMUT"},
    {name:"10.16.102.240 (Mikrotik Ruang GM UID SUMUT)",ip:"10.16.102.240",gardu:"UID SUMUT"},
    {name:"10.16.101.1 (SW LT 1 Gd A)",ip:"10.16.101.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.105.1 (SW LT 1 Gd B)",ip:"10.16.105.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.102.1 (SW LT 2 Gd A)",ip:"10.16.102.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.106.1 (SW LT 2 Gd B)",ip:"10.16.106.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.103.1 (SW LT 3 Gd A)",ip:"10.16.103.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.107.1 (SW LT 3 Gd B)",ip:"10.16.107.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.104.1 (SW LT 4 Gd A)",ip:"10.16.104.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.108.1 (SW LT 4 Gd B)",ip:"10.16.108.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.114.1 (SW LT 2 Gd C_FASOP & SVR)",ip:"10.16.114.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.115.1 (SW LT 3 Gd C)",ip:"10.16.115.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.116.1 (SW Gd D UP2D DISPACER)",ip:"10.16.116.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.113.1 (SWITCH YBM, POS, IK PLN)",ip:"10.16.113.1",gardu:"SWITCH UIDSUMUT"},
    {name:"10.16.10.11 (UPS APC Phase R)",ip:"10.16.10.11",gardu:"UPS UIDSUMUT"},
    {name:"10.16.10.9 (UPS APC Phase S)",ip:"10.16.10.9",gardu:"UPS UIDSUMUT"},
    {name:"10.16.10.8 (UPS APC Phase T)",ip:"10.16.10.8",gardu:"UPS UIDSUMUT"},
    {name:"10.16.2.1 (UP3 MEDAN)",ip:"10.16.2.1",gardu:"UP3 MEDAN"},
    {name:"10.16.236.1 (ULP DELI TUA)",ip:"10.16.236.1",gardu:"UP3 MEDAN"},
    {name:"10.16.152.1 (ULP SUNGGAL)",ip:"10.16.152.1",gardu:"UP3 MEDAN"},
    {name:"10.16.153.1 (ULP MEDAN BARU)",ip:"10.16.153.1",gardu:"UP3 MEDAN"},
    {name:"10.16.154.1 (ULP MEDAN SELATAN)",ip:"10.16.154.1",gardu:"UP3 MEDAN"},
    {name:"10.16.157.1 (ULP MEDAN JOHOR)",ip:"10.16.157.1",gardu:"UP3 MEDAN"},
    {name:"10.16.199.1 (GUDANG LOGISTIK UP3 MEDAN/PAYA PASIR)",ip:"10.16.199.1",gardu:"UP3 MEDAN"},
    {name:"10.16.17.1 (FORTIGATE UP3 MEDAN UTARA)",ip:"10.16.17.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.150.1 (ULP BELAWAN)",ip:"10.16.150.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.156.1 (ULP LABUHAN)",ip:"10.16.156.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.155.1 (ULP MEDAN TIMUR)",ip:"10.16.155.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.151.1 (ULP HELVETIA)",ip:"10.16.151.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.235.1 (ULP MEDAN DENAI/YANTEK)",ip:"10.16.235.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.173.1 (ULP MEDAN DENAI BARU)",ip:"10.16.173.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.176.1 (ULP GLUGUR)",ip:"10.16.176.1",gardu:"UP3 MEDAN UTARA"},
    {name:"10.16.3.1 (FORTIGATE UP3 BINJAI)",ip:"10.16.3.1",gardu:"UP3 BINJAI"},
    {name:"10.16.163.1 (ULP BINJAI KOTA)",ip:"10.16.163.1",gardu:"UP3 BINJAI"},
    {name:"10.16.164.1 (ULP KUALA)",ip:"10.16.164.1",gardu:"UP3 BINJAI"},
    {name:"10.16.165.1 (ULP STABAT)",ip:"10.16.165.1",gardu:"UP3 BINJAI"},
    {name:"10.16.166.1 (ULP TANJUNG PURA)",ip:"10.16.166.1",gardu:"UP3 BINJAI"},
    {name:"10.16.167.1 (ULP GEBANG)",ip:"10.16.167.1",gardu:"UP3 BINJAI"},
    {name:"10.16.168.1 (ULP PANGKALAN BRANDAN)",ip:"10.16.168.1",gardu:"UP3 BINJAI"},
    {name:"10.16.169.1 (ULP PANGKALAN SUSU)",ip:"10.16.169.1",gardu:"UP3 BINJAI"},
    {name:"10.16.170.1 (ULP BINJAI TIMUR)",ip:"10.16.170.1",gardu:"UP3 BINJAI"},
    {name:"10.16.171.1 (ULP BINJAI BARAT)",ip:"10.16.171.1",gardu:"UP3 BINJAI"},
    {name:"10.16.179.1 (GUDANG LOGISTIK UP3 BINJAI)",ip:"10.16.179.1",gardu:"UP3 BINJAI"},
    {name:"10.16.14.1 (UP3 BUKIT BARISAN)",ip:"10.16.14.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.160.1 (ULP SIDIKALANG)",ip:"10.16.160.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.161.1 (ULP TIGA BINANGA)",ip:"10.16.161.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.162.1 (ULP BERASTAGI)",ip:"10.16.162.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.230.1 (ULP PANCUR BATU)",ip:"10.16.230.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.172.1 (ULP KABANJAHE)",ip:"10.16.172.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.188.1 (ULP PANGURURAN)",ip:"10.16.188.1",gardu:"UP3 BUKIT BARISAN"},
    {name:"GUDANG UP3 BUKIT BARISAN",ip:"103.253.86.94",gardu:"UP3 BUKIT BARISAN"},
    {name:"10.16.7.1 (UP3 RANTAU PRAPAT)",ip:"10.16.7.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.225.1 (ULP RANTAU PRAPAT KOTA)",ip:"10.16.225.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.220.1 (ULP KOTA PINANG)",ip:"10.16.220.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.221.1 (ULP TANJUNG BALAI)",ip:"10.16.221.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.222.1 (ULP AEK KANOPAN)",ip:"10.16.222.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.223.1 (ULP LABUHAN BILIK)",ip:"10.16.223.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.224.1 (ULP AEK NABARA)",ip:"10.16.224.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.226.1 (ULP KOTA BATU)",ip:"10.16.226.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.229.1 (GUDANG LOGISTIK UP3 RANTAU PRAPAT)",ip:"10.16.229.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.228.1 (ULP SIMPANG KAWAT BARU)",ip:"10.16.228.1",gardu:"UP3 RANTAU PRAPAT"},
    {name:"10.16.6.1 (UP3 PADANG SIDEMPUAN)",ip:"10.16.6.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.68.1 (UP3 SIDEMPUAN TEMP. OFFICE)",ip:"10.16.68.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.210.1 (ULP PANYABUNGAN)",ip:"10.16.210.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.211.1 (ULP KOTA NOPAN)",ip:"10.16.211.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.212.1 (ULP SIBUHUAN)",ip:"10.16.212.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.213.1 (ULP SIPIROK)",ip:"10.16.213.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.214.1 (ULP GUNUNG TUA)",ip:"10.16.214.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.216.1 (ULP SIDEMPUAN KOTA)",ip:"10.16.216.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.218.1 (ULP NATAL NEW)",ip:"10.16.218.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.219.1 (GUDANG LOGISTIK UP3 SIDEMPUAN)",ip:"10.16.219.1",gardu:"UP3 PADANG SIDEMPUAN"},
    {name:"10.16.5.1 (MIKROTIK UP3 SIBOLGA)",ip:"10.16.5.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.5.254 (FORTINET UP3 SIBOLGA)",ip:"10.16.5.254",gardu:"UP3 SIBOLGA"},
    {name:"10.16.200.1 (ULP PORSEA)",ip:"10.16.200.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.201.1 (ULP BALIGE)",ip:"10.16.201.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.202.1 (ULP SIBORONG-BORONG)",ip:"10.16.202.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.203.1 (ULP DOLOK SANGGUL)",ip:"10.16.203.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.204.1 (ULP TARUTUNG)",ip:"10.16.204.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.205.1 (ULP BARUS)",ip:"10.16.205.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.209.1 (GUDANG LOGISTIK UP3 SIBOLGA)",ip:"10.16.209.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.126.1 (ULP DOLOK SANGGUL TEMP)",ip:"10.16.126.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.238.1 (ULP BARUS - GH BUKIT)",ip:"10.16.238.1",gardu:"UP3 SIBOLGA"},
    {name:"10.16.206.1 (UP3 NIAS)",ip:"10.16.206.1",gardu:"UP3 NIAS"},
    {name:"10.16.207.1 (ULP TELUK DALAM)",ip:"10.16.207.1",gardu:"UP3 NIAS"},
    {name:"10.16.208.1 (ULP NIAS BARAT MODEM VSAT)",ip:"10.16.208.1",gardu:"UP3 NIAS"},
    {name:"10.16.208.2 (ULP NIAS BARAT MIKROTIK)",ip:"10.16.208.2",gardu:"UP3 NIAS"},
    {name:"10.16.217.1 (ULP GUNUNG SITOLI)",ip:"10.16.217.1",gardu:"UP3 NIAS"},
    {name:"10.16.249.1 (GUDANG LOGISTIK UP3 NIAS)",ip:"10.16.249.1",gardu:"UP3 NIAS"},
    {name:"10.16.206.254 (FORTINET UP3 NIAS)",ip:"10.16.206.254",gardu:"UP3 NIAS"},
    {name:"202.46.94.26 (ULP NIAS BARAT INTERNET VSAT)",ip:"202.46.94.26",gardu:"UP3 NIAS"},
    {name:"10.16.8.254 (FORTINET UP3 LUBUK PAKAM)",ip:"10.16.8.254",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.8.1 (MIKROTIK UP3 LUBUK PAKAM)",ip:"10.16.8.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.231.1 (ULP L.PAKAM KOTA)",ip:"10.16.231.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.232.1 (ULP PERBAUNGAN)",ip:"10.16.232.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.233.1 (ULP TANJUNG MORAWA)",ip:"10.16.233.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.234.1 (ULP SEI RAMPAH)",ip:"10.16.234.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.237.1 (ULP GALANG)",ip:"10.16.237.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.239.1 (GUDANG LOGISTIK UP3 PAKAM)",ip:"10.16.239.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.190.1 (ULP DOLOK MASIHUL)",ip:"10.16.190.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.191.1 (GH ULP DOLOK MASIHUL)",ip:"10.16.191.1",gardu:"UP3 LUBUK PAKAM"},
    {name:"10.16.4.1 (MIKROTIK UP3 PEMATANG SIANTAR)",ip:"10.16.4.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.41.254 (FORTINET UP3 PEMATANGSIANTAR)",ip:"10.16.41.254",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.180.1 (ULP TEBING TINGGI)",ip:"10.16.180.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.181.1 (ULP KISARAN)",ip:"10.16.181.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.182.1 (ULP PERDAGANGAN)",ip:"10.16.182.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.183.1 (ULP PARAPAT)",ip:"10.16.183.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.184.1 (ULP TANJUNG TIRAM)",ip:"10.16.184.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.185.1 (ULP PEMATANG RAYA)",ip:"10.16.185.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.186.1 (ULP INDRAPURA)",ip:"10.16.186.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.187.1 (ULP TANAH JAWA)",ip:"10.16.187.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.189.1 (GUDANG LOGISTIK UP3 SIANTAR)",ip:"10.16.189.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.16.192.1 (ULP LIMA PULUH)",ip:"10.16.192.1",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"202.46.73.210 (INTERNET WISMA RETTA)",ip:"202.46.73.210",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"202.46.73.254 (INTERNET GUDANG UP3 PEMATANG SIANTAR)",ip:"202.46.73.254",gardu:"UP3 PEMATANG SIANTAR"},
    {name:"10.40.23.1 (FORTIGATE UPMK IV)",ip:"10.40.23.1",gardu:"UIP SBU"},
    {name:"10.35.2.2 (MIKROTIK UIP SBU CIPTO)",ip:"10.35.2.2",gardu:"UIP SBU"},
    {name:"10.35.2.4 (FORTIGATE UIP SBU CIPTO)",ip:"10.35.2.4",gardu:"UIP SBU"},
    {name:"UIP SBU INTERNET ICON+",ip:"",gardu:"UIP SBU"},
    {name:"10.35.42.1 (MIKROTIK UPP SUMBAGUT 3)",ip:"10.35.42.1",gardu:"UIP SBU"},
    {name:"10.35.42.254 (FORTIGATE UPP SUMBAGUT 3)",ip:"10.35.42.254",gardu:"UIP SBU"},
    {name:"10.35.40.1 (UPP SUMBAGUT 4 ASAHAN)",ip:"10.35.40.1",gardu:"UIP SBU"},
    {name:"103.180.194.62 (UPP SUMBAGUT 4 INTERNET)",ip:"103.180.194.62",gardu:"UIP SBU"},
    {name:"10.35.10.1 (GUDANG LOGISTIK UIP SUMBAGUT)",ip:"10.35.10.1",gardu:"UIP SBU"},
    {name:"10.35.7.1 (JARSUM 2 P.SIDEMPUAN)",ip:"10.35.7.1",gardu:"UIP SBU"},
    {name:"10.58.101.1 (UPP KITSUM 2)",ip:"10.58.101.1",gardu:"UIP SBU"},
    {name:"10.10.7.7 (MIKROTIK UPDL TUNTUNGAN)",ip:"10.10.7.7",gardu:"UPDL"},
    {name:"INTERNET ICON+ UPDL TUNTUNGAN",ip:"",gardu:"UPDL"},
    {name:"10.10.7.1 (FORTIGATE UPDL TUNTUNGAN)",ip:"10.10.7.1",gardu:"UPDL"},
    {name:"10.43.60.1 (MIKROTIK UPT SIANTAR)",ip:"10.43.60.1",gardu:"UPT SIANTAR"},
    {name:"10.43.60.254 (FORTINET UPT SIANTAR)",ip:"10.43.60.254",gardu:"UPT SIANTAR"},
    {name:"10.43.62.33 (Gudang UPT P.Siantar)",ip:"10.43.62.33",gardu:"UPT SIANTAR"},
    {name:"10.43.61.81 (GI Simangkuk)",ip:"10.43.61.81",gardu:"ULTG TOBA"},
    {name:"10.43.66.97 (GI Asahan 1)",ip:"10.43.66.97",gardu:"ULTG TOBA"},
    {name:"10.43.61.241 (GI Porsea)",ip:"10.43.61.241",gardu:"ULTG TOBA"},
    {name:"10.43.61.177 (GI Pematang Siantar)",ip:"10.43.61.177",gardu:"ULTG TOBA"},
    {name:"10.43.61.145 (GI Gunung Para)",ip:"10.43.61.145",gardu:"ULTG TOBA"},
    {name:"10.43.61.65 (GI Tebing Tinggi)",ip:"10.43.61.65",gardu:"ULTG TOBA"},
    {name:"10.43.69.97 (GI Tanah Jawa)",ip:"10.43.69.97",gardu:"ULTG TOBA"},
    {name:"10.43.69.129 (GI Asahan 3)",ip:"10.43.69.129",gardu:"ULTG TOBA"},
    {name:"10.43.66.161 (GI Dolok Sanggul)",ip:"10.43.66.161",gardu:"ULTG DOLOK SANGGUL"},
    {name:"10.43.61.129 (GI Tarutung)",ip:"10.43.61.129",gardu:"ULTG DOLOK SANGGUL"},
    {name:"10.43.68.65 (GITET Sarulla)",ip:"10.43.68.65",gardu:"ULTG DOLOK SANGGUL"},
    {name:"10.43.61.225 (GI Tele)",ip:"10.43.61.225",gardu:"ULTG DOLOK SANGGUL"},
    {name:"10.43.68.1 (GI Pangururan)",ip:"10.43.68.1",gardu:"ULTG DOLOK SANGGUL"},
    {name:"10.43.61.33 (GI Sidikalang)",ip:"10.43.61.33",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.66.225 (GI Siempat Rube)",ip:"10.43.66.225",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.61.209 (GIS RENUN)",ip:"10.43.61.209",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.61.113 (GI BRASTAGI)",ip:"10.43.61.113",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.68.129 (GI KutaCane)",ip:"10.43.68.129",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.68.161 (GI Subulussalam)",ip:"10.43.68.161",gardu:"ULTG SIDIKALANG"},
    {name:"10.43.160.1 (MIKROTIK UPT Padangsidempuan)",ip:"10.43.160.1",gardu:"UPT PADANGSIDEMPUAN"},
    {name:"10.43.160.250 (FORTIGATE UPT PADANG SIDEMPUAN)",ip:"10.43.160.250",gardu:"UPT PADANGSIDEMPUAN"},
    {name:"10.43.68.33 (GITET NEW P.SIDIMPUAN)",ip:"10.43.68.33",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.61.97 (GI Padang Sidimpuan)",ip:"10.43.61.97",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.62.1 (GI Gunung Tua)",ip:"10.43.62.1",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.68.97 (GI Panyabungan)",ip:"10.43.68.97",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.62.17 (GI Labuhan Angin)",ip:"10.43.62.17",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.61.17 (GI SIBOLGA)",ip:"10.43.61.17",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.65.97 (GI MARTABE)",ip:"10.43.65.97",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.65.65 (GI Sipan 1)",ip:"10.43.65.65",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.65.81 (GI Sipan 2)",ip:"10.43.65.81",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.69.33 (GI SIBUHUAN)",ip:"10.43.69.33",gardu:"ULTG PADANGSIDEMPUAN"},
    {name:"10.43.61.1 (GI Kisaran)",ip:"10.43.61.1",gardu:"ULTG KISARAN"},
    {name:"10.43.61.161 (GI Kuala Tanjung)",ip:"10.43.61.161",gardu:"ULTG KISARAN"},
    {name:"10.43.66.129 (GI Sei Mangke)",ip:"10.43.66.129",gardu:"ULTG KISARAN"},
    {name:"10.43.61.49 (GI Aek Kanopan)",ip:"10.43.61.49",gardu:"ULTG KISARAN"},
    {name:"10.43.61.193 (GI Rantau Prapat)",ip:"10.43.61.193",gardu:"ULTG KISARAN"},
    {name:"10.43.101.65 (GI Kota Pinang)",ip:"10.43.101.65",gardu:"ULTG KISARAN"},
    {name:"10.43.69.1 (GI Tanjung Balai)",ip:"10.43.69.1",gardu:"ULTG KISARAN"},
    {name:"10.43.68.193 (GI Labuhan Bilik)",ip:"10.43.68.193",gardu:"ULTG KISARAN"},
    {name:"GUDANG UP2D SUMUT (103.124.45.246)",ip:"103.124.45.246",gardu:"UP2D SUMUT"},
];

// ── DOM refs ──────────────────────────────────────────────
const comboInput  = document.getElementById('combo-input');
const unitHidden  = document.getElementById('unit-hidden');
const unitList    = document.getElementById('unit-list');
const unitCount   = document.getElementById('unit-count');
const selBar      = document.getElementById('unit-selected-bar');
const selText     = document.getElementById('unit-selected-text');
const clearBtn    = document.getElementById('unit-clear-btn');
const garduInput  = document.getElementById('lokasi-gardu');

// ── State ─────────────────────────────────────────────────
let selected = null;
let filtered = [...unitData];

// ── Render list ───────────────────────────────────────────
function renderList(arr) {
    if (!arr.length) {
        unitList.innerHTML = '<div style="padding:24px;text-align:center;font-size:13px;color:#9ca3af;">Unit tidak ditemukan</div>';
        unitCount.textContent = '0 unit';
        return;
    }
    unitCount.textContent = arr.length + ' unit';
    unitList.innerHTML = arr.map(u => {
        const idx   = unitData.indexOf(u);
        const isAct = selected && selected.name === u.name;
        const bg    = isAct ? '#eff6ff' : '#fff';
        const bgHov = isAct ? '#dbeafe' : '#f9fafb';
        return `<div onclick="pickUnit(${idx})"
            onmouseover="this.style.background='${bgHov}'"
            onmouseout="this.style.background='${bg}'"
            style="display:flex;align-items:center;padding:9px 14px;cursor:pointer;
                   border-bottom:0.5px solid #f3f4f6;font-size:13px;background:${bg};">
            <span style="font-weight:500;color:#374151;flex:1;min-width:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">${u.name}</span>
            ${u.ip
                ? `<span style="width:1px;height:16px;background:#e5e7eb;margin:0 10px;flex-shrink:0;"></span>
                   <span style="font-size:11px;color:#9ca3af;font-family:monospace;background:#f3f4f6;padding:2px 6px;border-radius:4px;flex-shrink:0;white-space:nowrap;">${u.ip}</span>`
                : ''}
            <span style="width:1px;height:16px;background:#e5e7eb;margin:0 10px;flex-shrink:0;"></span>
            <span style="font-size:11px;color:#6b7280;flex-shrink:0;white-space:nowrap;max-width:140px;overflow:hidden;text-overflow:ellipsis;">${u.gardu}</span>
        </div>`;
    }).join('');
}

// ── Pick unit ─────────────────────────────────────────────
function pickUnit(idx) {
    selected         = unitData[idx];
    unitHidden.value = selected.name;
    garduInput.value = selected.gardu;
    selText.textContent  = selected.name + (selected.ip ? ' | ' + selected.ip : '') + ' | ' + selected.gardu;
    selBar.style.display = 'flex';
    comboInput.value     = '';
    filtered             = [...unitData];
    renderList(filtered);
}

// ── Clear ─────────────────────────────────────────────────
clearBtn.addEventListener('click', () => {
    selected = null;
    unitHidden.value = garduInput.value = '';
    selBar.style.display = 'none';
    comboInput.value = '';
    filtered = [...unitData];
    renderList(filtered);
    comboInput.focus();
});

// ── Search ────────────────────────────────────────────────
comboInput.addEventListener('input', () => {
    const q = comboInput.value.toLowerCase();
    filtered = q
        ? unitData.filter(u =>
            u.name.toLowerCase().includes(q) ||
            u.ip.includes(q) ||
            u.gardu.toLowerCase().includes(q))
        : [...unitData];
    renderList(filtered);
});

// ── Restore old value (setelah validation error) ──────────
(function init() {
    const old = unitHidden.value;
    if (old) {
        const u = unitData.find(x => x.name === old);
        if (u) pickUnit(unitData.indexOf(u));
        else renderList(unitData);
    } else {
        renderList(unitData);
    }
})();

// ── Status selector ───────────────────────────────────────
function selectStatus(el, cls) {
    document.querySelectorAll('.status-option').forEach(o =>
        o.classList.remove('selected-down', 'selected-up'));
    el.classList.add(cls);
    document.getElementById('status-input').value = cls === 'selected-down' ? 'DOWN' : 'UP';
}
</script>

</body>
</html>