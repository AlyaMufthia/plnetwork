<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLNetwork</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Poppins:wght@400;500;600&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root{
            --navy-950:#0d1524;
            --navy-900:#141f34;
            --panel:#ffffff;
            --panel-soft:#f6f8fc;
            --border-soft:#dde4f0;
            --brass:#a97b1f;
            --brass-light:#c9962c;
            --cyan:#0f9c90;
            --text-primary:#152036;
            --text-muted:#6b7893;
            --hairline:rgba(169,123,31,0.30);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        html,body{
            min-height:100vh;
        }

        body{
            position:relative;
            overflow-x:hidden;
            background:
                radial-gradient(ellipse 700px 500px at 12% -10%, rgba(15,156,144,0.08), transparent 60%),
                radial-gradient(ellipse 800px 600px at 88% 108%, rgba(169,123,31,0.10), transparent 60%),
                linear-gradient(160deg, #eef3fc 0%, #dbe6f8 55%, #c7d9f2 100%);
            color:var(--text-primary);
        }

        /* engineering blueprint grid */
        body::before{
            content:'';
            position:fixed;
            inset:0;
            background-image:
                linear-gradient(rgba(21,32,54,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(21,32,54,0.05) 1px, transparent 1px);
            background-size:42px 42px;
            mask-image:radial-gradient(ellipse 90% 80% at 50% 40%, #000 40%, transparent 100%);
            pointer-events:none;
            z-index:0;
        }

        /* ---------- diagnostics ticker ---------- */
        .ticker{
            position:relative;
            z-index:2;
            height:30px;
            background:var(--navy-950);
            border-bottom:1px solid var(--hairline);
            overflow:hidden;
            display:flex;
            align-items:center;
        }

        .ticker-track{
            display:flex;
            gap:48px;
            white-space:nowrap;
            padding-left:100%;
            animation:scroll-ticker 26s linear infinite;
            font-family:'JetBrains Mono',monospace;
            font-size:11px;
            letter-spacing:0.06em;
            color:#9aa8c7;
        }

        .ticker-track span{ color:var(--brass-light); }

        @keyframes scroll-ticker{
            0%{ transform:translateX(0); }
            100%{ transform:translateX(-100%); }
        }

        /* ---------- header ---------- */
        .header{
            position:relative;
            z-index:2;
            height:88px;
            display:flex;
            align-items:center;
            padding:0 50px;
            border-bottom:1px solid var(--border-soft);
            background:rgba(255,255,255,0.6);
            backdrop-filter:blur(8px);
        }

        .logo{
            height:72px;
            width:auto;
        }

        .divider{
            width:1px;
            height:32px;
            background:var(--hairline);
            margin:0 20px;
        }

        .header-label{
            font-family:'JetBrains Mono',monospace;
            font-size:11.5px;
            letter-spacing:0.14em;
            color:var(--text-muted);
            text-transform:uppercase;
        }

        .header-label b{ color:var(--brass-light); font-weight:600; }

        /* ---------- container / card ---------- */
        .container{
            position:relative;
            z-index:2;
            min-height:calc(100vh - 118px);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:40px 20px;
        }

        .card-frame{
            position:relative;
            width:100%;
            max-width:440px;
            padding:22px;
        }

        /* blueprint corner brackets */
        .card-frame::before,
        .card-frame::after,
        .card-frame > .corner-tr,
        .card-frame > .corner-bl{
            content:'';
            position:absolute;
            width:26px;
            height:26px;
            border:2px solid var(--brass);
            opacity:0.85;
        }
        .card-frame::before{ top:0; left:0; border-right:none; border-bottom:none; }
        .card-frame::after{ bottom:0; right:0; border-left:none; border-top:none; }
        .corner-tr{ top:0; right:0; border-left:none; border-bottom:none; }
        .corner-bl{ bottom:0; left:0; border-right:none; border-top:none; }

        .card{
            width:100%;
            background:var(--panel);
            border:1px solid var(--border-soft);
            border-radius:6px;
            padding:44px 40px 32px;
            box-shadow:
                0 30px 60px -25px rgba(21,32,54,0.28),
                0 0 0 1px rgba(255,255,255,0.5) inset;
        }

        /* pulse / oscilloscope trace */
        .pulse-wrap{
            margin:0 auto 22px;
            width:100%;
            height:34px;
        }
        .pulse-wrap svg{ width:100%; height:100%; display:block; }
        .pulse-path{
            stroke:var(--cyan);
            stroke-width:1.6;
            fill:none;
            filter:drop-shadow(0 0 4px rgba(79,209,197,0.55));
            stroke-dasharray:220;
            stroke-dashoffset:220;
            animation:draw-pulse 3.2s ease-in-out infinite;
        }
        @keyframes draw-pulse{
            0%{ stroke-dashoffset:220; }
            45%{ stroke-dashoffset:0; }
            100%{ stroke-dashoffset:-220; }
        }

        .badge-ring{
            width:56px;
            height:56px;
            margin:0 auto 18px;
            border-radius:50%;
            background:var(--panel-soft);
            border:1px solid var(--hairline);
            display:flex;
            align-items:center;
            justify-content:center;
            position:relative;
        }
        .badge-ring::before{
            content:'';
            position:absolute;
            inset:-6px;
            border-radius:50%;
            border:1px solid rgba(169,123,31,0.35);
            animation:ring-pulse 2.6s ease-out infinite;
        }
        @keyframes ring-pulse{
            0%{ transform:scale(0.85); opacity:0.9; }
            100%{ transform:scale(1.35); opacity:0; }
        }
        .badge-ring img{
            width:22px;
            height:22px;
            opacity:0.75;
        }

        h1{
            text-align:center;
            font-family:'Fraunces', serif;
            font-weight:600;
            font-size:28px;
            letter-spacing:0.01em;
            margin-bottom:6px;
            color:var(--text-primary);
        }

        .subtitle{
            text-align:center;
            font-family:'JetBrains Mono',monospace;
            font-size:11.5px;
            letter-spacing:0.09em;
            text-transform:uppercase;
            color:var(--text-muted);
            margin-bottom:30px;
        }

        .form-group{
            width:100%;
            margin-bottom:16px;
        }

        label{
            display:block;
            font-family:'JetBrains Mono',monospace;
            font-size:10.5px;
            letter-spacing:0.1em;
            text-transform:uppercase;
            color:var(--brass-light);
            margin-bottom:7px;
        }

        input{
            width:100%;
            padding:13px 14px 13px 44px;
            border:1px solid var(--border-soft);
            border-radius:8px;
            background:var(--panel-soft);
            color:var(--text-primary);
            font-size:14px;
            outline:none;
            transition:border-color 0.2s ease, box-shadow 0.2s ease;
        }

        input::placeholder{ color:#9aa5bd; }

        input:focus{
            border-color:var(--brass);
            box-shadow:0 0 0 3px rgba(169,123,31,0.14);
        }

        .input-wrapper,
        .password-wrapper{
            position:relative;
        }

        .input-icon{
            position:absolute;
            left:14px;
            top:50%;
            transform:translateY(-50%);
            width:16px;
            height:16px;
            opacity:0.55;
        }

        .eye-icon{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            width:18px;
            height:18px;
            opacity:0.65;
            cursor:pointer;
        }

        .btn{
            width:100%;
            margin:20px 0 0;
            display:flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            background:linear-gradient(135deg, var(--brass-light), var(--brass));
            color:#1a1406;
            border:none;
            border-radius:8px;
            padding:13px 0;
            font-size:14px;
            font-weight:600;
            letter-spacing:0.04em;
            text-transform:uppercase;
            font-family:'Poppins',sans-serif;
            cursor:pointer;
            transition:transform 0.15s ease, box-shadow 0.15s ease;
            box-shadow:0 8px 24px -8px rgba(201,162,39,0.5);
        }

        .btn:hover{
            transform:translateY(-1px);
            box-shadow:0 12px 28px -8px rgba(201,162,39,0.65);
        }

        .btn:active{ transform:translateY(0); }

        .footer{
            text-align:center;
            margin-top:26px;
            padding-top:16px;
            border-top:1px solid var(--hairline);
        }

        .footer .shield-line{
            font-family:'JetBrains Mono',monospace;
            font-size:10px;
            letter-spacing:0.12em;
            color:var(--cyan);
            margin-bottom:5px;
        }

        .footer .copyright{
            font-size:11px;
            color:var(--text-muted);
            line-height:1.6;
        }

        @media (max-width:768px){
            .header{ height:80px; padding:0 22px; }
            .logo{ height:54px; }
            .card{ padding:36px 26px 28px; }
        }

        @media (max-width:480px){
            .container{ align-items:flex-start; padding-top:26px; }
            .card{ padding:30px 20px 24px; border-radius:10px; }
            h1{ font-size:24px; }
        }

        @media (prefers-reduced-motion: reduce){
            .ticker-track, .pulse-path, .badge-ring::before{ animation:none; }
        }
    </style>
</head>
<body>

    <!-- DIAGNOSTICS TICKER -->
    <div class="ticker">
        <div class="ticker-track">
            <span>● GRID STATUS: STABIL</span>
            <span>SEKTOR SUMUT 01–12</span>
            <span>UPTIME <span>99.98%</span></span>
            <span>● GRID STATUS: STABIL</span>
            <span>SEKTOR SUMUT 01–12</span>
            <span>UPTIME <span>99.98%</span></span>
            <span>● GRID STATUS: STABIL</span>
            <span>SEKTOR SUMUT 01–12</span>
            <span>UPTIME <span>99.98%</span></span>
        </div>
    </div>

    <!-- HEADER -->
    <div class="header">
        <img src="{{ asset('images/logo-plnetwork.png') }}" alt="PLNetwork Logo" class="logo">
        <div class="divider"></div>
        <div class="header-label"><b>PLNETWORK</b> — HUB ASSET MANAGEMENT SYSTEM</div>
    </div>

    <!-- FORM LOGIN -->
    <div class="container">
        <div class="card-frame">
            <span class="corner-tr"></span>
            <span class="corner-bl"></span>

            <div class="card">

                <div class="badge-ring">
                    <img src="{{ asset('images/user.svg') }}" alt="User">
                </div>

                <h1>Masuk ke Sistem</h1>

                <p class="subtitle">Autentikasi Akses Terbatas</p>

                <div class="pulse-wrap">
                    <svg viewBox="0 0 400 34" preserveAspectRatio="none">
                        <path class="pulse-path" d="M0,17 L120,17 L138,4 L154,30 L170,17 L400,17"/>
                    </svg>
                </div>

                <form>

                    <div class="form-group">
                        <label>Email Pengguna</label>
                        <div class="input-wrapper">
                            <img src="{{ asset('images/email.svg') }}" class="input-icon">
                            <input type="email" placeholder="123@gmail.com" autocomplete="off">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kata Sandi</label>
                        <div class="password-wrapper">
                            <img src="{{ asset('images/password.svg') }}" class="input-icon">
                            <input type="password" id="password" placeholder="**********" autocomplete="new-password">
                            <span class="eye-icon" id="togglePassword">
                                <svg id="eyeIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#C9A227"/>
                                    <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#C9A227"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="btn">
                        Masuk
                        <span>➜</span>
                    </button>

                </form>

                <!-- FOOTER -->
                <div class="footer">
                    <p class="shield-line">🛡 POWERING NORTH SUMATERA SAFELY</p>
                    <p class="copyright">© 2026 PLNetwork Hub Asset Management System.<br>All maintenance records are digitally signed.</p>
                </div>

            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const password = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');

    let isHidden = true;

    toggle.addEventListener('click', function () {
        isHidden = !isHidden;

        if (isHidden) {
            password.type = 'password';
            eyeIcon.innerHTML = `
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#C9A227"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#C9A227"/>
                <path d="M4 4L20 20" stroke="#C9A227" stroke-width="2" stroke-linecap="round"/>
            `;
        } else {
            password.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#C9A227"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#C9A227"/>
            `;
        }
    });

    // ✅ Validasi 1 akun statis
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.querySelector('input[type="email"]').value;
        const pwd = document.getElementById('password').value;

        if (email === 'admin@plnetwork.com' && pwd === 'admin123') {
            window.location.href = '/dashboard';
        } else {
            alert('Email atau kata sandi salah!');
        }
    });

});
</script>

</body>
</html>