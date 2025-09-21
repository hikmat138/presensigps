@extends('layouts.presensi')

@section('title', 'Dashboard')
@section('header')
<style>
    #map {
        height: 300px;
        border-radius: 10px;
    }
    .gradasigreen {
        background: linear-gradient(to right, #28a745, #4cd964);
        color: white;
    }
    .gradasired {
        background: linear-gradient(to right, #dc3545, #ff6b6b);
        color: white;
    }
    .presencecontent {
        display: flex;
        align-items: center;
        justify-content: center; /* biar tengah */
        flex-wrap: wrap; /* kalau sempit turun ke bawah */
        text-align: center;
    }
    .iconpresence {
        font-size: 16px;
        margin-right: 8px;
    }
    /* Ikon di tombol */
.btn-absen ion-icon {
    font-size: 18px;
}

    /* 📱 Mobile Responsiveness */
    @media (max-width: 768px) {
        #map {
            height: 200px; /* lebih kecil biar muat di layar hp */
        }

        .presencecontent {
            flex-direction: column; /* icon di atas, text di bawah */
            gap: 5px;
        }

        .iconpresence {
            font-size: 20px; /* lebih besar biar kelihatan jelas di hp */
            margin: 0;
        }

        .presencecontent span,
        .presencecontent h4 {
            font-size: 14px; /* kecilkan teks supaya pas */
        }
    }

    @media (max-width: 480px) {
        #map {
            height: 180px; /* layar hp kecil (4–5 inch) */
        }

        .presencecontent span,
        .presencecontent h4 {
            font-size: 13px;
        }

        .iconpresence {
            font-size: 18px;
        }
    }
    @media (max-width: 576px) {
    .btn-absen {
        font-size: 13px;
        padding: 10px;
    }
    .btn-absen ion-icon {
        font-size: 16px;
    }
}
/* Tambahan styling tombol absen */
#takeabsen_masuk, 
#takeabsen_pulang {
    font-size: 14px;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px; /* Jarak antara icon & teks */
}

/* Icon */
#takeabsen_masuk ion-icon,
#takeabsen_pulang ion-icon {
    font-size: 18px;
}

/* Responsif untuk layar kecil (HP) */
@media (max-width: 576px) {
    #takeabsen_masuk,
    #takeabsen_pulang {
        font-size: 12px;
        padding: 10px;
    }

    #takeabsen_masuk ion-icon,
    #takeabsen_pulang ion-icon {
        font-size: 16px;
    }
}
/* Styling umum */
#tanggal-waktu {
    font-weight: bold;
    font-size: 16px;
    color: #333;
    text-align: center;
    line-height: 1.5;
    word-wrap: break-word;
    white-space: normal; /* biar bisa pindah baris */
    padding: 0 8px;
}

/* Span jam lebih menonjol */
#tanggal-waktu #clock {
    color: #007bff;
    font-weight: 700;
}

/* Responsif: layar kecil (HP) */
@media (max-width: 576px) {
    #tanggal-waktu {
        font-size: 13px;   /* kecilin lagi */
        line-height: 1.4;
    }

    #tanggal-waktu #clock {
        font-size: 14px;
    }
}



</style>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')

    {{-- User Info --}}
<div class="section bg-primary text-white py-3 shadow-sm" id="user-section">
    <div id="user-detail" class="d-flex align-items-center justify-content-between container">
        
        {{-- Kiri: Foto + Info --}}
        <div class="d-flex align-items-center">
            <div class="avatar">
                <img src="{{ asset('uploads/pegawai/'.$pegawai->foto) }}" 
                     alt="avatar" 
                     class="imaged rounded-circle border border-3 border-white" 
                     style="width:70px; height:70px; object-fit:cover;">
            </div>
            <div id="user-info" class="ml-3">
                <h4 id="user-name" class="mb-3 fw-bold text-white">
                    {{ Auth::guard('pegawai')->user()->nama_lengkap }}
                </h4>
                <small id="user-role" class="text-light">
                    {{ Auth::guard('pegawai')->user()->jabatan }}
                </small>
            </div>
        </div>

        {{-- Kanan: Tombol Pengaturan + Logout --}}
<div class="d-flex align-items-center gap-2">
      <a href="/pengaturanuser" class="btn btn-light btn-sm d-flex align-items-center justify-content-center rounded-circle shadow-sm" style="width:36px; height:36px;">
        <!-- Ikon Settings -->
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" 
             viewBox="0 0 24 24" fill="none" stroke="currentColor" 
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
             class="icon icon-tabler icon-tabler-settings">
          <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
          <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 
                   3.35 0a1.724 1.724 0 0 0 2.573 
                   1.066c1.543 -.94 3.31 .826 2.37 
                   2.37a1.724 1.724 0 0 0 1.065 
                   2.572c1.756 .426 1.756 2.924 0 
                   3.35a1.724 1.724 0 0 0 -1.066 
                   2.573c.94 1.543 -.826 3.31 -2.37 
                   2.37a1.724 1.724 0 0 0 -2.572 
                   1.065c-.426 1.756 -2.924 1.756 
                   -3.35 0a1.724 1.724 0 0 0 -2.573 
                   -1.066c-1.543 .94 -3.31 -.826 -2.37 
                   -2.37a1.724 1.724 0 0 0 -1.065 
                   -2.572c-1.756 -.426 -1.756 -2.924 
                   0 -3.35a1.724 1.724 0 0 0 1.066 
                   -2.573c-.94 -1.543 .826 -3.31 
                   2.37 -2.37c1 .608 2.296 .07 
                   2.572 -1.065z"/>
          <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/>
        </svg>
      </a>

    <!-- Tombol Logout -->
    <form id="logout-form" action="/proseslogout" method="POST" style="margin:0;">
        @csrf
        <button type="submit" class="btn btn-danger btn-sm px-3">
            Keluar
        </button>
    </form>
</div>

    </div>
</div>



    {{-- Menu Section --}}
    <div class="section" id="menu-section">
        <div class="card">
            <div class="card-body text-center">
                <div class="list-menu d-flex justify-content-around">
                    <div class="item-menu text-center">
                        <a href="/profil" class="green" style="font-size: 40px;">
                            <ion-icon name="person-sharp"></ion-icon>
                        </a>
                        <div class="menu-name">Profil</div>
                    </div>
                    <div class="item-menu text-center" >
                        <a href="{{ route('jadwal') }}" class="danger" style="font-size: 40px;">
                            <ion-icon name="calendar-number"></ion-icon>
                        </a>
                        <div class="menu-name">Jadwal</div>
                    </div>
                    <div class="item-menu text-center">
                        <a href="dashboard/histori" class="warning" style="font-size: 40px;">
                            <ion-icon name="document-text"></ion-icon>
                        </a>
                        <div class="menu-name">Histori</div>
                    </div>
                    <div class="item-menu text-center">
                        <a href="#map" class="orange" style="font-size: 40px;">
                            <ion-icon name="location"></ion-icon>
                        </a>
                        <div class="menu-name">Lokasi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Presence Today --}}
    
@php
use Carbon\Carbon;

$hariSekarang = Carbon::now('Asia/Jakarta')->locale('id')->dayName; // nama hari
$jam_sekarang = Carbon::now('Asia/Jakarta')->format('H:i:s');

// status presensi hari ini
$sudah_absen_masuk  = $presensihariini && $presensihariini->jam_in  ? true : false;
$sudah_absen_pulang = $presensihariini && $presensihariini->jam_out ? true : false;

// jadwal ideal (fallback 07:00 - 14:00)
$jam_masuk_ideal  = $jamMasuk  ?? (optional($jadwal)->jam_masuk  ?? '07:00:00');
$jam_pulang_ideal = $jamPulang ?? (optional($jadwal)->jam_pulang ?? '14:00:00');

// rentang valid absen masuk
$jam_masuk_awal  = '06:00:00';
$jam_masuk_akhir = '09:00:00';

// rentang valid absen pulang
$jam_pulang_awal  = '13:00:00';   // misalnya jam 12 sudah boleh pulang
$jam_pulang_akhir = '00:00:00';   // maksimal jam 21

// tombol aktif
$aktif_masuk = (!$sudah_absen_masuk)
                && ($jam_sekarang >= $jam_masuk_awal)
                && ($jam_sekarang <= $jam_masuk_akhir);

$aktif_pulang = (!$sudah_absen_pulang)
                && ($jam_sekarang >= $jam_pulang_awal)
                && ($jam_sekarang <= $jam_pulang_akhir);

@endphp

