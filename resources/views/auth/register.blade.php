
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - ZaWash</title>

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

        /* LEFT SIDE */
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

        /* RIGHT SIDE */
.right-side {
    width: 55%;
    padding: 70px;
    display: flex;
    flex-direction: column;
    overflow-y: auto;        /* ⬅ supaya bisa scroll */
    max-height: 100%;        /* ⬅ supaya tinggi mengikuti container */

        }

        .right-side h2 {
            font-size: 26px;
            margin-bottom: 35px;
            color: #1a1a1a;
        }

        .input-group {
            margin-bottom: 20px;
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
            margin: 0 auto;
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

        .login-link {
            margin-top: 45px;
            text-align: center;
            font-size: 15px;
        }

        .login-link a {
            color: #1a73e8;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
@media (max-width: 768px) {

    body {
        min-height: 100vh;
        padding: 20px;
        display: flex;
        justify-content: center;
        align-items: flex-start;
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
        padding: 40px 25px;
        text-align: center;
        align-items: center;
    }

    .left-side h1 {
        font-size: 26px;
    }

    .left-side p {
        font-size: 13px;
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

    .input-group input {
        max-width: 100%;
    }

    button {
        width: 100%;
        max-width: none;
    }

    .back-btn {
        width: 100%;
        max-width: none;
    }

    .login-link {
        margin-top: 20px;
        font-size: 14px;
    }
    html {
    scroll-behavior: smooth;
}

}

    </style>

</head>

<body>

<div class="container">

    <div class="left-side">
        <h1>Gabung ke ZaWash</h1>
        <p>Buat akun baru untuk mengakses sistem layanan.</p>
    </div>

    <div class="right-side">
        <h2>Buat Akun</h2>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="input-group">
                <label>Nama</label>
                <input type="text" name="name" required placeholder="Masukkan nama" value="{{ old('name') }}">
            </div>

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" required placeholder="Masukkan email" value="{{ old('email') }}">
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" required placeholder="Masukkan password">
            </div>

            <div class="input-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required placeholder="Ulangi password">
            </div>

            <button type="submit">Daftar</button>

            <button type="button" onclick="history.back()" class="back-btn">Kembali</button>

            <div class="login-link">
                Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
            </div>

        </form>
    </div>

</div>

</body>
</html>
