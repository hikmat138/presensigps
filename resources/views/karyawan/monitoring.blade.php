@extends('layouts.admin.tabler')
@section('title','Monitoring Rekap Harian')
@section('content')


<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
      .navbar-brand, 
    .navbar-brand-text {
        font-size: 16px !important; /* kecilkan ukuran font */
        font-weight: 600 !important; /* tetap tegas */
    }
        .datepicker-modal {
    max-width: 550px !important;  /* batasi lebar */
    max-height: 350px !important; /* batasi tinggi */
    overflow: hidden;             /* sembunyikan scroll yang muncul */
    border-radius: 8px;
}

.datepicker-calendar {
    font-size: 14px;
    height: auto !important;      /* otomatis menyesuaikan */
}

.datepicker-table {
    max-height: 180px;            /* batasi tinggi tabel kalender */
    overflow-y: auto;             /* scroll jika terlalu banyak */
}


    </style>
</head>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">monitoring</div>
        <h2 class="page-title">Rekap Data Harian</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card-body">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" id="tgl_presensi" name="tgl_presensi" class="form-control" placeholder="tanggal presensi">
                        <label for="tgl_presensi"></label>
                    </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>nik</th>
                                <th>nama Pegawai</th>
                                <th>Jabatan</th>
                                <th>Jam Masuk</th>
                                <th>Keterangan Masuk</th>
                                <th>Jam Pulang</th>
                                <th>Keterangan Pulang</th>
                            </tr>
                        </thead>
                        <tbody id="loadpresensi">
                            
                        </tbody>
                    </table>
                </div>
            </div>
            </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('myscript')
<script>
$(document).ready(function() {
  $("#tgl_presensi").datepicker({
    format: "yyyy-mm-dd",
    autoClose: true,
    showClearBtn: true,
    i18n: {
      cancel: 'Batal',
      clear: 'Hapus',
      done: 'OK',
      months: ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],
      monthsShort: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sept','Okt','Nov','Des'],
      weekdays: ['Ahad','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'],
      weekdaysShort: ['Ahd','Sen','Sel','Rab','Kam','Jum','Sab'],
      weekdaysAbbrev: ['M','S','S','R','K','J','S']
    },
    onClose: function() {
      var date = this.date;
      if (date) {
        let d = new Date(date);
        let formatted = d.getFullYear() + "-" 
                      + ("0"+(d.getMonth()+1)).slice(-2) + "-" 
                      + ("0"+d.getDate()).slice(-2);
        $(this.el).val(formatted);

        // AJAX kirim tanggal ke server
        $.ajax({
          type: 'POST',
          url: '/getpresensi',
          data: {
            _token: "{{ csrf_token() }}",
            tanggal: formatted
          },
          cache: false,
          success: function(respond) {
            $("#loadpresensi").html(respond);
          },
          error: function(xhr, status, error) {
            console.error(error);
            alert("Gagal mengambil data presensi");
          }
        });
      }
    }
  });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
@endpush