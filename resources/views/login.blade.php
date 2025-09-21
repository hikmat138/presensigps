<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-PRESENSI</title>
    <link rel="icon" type="image/png" href="{{asset('assets/img/sample/sekolah.png')}}" sizes="32x32">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <style>
        body {
            background: #2053a0ff;
            font-family: 'Arial', sans-serif;
        }
        .login-form {
            max-width: 400px;
            margin: 40px auto;
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
            padding: 12px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            border: none;
            background: linear-gradient(45deg, #28a745, #4cd964);
            color: white;
            transition: background 0.3s ease;
        }
        .form-button-group button:hover {
            background: linear-gradient(45deg, #218838, #34c759);
        }
        .form-links {
            margin-bottom: 20px;
            text-align: right;
        }
        .form-links a {
            font-size: 13px;
            color: #007bff;
            text-decoration: none;
        }
        .form-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div id="appCapsule">
        <div class="login-form">
            <div class="section">
                <img src="{{asset('assets/img/sample/sekolah.png')}}" alt="image">
            </div>
            <div class="section">
                <h1>E-PRESENSI</h1>
                <h4>LOGIN DULU WIIIIH</h4>
            </div>
            <form action="/proseslogin" method="POST">
                @csrf
                <div class="input-wrapper">
                    <input type="text" name="nik" id="nik" placeholder="NIK" autocomplete="off">
                </div>

                <div class="input-wrapper">
                    <input type="password" id="password" name="password" placeholder="Password" autocomplete="new-password">
                    <span class="toggle-password" onclick="togglePassword()">
                        <ion-icon name="eye-outline"></ion-icon>
                    </span>
                </div>

                <div class="form-links">
                    <a href="/lupapassword">Lupa kata sandi?</a>
                </div>

                <div class="form-button-group">
                    <button type="submit">Log in</button>
                </div>
            </form>

            @php 
                $message = Session::get('Warning'); 
            @endphp

            @if ($message)
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                    Swal.fire({
                        icon: 'warning',
                        title: 'Oops...',
                        text: '{{ $message }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
        </div>
    </div>

    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <!-- Script Show/Hide Password -->
    <script>
        function togglePassword() {
            var input = document.getElementById("password");
            var icon = document.querySelector(".toggle-password ion-icon");
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("name", "eye-off-outline");
            } else {
                input.type = "password";
                icon.setAttribute("name", "eye-outline");
            }
        }
    </script>

</body>
</html>
