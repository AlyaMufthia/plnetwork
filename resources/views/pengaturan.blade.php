<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - PLNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        body { background: #f0f2f7; display: flex; min-height: 100vh; }

        /* ── Sidebar ── */
        /* ── Sidebar Style ── */
        .sidebar {
            width: 230px; min-height: 100vh; background: #fff;
            border-right: 1px solid #e5e7eb; display: flex;
            flex-direction: column; position: fixed; top: 0; left: 0; z-index: 100;
        }
        .sidebar-logo {
            height: 64px; padding: 0 20px; border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; gap: 10px;
        }
        .sidebar-logo img { height: 70px; }
        .sidebar-logo span { font-size: 15px; font-weight: 700; color: #173a84; }
        .sidebar-nav { padding: 16px 12px; display: flex; flex-direction: column; gap: 4px; flex: 1; }
        .nav-item {
            display: flex; align-items: center; gap: 12px; padding: 10px 14px;
            border-radius: 10px; font-size: 14px; font-weight: 500; color: #6b7280;
            cursor: pointer; text-decoration: none; transition: all 0.2s;
        }
        .nav-item:hover { background: #f3f4f6; color: #374151; }
        .nav-item.active { background: #173a84; color: #fff; }
        .nav-item svg { width: 18px; height: 18px; flex-shrink: 0; }

        /* ── Main ── */
        .main { margin-left: 230px; flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

        /* ── Topbar ── */
        .topbar {
            height: 64px; background: #fff; border-bottom: 1px solid #e5e7eb;
            display: flex; align-items: center; padding: 0 28px; gap: 12px;
        }
        .topbar h1 { font-size: 20px; font-weight: 700; color: #111827; flex: 1; }
        .icon-btn {
            width: 38px; height: 38px; border-radius: 50%; border: 1px solid #e5e7eb;
            background: #fff; display: flex; align-items: center; justify-content: center;
            cursor: pointer;
        }
        .icon-btn i { font-size: 18px; color: #6b7280; }

        /* ── Content ── */
        .content { 
            padding: 32px 28px; /* Jika ingin benar-benar rapat tanpa jarak ke tepi layar, ubah menjadi: padding: 32px 0; */
            flex: 1; 
        }

        /* ── Alert ── */
        .alert-success {
            display: flex; align-items: center; gap: 10px;
            background: #f0fdf4; border: 1px solid #16a34a; border-radius: 10px;
            padding: 12px 16px; margin-bottom: 20px;
            font-size: 13px; font-weight: 600; color: #16a34a;
        }
        .alert-error {
            background: #fef2f2; border: 1px solid #dc2626; border-radius: 10px;
            padding: 12px 16px; margin-bottom: 20px;
            font-size: 13px; color: #dc2626;
        }

        /* ── Action bar ── */
        .action-bar {
            display: flex; 
            justify-content: flex-end; 
            gap: 10px;
            margin-bottom: 20px; 
            max-width: 100%; /* Diubah dari 860px ke 100% agar memenuhi layar */
        }
        .btn-batal {
            padding: 9px 20px; border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: 13px; font-weight: 600; color: #374151; background: #fff;
            cursor: pointer; font-family: inherit; text-decoration: none;
        }
        .btn-simpan {
            padding: 9px 20px; border: none; border-radius: 10px;
            font-size: 13px; font-weight: 600; color: #fff; background: #173a84;
            cursor: pointer; font-family: inherit;
        }
        .btn-simpan:hover { background: #1e4ba0; }

        /* ── Card ── */
        .card {
            background: #fff; 
            border: 1px solid #e5e7eb; 
            border-radius: 16px;
            overflow: hidden; 
            max-width: 100%;
        }
        .card-section { padding: 24px 28px; }
        .card-section + .card-section { border-top: 1px solid #f3f4f6; }

        /* ── Section header ── */
        .section-title {
            display: flex; align-items: center; gap: 10px;
            font-size: 15px; font-weight: 700; color: #111827;
            margin-bottom: 20px;
        }
        .section-title i { font-size: 20px; color: #6b7280; }

        /* ── Profil ── */
        .profil-wrap { display: flex; gap: 28px; align-items: flex-start; }

        .foto-wrap { position: relative; flex-shrink: 0; }
        .foto-wrap img {
            width: 110px; height: 110px; border-radius: 12px;
            object-fit: cover; border: 2px solid #e5e7eb;
        }
        .foto-placeholder {
            width: 110px; height: 110px; border-radius: 12px;
            background: linear-gradient(135deg, #c7d7f5, #e8eeff);
            border: 2px solid #e5e7eb;
            display: flex; align-items: center; justify-content: center;
        }
        .foto-placeholder i { font-size: 40px; color: #173a84; }
        .foto-edit-btn {
            position: absolute; bottom: 6px; right: 6px;
            width: 28px; height: 28px; border-radius: 50%;
            background: #173a84; border: 2px solid #fff; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
        }
        .foto-edit-btn i { font-size: 13px; color: #fff; }

        /* ── Fields ── */
        .fields { flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .field-group { display: flex; flex-direction: column; gap: 6px; }
        .field-group.full { grid-column: 1 / -1; }
        .field-label { font-size: 13px; font-weight: 600; color: #374151; }

        .input-field {
            padding: 10px 14px; border: 1.5px solid #e5e7eb; border-radius: 10px;
            font-size: 13px; color: #374151; outline: none; font-family: inherit;
            transition: border-color 0.2s; background: #fff; width: 100%;
        }
        .input-field:focus { border-color: #173a84; }

        .select-wrap { position: relative; }
        .select-field {
            width: 100%; padding: 10px 40px 10px 14px; border: 1.5px solid #e5e7eb;
            border-radius: 10px; font-size: 13px; color: #374151; outline: none;
            background: #fff; appearance: none; cursor: pointer; font-family: inherit;
        }
        .select-field:focus { border-color: #173a84; }
        .select-wrap::after {
            content: ''; position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            width: 0; height: 0; border-left: 5px solid transparent;
            border-right: 5px solid transparent; border-top: 5px solid #6b7280;
            pointer-events: none;
        }

        /* ── Password ── */
        .tip-badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #fffbeb; border: 1px solid #fbbf24; border-radius: 8px;
            padding: 6px 12px; font-size: 12px; color: #92400e; margin-bottom: 16px;
        }
        .tip-badge i { font-size: 14px; }

        .pw-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .password-wrap { position: relative; }
        .password-wrap input { width: 100%; padding-right: 44px; }
        .toggle-pw {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #9ca3af; padding: 2px;
            display: flex; align-items: center;
        }
        .toggle-pw:hover { color: #374151; }
        .toggle-pw i { font-size: 16px; }

        /* ── Footer ── */
        .page-footer {
            text-align: center; padding: 16px 28px; font-size: 12px; color: #9ca3af;
            border-top: 1px solid #e5e7eb; background: #fff; line-height: 1.8;
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

        <style>
            /* Layout Topbar */
            .topbar { height: 64px; background: #fff; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; padding: 0 28px; }
            .topbar h1 { font-size: 20px; font-weight: 700; color: #111827; flex: 1; }
            
            /* Container Kanan */
            .topbar-right { display: flex; gap: 12px; align-items: center; }
            
            /* Tombol Ikon */
            .icon-btn { width: 38px; height: 38px; border-radius: 50%; border: 1px solid #e5e7eb; background: #fff; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #6b7280; text-decoration: none; transition: all 0.2s; }
            .icon-btn:hover { background: #f3f4f6; color: #374151; }
            .icon-btn svg { width: 18px; height: 18px; }
        </style>

        <header class="topbar">
            <h1>Pengaturan</h1>
            <div class="topbar-right">
                <a href="/riwayat" class="icon-btn" title="Riwayat"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg></a>
                <a href="/pengaturan" class="icon-btn" title="Profil"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></a>
            </div>
        </header>

    <div class="content">

        @if(session('success'))
        <div class="alert-success">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
        @endif

        @if($errors->any())
        <div class="alert-error">
            @foreach($errors->all() as $error)
                <p>⚠ {{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form action="{{ route('pengaturan.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="action-bar">
                <a href="/dashboard" class="btn-batal">Batal</a>
                <button type="submit" class="btn-simpan">Simpan Perubahan</button>
            </div>

            <div class="card">

                {{-- PROFIL PENGGUNA --}}
                <div class="card-section">
                    <div class="section-title">
                        <i class="ti ti-user-circle"></i>
                        Profil Pengguna
                    </div>

                    <div class="profil-wrap">
                        <div class="foto-wrap">
                            @if($user->foto)
                                <img src="{{ asset('storage/' . $user->foto) }}" alt="Foto Profil">
                            @else
                                <div class="foto-placeholder">
                                    <i class="ti ti-user"></i>
                                </div>
                            @endif
                            <button type="button" class="foto-edit-btn" onclick="document.getElementById('fotoInput').click()">
                                <i class="ti ti-camera"></i>
                            </button>
                            <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none"
                                onchange="previewFoto(this)">
                        </div>

                        <div class="fields">
                            <div class="field-group">
                                <label class="field-label">Nama Lengkap</label>
                                <input type="text" name="name" class="input-field"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="field-group">
                                <label class="field-label">Divisi</label>
                                <div class="select-wrap">
                                    <select name="divisi" class="select-field">
                                        <option value="">-- Pilih Divisi --</option>
                                        @foreach(['Distribusi','Transmisi','Proteksi','SCADA','IT & Telkom','Operasi','Pemeliharaan'] as $div)
                                            <option value="{{ $div }}" {{ old('divisi', $user->divisi) == $div ? 'selected' : '' }}>
                                                {{ $div }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="field-group full">
                                <label class="field-label">Alamat Email</label>
                                <input type="email" name="email" class="input-field"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KEAMANAN AKUN --}}
                <div class="card-section">
                    <div class="section-title">
                        <i class="ti ti-shield-lock"></i>
                        Keamanan Akun
                    </div>

                    <div class="tip-badge">
                        <i class="ti ti-info-circle"></i>
                        Kosongkan jika tidak ingin mengubah kata sandi
                    </div>

                    <div class="pw-grid">
                        <div class="field-group">
                            <label class="field-label">Kata Sandi Baru</label>
                            <div class="password-wrap">
                                <input type="password" name="password" id="pw1" class="input-field"
                                    placeholder="Min. 8 karakter">
                                <button type="button" class="toggle-pw" onclick="togglePw('pw1', this)">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="field-group">
                            <label class="field-label">Konfirmasi Kata Sandi</label>
                            <div class="password-wrap">
                                <input type="password" name="password_confirmation" id="pw2" class="input-field"
                                    placeholder="Ulangi kata sandi baru">
                                <button type="button" class="toggle-pw" onclick="togglePw('pw2', this)">
                                    <i class="ti ti-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <footer class="page-footer">
        <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
        <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
    </footer>

</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            const wrap = input.closest('.foto-wrap');
            let img = wrap.querySelector('img');
            if (!img) {
                wrap.querySelector('.foto-placeholder')?.remove();
                img = document.createElement('img');
                img.style.cssText = 'width:110px;height:110px;border-radius:12px;object-fit:cover;border:2px solid #e5e7eb;';
                wrap.insertBefore(img, wrap.querySelector('.foto-edit-btn'));
            }
            img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function togglePw(id, btn) {
    const input = document.getElementById(id);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.querySelector('i').className = isHidden ? 'ti ti-eye-off' : 'ti ti-eye';
}
</script>

</body>
</html>