<div class="section"  id="presence-section" style="margin-top:100px;">

    {{-- Hari & Tanggal --}}
    <div class="text-center mb-3">
        <h5 style="font-weight:bold;">
            Hari/Tanggal : {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->translatedFormat('l, d F Y') }}
            — Waktu : <span id="clock"></span> WIB
        </h5>
    </div>

    {{-- Pesan Libur --}}
    @if($isLibur)
    <div class="alert alert-info text-center fs-5">
        @if($keteranganLibur)
            <strong>Hari ini libur: {{ $keteranganLibur }}</strong>
        @else
            <strong>Hari Minggu libur, tidak ada absen.</strong>
        @endif
    </div>
    @endif

    <div class="row">
        {{-- Tombol Absen Masuk --}}
        <div class="col-6">
            <div class="card gradasigreen">
                <div class="presencecontent text-center">
                    <button type="button" id="takeabsen_masuk"
                        class="btn btn-success btn-lg w-100 mb-2"
                        {{ ($aktif_masuk && !$isLibur) ? '' : 'disabled' }}>
                        <ion-icon name="log-in-outline"></ion-icon>
                        @if($isLibur)
                            LIBUR
                        @elseif($sudah_absen_masuk)
                            SUDAH ABSEN MASUK
                        @elseif(!$aktif_masuk)
                            ABSEN MASUK TUTUP
                        @else
                            ABSEN MASUK
                        @endif
                    </button>
                </div>
                <div class="text-center">
                    <span>{{ $sudah_absen_masuk ? $presensihariini->jam_in : 'Belum Absen' }}</span>
                </div>
            </div>
        </div>

        {{-- Tombol Absen Pulang --}}
        <div class="col-6">
            <div class="card gradasired">
                <div class="presencecontent text-center">
                    <button type="button" id="takeabsen_pulang"
                        class="btn btn-danger btn-lg w-100 mb-2"
                        {{ ($aktif_pulang && !$isLibur) ? '' : 'disabled' }}>
                        <ion-icon name="log-out-outline"></ion-icon>
                        @if($isLibur)
                            LIBUR
                        @elseif($sudah_absen_pulang)
                            SUDAH ABSEN PULANG
                        @elseif(!$aktif_pulang)
                            ABSEN PULANG TUTUP
                        @else
                            ABSEN PULANG
                        @endif
                    </button>
                </div>
                <div class="text-center">
                    <span>{{ $sudah_absen_pulang ? $presensihariini->jam_out : 'Belum Absen' }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- REKAP ABSEN --}}
