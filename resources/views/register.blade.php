<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PLNetwork</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Poppins',sans-serif;
        }

       body{
    background:#ffffff;
    min-height:100vh;
    overflow:auto;
}

/* HEADER */
.header{
    height:95px;
    background:#f4f3f9;
    display:flex;
    align-items:center;
    padding:0 50px;
}

.logo{
    height:125px;
    width:auto;
}

.divider{
    width:1px;
    height:45px;
    background:#d9d9d9;
    margin-left:20px;
}

/* CONTAINER */
.container{
    min-height:calc(100vh - 95px);
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* CARD */
.card{
    width:100%;
    max-width:440px;
    background:#fff;
    border:1px solid #cfcfcf;
    border-radius:28px;
    padding:40px;
    box-shadow:0 5px 20px rgba(0,0,0,0.05);
    overflow-y:auto;
}

.btn{
    width:100%;
    margin-top:20px;
    background:#173a84;
    color:white;
    border:none;
    border-radius:12px;
    padding:14px;
    font-size:20px;
    font-weight:600;
    cursor:pointer;
}

        .profile{
            text-align:center;
            margin-bottom:5px;
        }

        .profile img{
            width:60px;
            opacity:0.4;
        }

        h1{
            text-align:center;
            font-size:22px;
            font-weight:700;
            margin-bottom:2px;
        }

        .subtitle{
            text-align:center;
            font-size:13px;
            color:#666;
            margin-bottom:14px;
        }

        .row{
            display:flex;
            gap:8px;
        }

        .form-group{
            width:100%;
            margin-bottom:8px;
        }

        label{
            display:block;
            margin-bottom:6px;
            font-size:14px;
            color:#222;
        }

        input,
        select{
            width:100%;
            padding:14px;
            border:1px solid #bdbdbd;
            border-radius:10px;
            background:#f4f3f9;
            font-size:14px;
            outline:none;
        }

        .btn{
            width:75%;
            margin:15px auto 0;
            display:block;
            background:#173a84;
            color:white;
            border:none;
            border-radius:12px;
            padding:10px;
            font-size:18px;
            font-weight:600;
            cursor:pointer;
        }

        .btn:hover{
            opacity:0.95;
        }

        .login-link{
            text-align:center;
            margin-top:10px;
            font-size:14px;
        }

        .login-link a{
            color:#447693;
            text-decoration:none;
        }

        .footer{
    text-align:center;
    margin-top:12px;
    color:#8a8a8a;
    font-size:12px;
    line-height:1.8;
    border-top:1px solid #ebebeb;
    padding-top:10px;
    padding-bottom:0;
}

        /* ICON INPUT */

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

        .input-wrapper input,
        .password-wrapper input{
            padding-left:45px;
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

    .row{
        flex-direction:column;
        gap:0;
    }

    .btn{
        font-size:18px;
    }
}

@media (max-width:480px){

    .container{
    display:flex;
    justify-content:center;
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

    .subtitle{
        font-size:13px;
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

    <!-- FORM REGISTER -->
    <div class="container">
        <div class="card">

            <div class="profile">
                <img src="{{ asset('images/user.svg') }}" alt="User">
            </div>

            <h1>Buat Akun</h1>

            <p class="subtitle">
                Masukkan data Anda untuk membuat akun sistem
            </p>

            <form>

                <div class="row">

                    <div class="form-group">
                        <label>Nama Lengkap</label>

                        <div class="input-wrapper">
                            <img src="{{ asset('images/profile.svg') }}" class="input-icon">

                            <input type="text" placeholder="cth: John Doe">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Divisi</label>

                        <select>
                            <option>Distribusi</option>
                            <option>Perencanaan</option>
                            <option>Niaga</option>
                            <option>STI</option>
                        </select>
                    </div>

                </div>

                <div class="form-group">
                    <label>Email Aktif</label>

                    <div class="input-wrapper">
                        <img src="{{ asset('images/email.svg') }}" class="input-icon">

                        <input type="email" placeholder="123@gmail.com">
                    </div>
                </div>

               <div class="form-group">
    <label>Kata Sandi</label>

    <div class="password-wrapper">
        <img src="{{ asset('images/password.svg') }}" class="input-icon">

        <input type="password" id="password" placeholder="**********">

        <span class="eye-icon" id="togglePassword">
            <svg id="eyeIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
            </svg>
        </span>
    </div>
</div>

                <button type="submit" class="btn">
                    DAFTAR →
                </button>

            </form>

            <div class="login-link">
                Sudah punya akun?
                <a href="/login">Masuk</a>
            </div>

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
            // password disembunyikan
            password.type = 'password';

            // icon eye dengan garis
            eyeIcon.innerHTML = `
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
                <path d="M4 4L20 20" stroke="#7E7E7E" stroke-width="2" stroke-linecap="round"/>
            `;

        } else {
            // password ditampilkan
            password.type = 'text';

            // icon eye tanpa garis
            eyeIcon.innerHTML = `
                <path d="M22.4133 11.6867C20.1667 7.53334 16.2267 5.02 11.8667 5.02C7.50667 5.02 3.56 7.53334 1.33333 11.6867L1.14667 12L1.32 12.32C3.56667 16.4733 7.50667 18.9867 11.8667 18.9867C16.2267 18.9867 20.1733 16.5067 22.4133 12.32L22.5867 12L22.4133 11.6867Z" fill="#7E7E7E"/>
                <path d="M12.06 16.5933C14.5858 16.5933 16.6334 14.5458 16.6334 12.02C16.6334 9.49422 14.5858 7.44667 12.06 7.44667C9.53425 7.44667 7.48669 9.49422 7.48669 12.02C7.48669 14.5458 9.53425 16.5933 12.06 16.5933Z" fill="#7E7E7E"/>
            `;
        }

    });

});
</script>

</body>
</html>