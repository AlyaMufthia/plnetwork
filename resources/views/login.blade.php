<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PLNetwork</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

        body{
            min-height:100vh;
            overflow-y:auto;
            position:relative;
            background:linear-gradient(160deg, #e3ecfb 0%, #b9d0f5 55%, #85aeea 100%);
        }

        body::before{
            content:'';
            position:fixed;
            top:-40px;
            left:10%;
            width:340px;
            height:340px;
            background:#ffffff;
            border-radius:50%;
            filter:blur(90px);
            opacity:0.5;
            z-index:0;
            pointer-events:none;
        }

        body::after{
            content:'';
            position:fixed;
            bottom:-80px;
            right:-40px;
            width:300px;
            height:300px;
            background:#5c8ce8;
            border-radius:50%;
            filter:blur(90px);
            opacity:0.25;
            z-index:0;
            pointer-events:none;
        }

        .header{
            height:95px;
            background:rgba(255,255,255,0.55);
            backdrop-filter:blur(6px);
            display:flex;
            align-items:center;
            padding:0 50px;
            position:relative;
            z-index:1;
        }

        .logo{
            height:90px;
            width:auto;
        }

        .divider{
            width:1px;
            height:45px;
            background:#d9d9d9;
            margin-left:20px;
        }

        .container{
            min-height:calc(100vh - 95px);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:20px;
            position:relative;
            z-index:1;
        }

        .card{
            width:100%;
            max-width:440px;
            background:#fff;
            border:1px solid #cfcfcf;
            border-radius:28px;
            padding:40px;
            box-shadow:0 10px 34px rgba(23,58,132,0.16);
        }

        .profile{
            text-align:center;
            margin-bottom:10px;
        }

        .profile img{
            width:60px;
            opacity:0.4;
        }

        h1{
            text-align:center;
            font-size:22px;
            font-weight:700;
            margin-bottom:4px;
        }

        .subtitle{
            text-align:center;
            font-size:13px;
            color:#666;
            margin-bottom:16px;
        }

        .form-group{
            width:100%;
            margin-bottom:10px;
        }

        label{
            font-size:14px;
            color:#222;
        }

        input{
            width:100%;
            padding:14px 14px 14px 45px;
            border:1px solid #bdbdbd;
            border-radius:10px;
            background:#f4f3f9;
            font-size:14px;
            outline:none;
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
            width:18px;
            height:18px;
            opacity:0.7;
        }

        .eye-icon{
            position:absolute;
            right:14px;
            top:50%;
            transform:translateY(-50%);
            width:18px;
            height:18px;
            opacity:0.7;
            cursor:pointer;
        }

        .btn{
            width:75%;
            margin:10px auto 0;
            display:block;
            background:#173a84;
            color:white;
            border:none;
            border-radius:12px;
            padding:12px 0;
            font-size:18px;
            font-weight:600;
            cursor:pointer;
        }

        .btn:hover{
            opacity:0.95;
        }

        .footer{
            text-align:center;
            margin-top:12px;
            color:#8a8a8a;
            font-size:12px;
            line-height:1.8;
            border-top:1px solid #ebebeb;
            padding-top:10px;
        }

        @media (max-width:768px){
            .header{
                height:80px;
                padding:0 20px;
            }
            .logo{
                height:75px;
            }
            .card{
                padding:30px 25px;
            }
            .btn{
                font-size:18px;
            }
        }

        @media (max-width:480px){
            .container{
                align-items:flex-start;
                margin-top:15px;
            }
            .card{
                padding:25px 20px;
                border-radius:20px;
            }
            h1{
                font-size:24px;
            }
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <img src="{{ asset('images/logo-plnetwork.png') }}" alt="PLNetwork Logo" class="logo">
        <div class="divider"></div>
    </div>

    <!-- FORM LOGIN -->
    <div class="container">
        <div class="card">

            <div class="profile">
                <img src="{{ asset('images/user.svg') }}" alt="User">
            </div>

            <h1>Masuk</h1>

            <p class="subtitle">
                Masukkan kredensial Anda untuk mengakses sistem
            </p>

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
                                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn">
                    MASUK ➜
                </button>

            </form>

            <!-- FOOTER -->
            <div class="footer">
                <p>🛡 POWERING NORTH SUMATERA SAFELY</p>
                <p>© 2026 PLNetwork Hub Asset Management System. All maintenance records are digitally signed.</p>
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
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
                <path d="M4 4L20 20" stroke="#7E7E7E" stroke-width="2" stroke-linecap="round"/>
            `;
        } else {
            password.type = 'text';
            eyeIcon.innerHTML = `
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
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