<div class="section" style="margin-top:200px;">
    <h3 class="text-center">
        REKAP ABSENSI BULAN {{ $namabulan[$bulanini] }} TAHUN {{ $tahunini }}
    </h3>

    <div class="accordion" id="rekapAccordion">

        <!-- MASUK -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingMasuk">
                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseMasuk" aria-expanded="true" aria-controls="collapseMasuk">
                    Masuk
                </button>
            </h2>
            <div id="collapseMasuk" class="accordion-collapse collapse show" aria-labelledby="headingMasuk" data-bs-parent="#rekapAccordion">
                <div class="accordion-body d-flex justify-content-around">
                    <div class="text-center">
                        <small>Absen Hadir</small><br>
                        <span class="badge bg-success">{{ $rekap->jmlhadirmasuk ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <small>Terlambat</small><br>
                        <span class="badge bg-warning">{{ $rekap->jmltelat ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <small>Tidak Masuk</small><br>
                        <span class="badge bg-danger">{{ $rekap->tidakabsenmasuk ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PULANG -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingPulang">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePulang" aria-expanded="false" aria-controls="collapsePulang">
                    Pulang
                </button>
            </h2>
            <div id="collapsePulang" class="accordion-collapse collapse" aria-labelledby="headingPulang" data-bs-parent="#rekapAccordion">
                <div class="accordion-body d-flex justify-content-around">
                    <div class="text-center">
                        <small>Absen Pulang</small><br>
                        <span class="badge bg-success">{{ $rekap->jmlpulang ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <small>Pulang Cepat</small><br>
                        <span class="badge bg-warning">{{ $rekap->jmlcepat ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <small>Tidak Pulang</small><br>
                        <span class="badge bg-danger">{{ $rekap->tidakabsenpulang ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- IZIN / LAINNYA -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingIzin">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseIzin" aria-expanded="false" aria-controls="collapseIzin">
                    Izin / Lainnya
                </button>
            </h2>
            <div id="collapseIzin" class="accordion-collapse collapse" aria-labelledby="headingIzin" data-bs-parent="#rekapAccordion">
                <div class="accordion-body d-flex justify-content-around">
                    <div class="text-center">
                        <small>Dinas Luar</small><br>
                        <span class="badge bg-info">{{$rekapdinas->jml_dinas ?? 0}}</span>
                    </div>
                    <div class="text-center">
                        <small>izin</small><br>
                        <span class="badge bg-dark">{{ $rekapizin->jml_izin ?? 0 }}</span>
                    </div>
                    <div class="text-center">
                        <small>Sakit</small><br>
                        <span class="badge bg-primary">{{ $rekapizin->jml_sakit ?? 0 }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>





        {{-- Map --}}
        <div class="section mt-3 mb-3">
            <h5>Lokasi Anda</h5>
            <div id="map"></div>
        </div>
        <div id "rekapabsen" >
        <div class "row" >
            <div class "col-3">

            </div>
        </div>
    </div>
        {{-- Tabs --}}
        <div class="presencetab mt-2">
            <ul class="nav nav-tabs style1" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">Bulan Ini</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Leaderboard</a>
                </li>
            </ul>

            <div class="tab-content mt-2" style="margin-bottom:100px;">
                <div class="tab-pane fade show active" id="home" role="tabpanel">
                    <ul class="listview image-listview">
                        {{-- Contoh histori bulan ini, nanti bisa di-loop --}}
                        <li>
                            <div class="item">
                                <div class="icon-box bg-primary">
                                    <ion-icon name="log-in-outline"></ion-icon>
                                </div>
                                <div class="in">
                                    <div>01-08-2025</div>
                                    <span class="badge badge-success">Masuk 07:58</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

<div class="tab-pane fade" id="profile" role="tabpanel">
    <ul class="listview image-listview">
        @foreach ($leaderboard as $d)
        <li>
            <div class="item d-flex align-items-center">
                <!-- Avatar -->
                <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image me-3">

                <!-- Info dan Jam -->
                <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                    
                    <!-- Nama & Jabatan -->
                    <div>
                        <b>{{ $d->nama_lengkap }}</b><br>
                        <small>{{ $d->jabatan }}</small>
                    </div>

                    <!-- Jam Masuk & Pulang -->
                    <div class="d-flex" style="gap: 20px;"> <!-- <-- Tambahkan gap -->
                        <div class="text-center">
                            <small>Jam Masuk</small><br>
                            <span class="badge {{ ($d->jam_in > '07:00:00') ? 'bg-warning' : 'bg-success' }}">
                                {{ $d->jam_in }}
                            </span>
                        </div>
                        <div class="text-center">
                            <small>Jam Pulang</small><br>
                            <span class="badge {{ ($d->jam_out < '13:00:00') ? 'bg-warning' : 'bg-success' }}">
                                {{ $d->jam_out }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>




            </div>
        </div>
    </div>
@endsection

@push('myscript')
<script>
    // ambil lokasi user pakai geolocation
    let userLat = null;
    let userLng = null;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }

    function successCallback(position) {
        userLat = position.coords.latitude;
        userLng = position.coords.longitude;

        var map = L.map('map').setView([userLat, userLng], 15);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
        }).addTo(map);

        L.marker([userLat, userLng]).addTo(map)
            .bindPopup("Lokasi Anda")
            .openPopup();

        // Circle kantor
        var kantorLat = -6.1019821;
        var kantorLng = 106.1313513;
        L.circle([kantorLat, kantorLng], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.3,
            radius: 100
        }).addTo(map).bindPopup("Radius Kantor");
    }

    function errorCallback() {
        alert("Lokasi tidak bisa diakses");
    }

    // Tombol Absen
    // Tombol Absen Masuk
$(document).ready(function(){

    function absen(jenis){
        if(!userLat || !userLng){
            Swal.fire('Error', 'Lokasi tidak terdeteksi', 'error');
            return;
        }

        $.post('/dashboard/store', {
            _token: '{{ csrf_token() }}',
            lokasi: userLat+','+userLng,
            jenis: jenis
        }, function(res){
            let status = res.split("|");
            let type   = status[0].trim();   // success / error
            let msg    = status[1].trim();   // pesan
            // let aksi = status[2]?.trim(); // in/out (opsional kalau mau dipakai)

            Swal.fire(
                type === 'success' ? 'Berhasil' : 'Error',
                msg,
                type === 'success' ? 'success' : 'error'
            ).then(()=> location.reload());
        });
    }

    // Tombol Absen Masuk
    $('#takeabsen_masuk').click(function(e){
        e.preventDefault();
        absen('masuk');
    });

    // Tombol Absen Pulang
    $('#takeabsen_pulang').click(function(e){
        e.preventDefault();
        absen('pulang');
    });

});
// Jam berjalan
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
