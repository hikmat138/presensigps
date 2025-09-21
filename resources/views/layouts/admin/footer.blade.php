@php
    // ambil 1 lokasi_kantor dari tabel
    $lokasi_kantor = DB::table('lokasi_kantor')->value('lokasi_kantor');
@endphp
<footer class="navbar" style="background-color: yellow; text-align: center; width: 100%;">
  <div class="container-fluid">
    <span class="mx-auto fw-bold">
      © 2025 APLIKASI ABSENSI ONLINE GPS GURU HONOR {{ $lokasi_kantor ?? 'Nama Sekolah' }}
    </span>
  </div>
</footer>
