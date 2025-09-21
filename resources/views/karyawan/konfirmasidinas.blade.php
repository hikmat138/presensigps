@extends('layouts.admin.tabler')
@section('title','Konfirmasi Dinas Luar')
@section('content')
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">konfirmasi</div>
        <h2 class="page-title">Konfirmasi Dinas</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL Dinas</th>
                            <th>NAMA PEGAWAI</th>
                            <th>KETERANGAN</th>
                            <th>SURAT</th>
                            <th>STATUS APPROVED</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($dinasluar as $h)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($h->tgl_awaldinas)->translatedFormat('d M Y') }} 
                                - 
                            {{ \Carbon\Carbon::parse($h->tgl_akhirdinas)->translatedFormat('d M Y') }}
                        </td>
                        <td>{{$h->nama_lengkap}}</td>
                        <td class="text-start" style="white-space: normal; word-wrap: break-word;">
                            {{ $h->keterangan ?? '-' }}
                        </td>
                        <td>
                            @if($h->file_surat)
                                <a href="{{ asset('uploads/surat_dinas/'.$h->file_surat) }}" target="_blank" class="btn btn-danger btn-sm">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-pdf"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M5 18h1.5a1.5 1.5 0 0 0 0 -3h-1.5v6" /><path d="M17 18h2" /><path d="M20 15h-3v6" /><path d="M11 15v6h1a2 2 0 0 0 2 -2v-2a2 2 0 0 0 -2 -2h-1z" /></svg>    
                                Lihat Surat</a>
                            @else
                                Tidak ada file
                            @endif
                        </td>
                        <td>
                            <span class="badge 
                                {{ ($h->status_aproved == '1') ? 'bg-success' : 
                                   (($h->status_aproved == '2') ? 'bg-danger' : 'bg-warning') }}">
                                {{ $h->status_aproved == '1' ? 'Disetujui' : ($h->status_aproved == '2' ? 'Ditolak' : 'Pending') }}
                            </span>
                        </td>
                        <td>
                            @if($h->status_aproved == '0')
                            <a href="#" class="btn btn-sm btn-primary aksidinas"  id_dinas="{{$h->id}}">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                Konfirmasi                            
                            </a>
                            @else
                            <a href="/{{$h->id}}/bataldinas" class="btn btn-sm btn-danger">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circle-letter-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" /><path d="M10 8l4 8" /><path d="M10 16l4 -8" /></svg>
                                Batalkan
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal modal-blur fade" id="modal-dinas" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">KONFIRMASI DINAS</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <form action="/aproveddinas" method="POST">
        @csrf
        <input type="hidden" id="iddinas" name="iddinas">
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <select name="status_aproved" id="status_aproved" class="form-select">
                        <option value="1">Disetujui</option>
                        <option value="2">Ditolak</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="form-gorup">
                    <button class="btn btn-primary w-100" type="submit">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 14l11 -11" /><path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                Konfirmasi
                </button>
                </div>
            </div>
        </div>
     </form>
    </div>
  </div>
</div>

@push('myscript')
<script>
    $(".aksidinas").click(function (e) {
    e.preventDefault();
    var id_dinas = $(this).attr("id_dinas");
    $("#iddinas").val(id_dinas);
        $("#modal-dinas").modal("show");
  });
</script>
@endpush
@endsection