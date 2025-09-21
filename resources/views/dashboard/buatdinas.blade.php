@extends('layouts.presensi')

@section('title', 'Form Dinas Luar')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/dinas" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">FORM DINAS LUAR</div>
    <div class="right"></div>
</div>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
</head>
@endsection

@section('content')
<div class="row" style="margin-top:70px">
    <div class="col s12">
        <form method="POST" action="/storedinas" id="formDinas" enctype="multipart/form-data">
    @csrf
    <div class="row">
    <div class="input-field col s12">
        <input type="date" id="tgl_awaldinas" name="tgl_awaldinas" class="datepicker" required>
        <label for="tgl_awaldinas">Tanggal Awal</label>
    </div>
    <div class="input-field col s12">
        <input type="date" id="tgl_akhirdinas" name="tgl_akhirdinas" class="datepicker" required>
        <label for="tgl_akhirdinas">Tanggal Akhir</label>
    </div>
</div>

    <div class="row">
        <div class="input-field col s12">
            <textarea id="keterangan" name="keterangan" class="materialize-textarea" required></textarea>
            <label for="keterangan">Keterangan (nama kegiatan)</label>
        </div>
    </div>

    <div class="row">
                <div class="file-field input-field col s12">
                    <div class="btn green">
                        <span>Upload Surat (PDF)</span>
                        <input type="file" name="file_surat" accept="application/pdf">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" placeholder="Unggah file PDF surat perjalanan dinas">
                    </div>
                </div>
    </div>

    <div class="form-group">
        <button type="submit" class="btn btn-green w-100">Simpan</button>
    </div>
</form>

    </div>
</div>
@endsection

@push('myscript')
<script>
$(document).ready(function() {
  // Inisialisasi Materialize Datepicker
  $('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoClose: true
  });

  // Inisialisasi select Materialize
  $('select').formSelect();

  // Validasi sebelum submit
  $('#formDinas').submit(function(){
    var tgl_awaldinas = $('#tgl_awaldinas').val();
    var tgl_akhirdinas = $('#tgl_akhirdinas').val();
    var keterangan = $('#keterangan').val();
    var file = $('input[name="file_surat"]').val();

    if(tgl_awaldinas == ''){
        Swal.fire({ icon:'warning', text:'Tanggal awal dinas wajib diisi!' });
        return false;
    } else if(tgl_akhirdinas == ''){
        Swal.fire({ icon:'warning', text:'Tanggal akhir dinas wajib diisi!' });
        return false;
    } else if(keterangan == ''){
        Swal.fire({ icon:'warning', text:'Keterangan wajib diisi!' });
        return false;
    } else if(file == ''){
        Swal.fire({ icon:'warning', text:'File surat wajib diupload!' });
        return false;
    } else {
        return true;
    }
  });
});


</script>
@endpush
