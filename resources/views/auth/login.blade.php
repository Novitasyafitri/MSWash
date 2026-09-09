<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun - MSWash</title>

    <!-- FONT POPPINS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: url('cuci mobil.jpg') no-repeat center center/cover;
            position: relative;
        }

        body::before {
            content: "";
            position: absolute;
            inset: 0;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.45);
        }

        .container {
            width: 880px;
            height: 560px;
            background: #fff;
            display: flex;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.25);
            position: relative;
            z-index: 10;
        }

        /* BAGIAN KIRI */
        .left-side {
            width: 45%;
            background: linear-gradient(
                140deg,
                rgba(26,115,232,0.85),
                rgba(74,163,255,0.80)
            );
            backdrop-filter: blur(2px);
            color: white;
            padding: 60px 45px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .left-side h1 {
            font-size: 32px;
            font-weight: 700;
            line-height: 1.3;
        }

        .left-side p {
            margin-top: 10px;
            font-size: 14px;
            opacity: .9;
        }

        /* BAGIAN KANAN */
        .right-side {
        width: 55%;
        padding: 50px 70px;   /* 🔥 naikkan posisi form */
        display: flex;
        flex-direction: column;
        }


        .right-side h2 {
            font-size: 26px;
            margin-bottom: 40px;
            color: #1a1a1a;
        }
        /* Jarak antara judul dan input pertama */
        .input-group:first-of-type {
        margin-top: 20px;  /* bisa 25px atau 30px sesuai selera */
        }

        .input-group {
            margin-bottom: 25px;
        }

        .input-group label {
            font-size: 15px;
            color: #333;
        }

        .input-group input {
            margin-top: 8px;
            width: 100%;
            max-width: 350px;
            padding: 12px 15px;
            border-radius: 10px;
            border: 1.5px solid #b5d6f7;
            outline: none;
            transition: 0.2s;
        }

        .input-group input:focus {
            border-color: #1a73e8;
            box-shadow: 0 0 0 3px rgba(26,115,232,0.2);
        }

        button {
            width: 350px;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: #1a73e8;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin: 20px auto 0;
            display: block;
            transition: .2s;
        }

        button:hover {
            background: #0d5fcc;
        }

        .back-btn {
            margin-top: 12px;
            background: #e7e7e7;
            color: #333;
        }

        .back-btn:hover {
            background: #d2d2d2;
        }

        .register-link {
            margin-top: 35px;
            text-align: center;
            font-size: 15px;
        }

        .register-link a {
            color: #1a73e8;
            text-decoration: none;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
       /* RESPONSIVE VERSION */
@media (max-width: 768px) {

    body {
        min-height: 100vh;
         height: auto; 
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .container {
        width: 100%;
        max-width: 430px;
        height: auto;              /* 🔥 FIX UTAMA */
        min-height: 100%;          /* 🔥 SUPAYA PANJANG DI IKUTI */
        flex-direction: column;
        border-radius: 16px;
    }
    .left-side {
        width: 100%;
        padding: 35px 25px;
        text-align: center;
        align-items: center;
    }

    .left-side h1 {
        font-size: 24px;
    }

    .left-side p {
        font-size: 13px;
        max-width: 260px;
    }

     .right-side {
        width: 100%;
        padding: 35px 25px;
        max-height: none;          /* penting */
        overflow-y: visible;       /* penting */
    }

    .right-side h2 {
        font-size: 22px;
        text-align: center;
        margin-bottom: 25px;
    }

    .input-group {
        width: 100%;
    }

    .input-group input {
        max-width: 100%;
    }

    button {
        width: 100%;
        margin-top: 5px;
    }

    .back-btn {
        width: 100%;
    }

    .register-link {
        margin-top: 20px;
        font-size: 14px;
    }

}

    </style>
</head>

<body>

<div class="container">

    <div class="left-side">
        <h1>Selamat Datang<br>Di Sistem MSWash</h1>
        <p>Silakan masuk untuk melanjutkan akses ke dashboard.</p>
    </div>

    <div class="right-side">
        <h2>Masuk Akun</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Masukkan email">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>
            @if ($errors->any())
    <div style="
        background:#fee2e2;
        color:#b91c1c;
        padding:12px 15px;
        border-radius:10px;
        font-size:14px;
        margin-bottom:25px;
        border:1px solid #fca5a5;">
        <strong> Email atau password tidak sesuai</strong><br>
    </div>
@endif


            <button type="submit">Masuk</button>
            </form>  
<button type="button" class="back-btn" onclick="window.location.href='{{ url('/') }}'">
    Kembali
</button>
    </div>

</div>

</body>
</html>
