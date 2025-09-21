@extends('layouts.admin.tabler')
@section('title', 'Dashboard Admin')
@section('content')

<style>
    #map {
        height: 200px;
        border-radius: 10px;
    }
    /* 📱 Mobile Responsiveness */
    @media (max-width: 768px) {
        #map {
            height: 200px; /* lebih kecil biar muat di layar hp */
        }

    @media (max-width: 480px) {
        #map {
            height: 180px; /* layar hp kecil (4–5 inch) */
        }
    }
}
</style>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Overview
                </div>
                <h2 class="page-title">
                  Dashboard Admin
                </h2>
                 <h5 style="font-weight:bold;">
                Hari/Tanggal : {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
            — Waktu : <span id="clock"></span> WIB
        </h5>
              </div>
</div>
<div class="page-body" style= align-items: center;>
<div class="container-xl">
    <div class="row" style="display: flex; justify-content: center; align-items: center;">
        <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-primary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          @php
                          $jumlahPegawai = \Illuminate\Support\Facades\DB::table('pegawai')->count('nik');
                          @endphp
                          {{$jumlahPegawai}}
                        </div>
                        <div class="text-muted">
                          Jumlah Pegawai
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.5 21h-5.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v6" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M15 19l2 2l4 -4" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->jmlhadirmasuk ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Hadir Tepat Waktu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-info text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-text"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17l6 0" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{$rekapizin->jml_izin ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai Izin/Cuti
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-secondary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-heart"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M11.993 16.75l2.747 -2.815a1.9 1.9 0 0 0 0 -2.632a1.775 1.775 0 0 0 -2.56 0l-.183 .188l-.183 -.189a1.775 1.775 0 0 0 -2.56 0a1.899 1.899 0 0 0 0 2.632l2.738 2.825z" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{$rekapizin->jml_sakit ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai izin Sakit
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-secondary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar --><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" /><path d="M22 22l-5 -5" /><path d="M17 22l5 -5" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->tidakabsenmasuk ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai Tidak Masuk
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    </div>
</div>
</div>
<div class="page-body" style= "display: flex; justify-content: center; align-items: center; margin-top:10px;">
<div class="container-xl" style= "display: flex; justify-content: center; align-items: center;">
    <div class="row" style= "display: flex; justify-content: center; align-items: center;">
        <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-warning text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plane-departure"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14.639 10.258l4.83 -1.294a2 2 0 1 1 1.035 3.863l-14.489 3.883l-4.45 -5.02l2.897 -.776l2.45 1.414l2.897 -.776l-3.743 -6.244l2.898 -.777l5.675 5.727z" /><path d="M3 21h18" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{$rekapdinas->jml_dinas ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai Dinas Luar
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-success text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-time"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /><path d="M18 16.496v1.504l1 1" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->jmlpulang ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pulang Tepat Waktu
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-time"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /><path d="M18 16.496v1.504l1 1" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->jmltelat ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai Terlambat
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-danger text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-time"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M11.795 21h-6.795a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v4" /><path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M15 3v4" /><path d="M7 3v4" /><path d="M3 11h16" /><path d="M18 16.496v1.504l1 1" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->jmlcepat ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Pegawai Pulang Cepat
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6 col-xl-2">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-secondary text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plane-off"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.788 5.758l-.788 -2.758h3l4 7h4a2 2 0 1 1 0 4h-2m-2.718 1.256l-3.282 5.744h-3l2 -7h-4l-2 2h-3l2 -4l-2 -4h3l2 2h3" /><path d="M3 3l18 18" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">
                          {{ $rekap->tidakabsenpulang ?? 0 }}
                        </div>
                        <div class="text-muted">
                          Tidak Absen Pulang
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
    </div>
</div>
</div>


<div class="page-body">
    <div class="container-xl">
        <div class="row">
<h5>Lokasi Sekolah</h5>
    <div id="map"></div>
</div>
        </div>
    </div>
    
@endsection
@push('myscript')
<script>
    var sekolahLat = "{{ $lokasi->latitude ?? '-6.101695598695387' }}";
    var sekolahLng = "{{ $lokasi->longitude ?? '106.13130086931487' }}";
    var radius = {{ $lokasi->radius ?? 100 }};

    sekolahLat = parseFloat(sekolahLat);
    sekolahLng = parseFloat(sekolahLng);

    // Inisialisasi map di posisi sekolah
    var map = L.map('map').setView([sekolahLat, sekolahLng], 15);

    // Tambahkan tile layer (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Tambahkan marker sekolah
    var marker = L.marker([sekolahLat, sekolahLng]).addTo(map);

    // Tambahkan radius area sekolah (circle)
    

    // Event klik pada map
    map.on('click', function(e) {
        L.popup()
            .setLatLng(e.latlng)
            .setContent(`
                <b>{{ $lokasi->lokasi_kantor ?? 'Lokasi Kantor' }}</b><br>
                Koordinat: ${sekolahLat}, ${sekolahLng} <br>
                Radius: ${radius} meter<br>
            `)
            .openOn(map);
    });

    // Jam digital
    function updateClock() {
        let now = new Date();
        let jam = String(now.getHours()).padStart(2, '0');
        let menit = String(now.getMinutes()).padStart(2, '0');
        let detik = String(now.getSeconds()).padStart(2, '0');
        document.getElementById('clock').innerText = jam + ":" + menit + ":" + detik;
    }
    setInterval(updateClock, 1000);
    updateClock();
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush