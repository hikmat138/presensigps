<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>@yield('title')</title>

    <!-- CSS files -->
    <link href="{{asset('tabler/dist/css/tabler.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-flags.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-payments.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/tabler-vendors.min.css?1674944402')}}" rel="stylesheet"/>
    <link href="{{asset('tabler/dist/css/demo.min.css?1674944402')}}" rel="stylesheet"/>
    <link rel="icon" type="image/png" href="{{asset('assets/img/sample/sekolah.png')}}" sizes="32x32">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
        --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      
      body {
        font-feature-settings: "cv03", "cv04", "cv11";
      }

      /* === Fix Scroll Horizontal === */
      html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden; /* cegah scroll horizontal */
      }
      .page, .page-wrapper {
        max-width: 100%;
        overflow-x: hidden;
      }

      /* Gambar tidak boleh lebih besar dari container */
      img {
        max-width: 100%;
        height: auto;
      }

      /* Tabel tetap bisa discroll horizontal kalau terlalu lebar */
      .table-responsive {
        width: 100%;
        overflow-x: auto;
      }
      
    </style>
  </head>
  <body>
    <script src="{{asset('tabler/dist/js/demo-theme.min.js?1674944402')}}"></script>

    <div class="page">
      @include('layouts.admin.sidebar')

      <!-- Navbar -->
      @include('layouts.admin.header')

      <div class="page-wrapper">
        @yield('content')
      </div>
    </div>

    @include('layouts.admin.footer')

    <!-- Libs JS -->
    <script src="{{asset('tabler/dist/libs/apexcharts/dist/apexcharts.min.js?1674944402')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1674944402')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/maps/world.js?1674944402')}}" defer></script>
    <script src="{{asset('tabler/dist/libs/jsvectormap/dist/maps/world-merc.js?1674944402')}}" defer></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>

    <!-- Tabler Core -->
    <script src="{{asset('tabler/dist/js/tabler.min.js?1674944402')}}" defer></script>
    <script src="{{asset('tabler/dist/js/demo.min.js?1674944402')}}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('myscript')
  </body>
</html>
