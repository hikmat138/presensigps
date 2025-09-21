@extends('layouts.presensi')

@section('title', 'Ubah Password')
@section('header')
<div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengaturan</div>
        <div class="right"></div>
</div>
@endsection

@section('content')
<head>
    <style>
        body {
            background: #2053a0ff;
            font-family: 'Arial', sans-serif;
        }
        .login-form {
            max-width: 400px;
            margin: 90px auto;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-form img {
            width: 200px;
            margin-bottom: 15px;
        }
        .login-form h1 {
            font-weight: bold;
            margin-bottom: 2px;
            color: #222;
        }
        .login-form h4 {
            font-size: 16px;
            color: #555;
            margin-bottom: 25px;
        }
        .input-wrapper {
            position: relative;
            margin-bottom: 20px;
        }
        .input-wrapper input {
            width: 100%;
            padding: 12px 5px 12px 5px;
            border: 1px solid #575454ff;
            border-radius: 10px;
            outline: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }
        .input-wrapper input:focus {
            border-color: #28a745;
            box-shadow: 0 0 5px rgba(40,167,69,0.4);
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
            font-size: 20px;
        }
        .form-button-group button {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            background: linear-gradient(45deg, #28a745, #4cd964);
            color: white;
            transition: background 0.3s ease; /* atau absolute/fixed kalau mau benar-benar di atas */
            position: absolute; 
            bottom: 90px; /* jarak dari bawah */
            left: 50%;
            transform: translateX(-50%);
            z-index: 20;
            
        }
        .form-button-group button:hover {
            background: linear-gradient(45deg, #218838, #34c759);
        }
    </style>
</head>

<body>

    <div id="appCapsule">
        <div class="login-form">
            <form action="/updatepassword" method="POST">
        @csrf

        <!-- Password Baru -->
        <div class="input-wrapper">
            <input type="password" id="password_baru" name="password_baru" placeholder="Password Baru" required>
            <span class="toggle-password" onclick="togglePassword('password_baru', this)">
                <ion-icon name="eye-outline"></ion-icon>
            </span>
        </div>

        <!-- Konfirmasi Password Baru -->
        <div class="input-wrapper">
            <input type="password" id="password_konfirmasi" name="password_baru_confirmation" placeholder="Konfirmasi Password Baru" required>
            <span class="toggle-password" onclick="togglePassword('password_konfirmasi', this)">
                <ion-icon name="eye-outline"></ion-icon>
            </span>
        </div>

        <!-- Tombol Simpan -->
        <div class="form-button-group">
            <button type="submit" class="btn-simpan">Simpan Password</button>
        </div>
    </form>
</div>
</div>

    <!-- Ionicons -->
    
@endsection
@push('myscript')
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Script Show/Hide Password -->
    <script>
    function togglePassword(inputId, el) {
        var input = document.getElementById(inputId);
        var icon = el.querySelector("ion-icon");
        if (input.type === "password") {
            input.type = "text";
            icon.setAttribute("name", "eye-off-outline");
        } else {
            input.type = "password";
            icon.setAttribute("name", "eye-outline");
        }
    }
</script>
@endpush
