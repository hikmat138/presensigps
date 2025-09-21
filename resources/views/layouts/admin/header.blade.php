@php
    // ambil 1 lokasi_kantor dari tabel
    $lokasi_kantor = DB::table('lokasi_kantor')->value('lokasi_kantor');
@endphp

<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none" style="background-color: yellow;">
  <div class="container-xl">
    <div class="navbar-nav flex-row order-md-last">
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm">
            <img src="{{ asset('uploads/pegawai/'.$admin->foto) }}">
          </span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::guard('user')->user()->name }}</div>
            <div class="mt-1 small text-muted">ADMIN</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="/profiladmin" class="dropdown-item">Profile</a>
          <a href="./settings.html" class="dropdown-item">Settings</a>
          <a href="/panel/proseslogoutadmin" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
    <div class="collapse navbar-collapse" id="navbar-menu">
      <div class="w-100 text-center">
        <span style="color:green; font-size:20px; font-weight:600; background-color:yellow; padding:8px 12px; border-radius:4px; display:inline-block;">
          APLIKASI ABSENSI ONLINE GPS GURU HONOR {{ $lokasi_kantor ?? 'Nama Sekolah' }}
        </span>
      </div>
    </div>
  </div>
</header>
