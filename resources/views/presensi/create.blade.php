@extends('layouts.presensi')
@section('header')
   <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">E-Presensi</div>
        <div class="right"></div>
    </div>

<style>

.webcam-wrapper {
    display: flex;
    justify-content: center;
    width: 100%;
}

.webcam-capture video {
    width: 100%;        /* full di HP */
    max-width: 600px;   /* biar di laptop gak terlalu besar */
    height: auto;
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
#map {
     height: 400px; 
    }

</style>
 <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
 <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection
@section('content')
<div class="container-fluid d-flex flex-column" style="min-height: 100vh; padding-top: 10px; padding-bottom: 70px;">
    <!-- Input lokasi -->
    <div>
        <input type="hidden" id="lokasi">
    </div>

    <!-- Kamera (expand di tengah) -->
    <div class="flex-grow-1 d-flex justify-content-center align-items-start">
        <div class="webcam-wrapper w-100">
            <div class="webcam-capture"></div>
        </div>
    </div>

    <!-- Tombol absen -->
    <div class="mt-3">
    @if($cek > 0)
    <button type="button" id="takeabsen" class="btn btn-danger btn-lg w-100">
        <ion-icon name="camera-outline"></ion-icon> ABSEN PULANG
    </button>
    @else
    <button type="button" id="takeabsen" class="btn btn-primary btn-lg w-100">
        <ion-icon name="camera-outline"></ion-icon> ABSEN MASUK
    </button>
    @endif
    
</div>
</div>

<div class="section mt-3 mb-3">
     <div id="map"></div>
</div>




@endsection

@push('myscript')
<script>
    Webcam.set({
        width: 640,
        height: 480,
        image_format: 'jpeg',
        jpeg_quality: 80
    });

    Webcam.attach('.webcam-capture');

    var lokasi = document.getElementById('lokasi');
    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
    }
        function successCallback(position) {
            lokasi.value = position.coords.latitude + ',' + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([position.coords.latitude,position.coords.longitude]).addTo(map);
var circle = L.circle([-6.1019821,106.1313513], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 100
}).addTo(map);
        }

        function errorCallback() {

        }
$('#takeabsen').click(function(e) {

    Webcam.snap(function(url) {
        var image  = url;  
        var lokasi = $('#lokasi').val(); 

        $.ajax({   
            type: 'POST',
            url: '/presensi/store',
            data: {
                _token: '{{ csrf_token() }}',
                image: image,
                lokasi: lokasi
            },
            cache: false,
            success: function(respond) {
            var status = respond.split("|");
                if(status [0] == "success") {
                    Swal.fire({
                        title: 'Berhasil',
                        text: status[1],
                        icon: 'success', 
                    });
                    setTimeout ('location.href = "/dashboard";', 3000);
                } else  {
                    Swal.fire({
                        title: 'Error',
                        text: status[1],
                        icon: 'error',
                    
                    });
                    setTimeout ('location.href = "/dashboard";', 3000);
                }
            },
        });
    });
});


</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush