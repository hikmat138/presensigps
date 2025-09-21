@extends('layouts.admin.tabler')
@section('title','Monitoring Rekap Bulanan')
@section('content')

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Monitoring</div>
        <h2 class="page-title">Rekap Data Bulanan</h2>
      </div>
    </div>
  </div>
</div>

<div class="row mb-1">
  <div class="col-md-3">
    <select id="bulan" class="form-control">
      <option value="">-- Pilih Bulan --</option>
      <option value="1">Januari</option>
      <option value="2">Februari</option>
      <option value="3">Maret</option>
      <option value="4">April</option>
      <option value="5">Mei</option>
      <option value="6">Juni</option>
      <option value="7">Juli</option>
      <option value="8">Agustus</option>
      <option value="9">September</option>
      <option value="10">Oktober</option>
      <option value="11">November</option>
      <option value="12">Desember</option>
    </select>
  </div>
  <div class="col-md-2">
    <input type="number" id="tahun" class="form-control" placeholder="Tahun" value="{{ date('Y') }}">
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary" id="btnTampil">Tampilkan</button>
  </div>
</div>

<h4 id="judulBulanan"></h4>

<div class="table-responsive">
  <table class="table table-bordered">
    <thead id="theadbulanan"></thead>
    <tbody id="loadbulanan"></tbody>
  </table>
</div>

@endsection

@push('myscript')
<script>
$(document).ready(function(){
  $("#btnTampil").click(function(){
    var bulan = $("#bulan").val();
    var tahun = $("#tahun").val();

    if(bulan === "" || tahun === ""){
      alert("Pilih bulan dan tahun terlebih dahulu!");
      return;
    }

    $.ajax({
      type: "POST",
      url: "/getbulanan",
      data: {
        _token: "{{ csrf_token() }}",
        bulan: bulan,
        tahun: tahun
      },
      cache: false,
      success: function(respond){
        // isi tabel
        $("#theadbulanan").html(respond.thead);
        $("#loadbulanan").html(respond.tbody);

        // judul dinamis
        var namaBulan = $("#bulan option:selected").text();
        $("#judulBulanan").text("Rekap Presensi Bulan " + namaBulan + " " + tahun);

        // update link export
        $("#btnExcel").attr("href", "/exportbulanan/excel/"+bulan+"/"+tahun);
        $("#btnPdf").attr("href", "/exportbulanan/pdf/"+bulan+"/"+tahun);
      }
    });
  });
});
</script>
@endpush
