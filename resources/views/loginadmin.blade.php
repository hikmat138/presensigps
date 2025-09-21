
<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>E-PRESENSI ADMIN</title>
    <!-- CSS files -->
    <link href="{{asset('tabler/dist/css/tabler.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-flags.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-payments.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-vendors.min.css?1674944402')}}" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="{{asset('assets/img/sample/sekolah.png')}}" sizes="32x32">
    <link href="{{asset('tabler/dist/css/demo.min.css?1674944402')}}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{asset('tabler/dist/js/demo-theme.min.js?1674944402')}}"></script>
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="./static/logo.svg" height="36" alt=""></a>
              </div>
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">Login Admin</h2>
                  @php 
                  $message = Session::get('Error'); 
                  @endphp
                  @if ($message)
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            icon: 'Error',
            title: 'Gagal',
            text: '{{ $message }}',
            confirmButtonText: 'OK'
        });
    </script>
@endif
                  <form action="/panel/prosesloginadmin" method="POST" autocomplete="off" novalidate>
                  @csrf  
                  <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off">
                    </div>
                    <div class="mb-2">
  <label class="form-label">
    Password
  </label>
  <div class="input-group input-group-flat">
    <input type="password" id="password" name="password" class="form-control" placeholder="Your password" autocomplete="off">
    <span class="input-group-text">
      <a href="javascript:void(0)" class="link-secondary" title="Show password" onclick="togglePassword()">
        <!-- Ikon mata -->
        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" 
             viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" 
             stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
          <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
        </svg>
      </a>
    </span>
  </div>
</div>
<span class="form-label-description">
      <a href="./forgot-password.html">I forgot password</a>
    </span>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary w-100">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="{{asset('tabler/static/illustrations/undraw_secure_login_pdn4.svg')}}" height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('tabler/dist/js/tabler.min.js?1674944402')}}" defer></script>
    <script src="{{asset('tabler/dist/js/demo.min.js?1674944402')}}" defer></script>
    <script>
function togglePassword() {
  var input = document.getElementById("password");
  var eyeIcon = document.getElementById("eyeIcon");

  if (input.type === "password") {
    input.type = "text";
    // ganti ikon jadi "eye-off"
    eyeIcon.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>' +
                        '<path d="M3 3l18 18" />' +
                        '<path d="M10.584 10.587a2 2 0 0 0 2.829 2.828" />' +
                        '<path d="M9.363 5.365c.867 -.227 1.78 -.365 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.363 -1.67 2.457 -2.674 3.283m-3.522 2.165c-1.226 .355 -2.398 .552 -3.804 .552c-4 0 -7.333 -2.333 -10 -7c1.28 -2.24 2.72 -3.868 4.32 -4.888" />';
  } else {
    input.type = "password";
    // kembalikan ikon jadi "eye"
    eyeIcon.innerHTML = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>' +
                        '<path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />' +
                        '<path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />';
  }
}
</script>
  </body>
</html>