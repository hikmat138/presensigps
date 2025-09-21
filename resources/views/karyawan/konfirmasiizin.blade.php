@extends('layouts.admin.tabler')
@section('title','Konfirmasi Izin / Sakit')
@section('content')
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">konfirmasi</div>
        <h2 class="page-title">Konfirmasi Izin</h2>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <form action="/konfirmasiizin" method="get">
                    <div class="row">
                        <div class="col-2">
                            <div class="row">
                                <span>
                                    <input type="text" value="{{Request('dari')}}"id="dari" class="form-control" placeholder="dari" name="dari">
                                </span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <span>
                                    <input type="text" value="{{Request('sampai')}}" id="sampai" class="form-control" placeholder="sampai" name="sampai">
                                </span>
                            </div>
                        </div>
                       <div class="col-2">
    <div class="row">
        <span>
            <select id="nama_pegawai"  name="nama_pegawai" class="form-select">
                <option value="">-- Pilih Pegawai --</option>
                @foreach($pegawai as $p)
                    <option value="{{ $p->nama_lengkap }}"
                        {{ request('nama_pegawai') == $p->nama_lengkap ? 'selected' : '' }}>
                        {{ $p->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </span>
    </div>
</div>
                        <div class="col-2">
                            <div class="row">
                                <span>
                                    <select name="status_filterizin" id="status_filterizin" class="form-select">
                                        <option value="{{Request('status_filterizin')}}">Pilih Status</option>
                                        <option value="s">Sakit</option>
                                        <option value="i">Izin</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="row">
                                <span>
                                    <select name="status_filter" id="status_filter" class="form-select">
                                        <option value="#">Pilih Status</option>
                                        <option value="0">Pending</option>
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </span>
                            </div>
                        </div>
                         <div class="col-2">
                            <div class="form-group">
                                <button class="btn btn-primary" type="submit">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                Cek
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <table class="table table-border">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>TANGGAL IZIN</th>
                            <th>NIK</th>
                            <th>NAMA PEGAWAI</th>
                            <th>STATUS</th>
                            <th>KETERANGAN</th>
                            <th>STATUS APPROVED</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($izinsakit as $s)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ date('d-M-Y', strtotime($s->tgl_izin)) }}</td>
                                <td>{{$s->nik}}</td>
                                <td>{{$s->nama_lengkap}}</td>
                                <td>{{ $s->status == 's' ? 'Sakit' : 'Izin' }}</td>
                                <td>{{$s->keterangan}}</td>
                                <td>
                            <span class="badge 
                                {{ ($s->status_aproved == '1') ? 'bg-success' : 
                                   (($s->status_aproved == '2') ? 'bg-danger' : 'bg-warning') }}">
                                {{ $s->status_aproved == '1' ? 'Disetujui' : ($s->status_aproved == '2' ? 'Ditolak' : 'Pending') }}
                            </span>
                        </td>
                        <td>
                            @if($s->status_aproved == '0')
                            <a href="#" class="btn btn-sm btn-primary aksi"  id_izinsakit="{{$s->id}}">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-external-link"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>
                                Konfirmasi                            
                            </a>
                            @else
                            <a href="/{{$s->id}}/batal" class="btn btn-sm btn-danger">
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
<div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">KONFIRMASI IZIN</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
     <form action="/aprovedizin" method="POST">
        @csrf
        <input type="hidden" id="idizin" name="idizin">
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    $(".aksi").click(function (e) {
    e.preventDefault();
    var id_izinsakit = $(this).attr("id_izinsakit");
    $("#idizin").val(id_izinsakit);
        $("#modal-izinsakit").modal("show");
  });
flatpickr("#dari", {
  dateFormat: "Y-m-d",
  altInput: true,
  altFormat: "d-m-Y",
  locale: "id"  // sudah ada bawaan bahasa Indonesia
});
flatpickr("#sampai", {
  dateFormat: "Y-m-d",
  altInput: true,
  altFormat: "d-m-Y",
  locale: "id"  // sudah ada bawaan bahasa Indonesia
});
</script>
@endpush
@endsection