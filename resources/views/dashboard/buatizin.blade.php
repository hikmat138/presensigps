@extends('layouts.presensi')

@section('title', 'Form Izin')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/izin" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">FORM IZIN</div>
    <div class="right"></div>
</div>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
<!-- Materialize CSS (versi stable, bukan beta) -->

@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col s12">
        <form method="POST" action="/storeizin" id="formIzin">
            @csrf
            <div class="row">
                <div class="input-field col s12">
                    <input type="date" id="tgl_izin" name="tgl_izin" class="form-control" >
                    <label for="tgl_izin">Tanggal Izin</label>
                </div>
            </div>
            <div class="input-field col s12">
            <select name="status" id="status" required>
                <option value="" disabled selected>Pilih Status</option>
                <option value="i">Izin</option>
                <option value="s">Sakit</option>
            </select>
            <label for="status">Status</label>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <textarea id="keterangan" name="keterangan" class="materialize-textarea"></textarea>
                    <label for="keterangan">Keterangan</label>
                </div>
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-green w-100" style="width:100%" >Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
<script>
$(document).ready(function() {
  $(".form-control").datepicker({
    format: "yyyy-mm-dd",   // biar sesuai dengan MySQL DATE
    autoClose: true,
    onSelect: function(date) {
        // pastikan input terisi value string
        let d = new Date(date);
        let formatted = d.getFullYear() + "-" 
                      + ("0"+(d.getMonth()+1)).slice(-2) + "-" 
                      + ("0"+d.getDate()).slice(-2);
        $("#tgl_izin").val(formatted);
    }
  });

  // Inisialisasi select
  var elems = document.querySelectorAll('select');
  M.FormSelect.init(elems);
});
$('#formIzin').submit(function(){
    var tgl_izin = $('#tgl_izin').val();
    var status = $('#status').val();
    var keterangan = $('#keterangan').val();

    if(tgl_izin == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Tanggal Izin wajib diisi!',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#43a047', // hijau Materialize
            backdrop: `rgba(0,123,0,0.2)`
        });
        return false;
    } else if(status == null || status == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Status wajib diisi!',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#43a047',
            backdrop: `rgba(0,123,0,0.2)`
        });
        return false;
    } else if(keterangan == ''){
        Swal.fire({
            icon: 'warning',
            title: 'Oops...',
            text: 'Keterangan wajib diisi!',
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#43a047',
            backdrop: `rgba(0,123,0,0.2)`
        });
        return false;
    } else {
        return true;
    }
});

</script>
@endpush

