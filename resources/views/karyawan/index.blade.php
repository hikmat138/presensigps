@extends('layouts.admin.tabler')
@section('title', 'Data Karyawan')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Data Master</div>
        <h2 class="page-title">Data Karyawan</h2>
      </div>
    </div>
  </div>
</div>

<div class="page-body">
  <div class="container-xl">
    <div class="row mt-2">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="row mt-2">
              <div class="col-12">
                <a href="#" class="btn btn-primary" id="btntambahkaryawan">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                       viewBox="0 0 24 24" fill="none" stroke="currentColor"
                       stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                       class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                       <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                       <path d="M12 5l0 14" />
                       <path d="M5 12l14 0" />
                  </svg>
                  Tambah Data
                </a>
              </div>
            </div>

            <table class="table table-border mt-2">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIK</th>
                  <th>Nama Lengkap</th>
                  <th>Jabatan</th>
                  <th>No HP</th>
                  <th>Foto</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($karyawan as $d)
                <tr>
                  <td>{{ $loop->iteration + $karyawan->firstItem() - 1 }}</td>
                  <td>{{ $d->nik }}</td>
                  <td>{{ $d->nama_lengkap }}</td>
                  <td>{{ $d->jabatan }}</td>
                  <td>{{ $d->no_hp }}</td>
                  <td>
                    @if(empty($d->foto))
                      <img src="{{ asset('assets/img/download.jpg')}}" class="avatar">
                    @else
                      <img src="{{ asset('uploads/pegawai/'.$d->foto) }}"
                           alt="avatar"
                           style="width:40px; height:40px; object-fit:cover; border-radius:50%;">
                    @endif
                  </td>
                  <td>
                    <a href="#" class="edit btn btn-info btn-sm"
                       nik="{{ $d->nik }}"
                       nama="{{ $d->nama_lengkap }}"
                       jabatan="{{ $d->jabatan }}"
                       nohp="{{ $d->no_hp }}">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                           viewBox="0 0 24 24" fill="none" stroke="currentColor"
                           stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                           class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                           <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                           <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                           <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                           <path d="M16 5l3 3" />
                      </svg>
                    </a>
                    <form action="/karyawan/{{$d->nik}}/delete" method="POST">
                      @csrf
                      <a class="btn btn-danger btn-sm delete-confirm">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                      </a>
                    </form>
                    </a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
            {{ $karyawan->links('vendor.pagination.bootstrap-5') }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal modal-blur fade" id="modal-karyawan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">TAMBAH DATA PEGAWAI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/karyawan/store" method="POST" id="frmtambahkaryawan">
        <div class="modal-body">
          @csrf
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="NIK" name="nik">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Nama Lengkap" name="nama_lengkap">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="Jabatan" name="jabatan">
          </div>
          <div class="mb-3">
            <input type="text" class="form-control" placeholder="No HP" name="no_hp">
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary w-100">Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Edit -->
<div class="modal modal-blur fade" id="modal-editkaryawan" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">EDIT DATA PEGAWAI</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <div class="modal-body" id="loadeditform">
        
      
    </div>
  </div>
</div>
@endsection

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
  
  // Tombol tambah karyawan
  $("#btntambahkaryawan").click(function (e) {
    e.preventDefault();
    $("#modal-karyawan").modal("show");
  });

  // Submit Tambah
  $("#frmtambahkaryawan").on("submit", function (e) {
    e.preventDefault();
    var nik = $(this).find("input[name=nik]").val().trim();
    var nama_lengkap = $(this).find("input[name=nama_lengkap]").val().trim();
    var jabatan = $(this).find("input[name=jabatan]").val().trim();
    var no_hp = $(this).find("input[name=no_hp]").val().trim();

    if (!nik || !nama_lengkap || !jabatan || !no_hp) {
      Swal.fire("Oops...", "Semua field harus diisi!", "warning");
      return;
    }

    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Data karyawan baru tervalidasi.',
      showConfirmButton: false,
      timer: 1500
    }).then(() => {
      e.target.submit(); // kirim ke server
    });
  });

  // Tombol edit karyawan
  $(".edit").click(function (e) {
    e.preventDefault();
    var nik = $(this).attr('nik');

    $.ajax({
      type: 'POST',
      url: '/karyawan/edit',
      data: {
        _token: "{{ csrf_token() }}",
        nik: nik
      },
      success: function (respond) {
        $("#loadeditform").html(respond);
        $("#modal-editkaryawan").modal("show");
      }
    });
  });

  // Tombol delete
  $(".delete-confirm").click(function (e) {
    var form = $(this).closest('form');
    e.preventDefault();
    Swal.fire({
      title: "Apakah Anda Yakin Datanya Mau di Hapus?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Ya, hapus!",
      cancelButtonText: "Batal"
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
        Swal.fire("Deleted!", "Data berhasil dihapus.", "success");
      }
    });
  });

  // Submit Edit
  $(document).on("submit", "#frmeditkaryawan", function (e) {
    e.preventDefault();
    var nama = $(this).find("input[name=nama_lengkap]").val().trim();
    var jabatan = $(this).find("input[name=jabatan]").val().trim();
    var no_hp = $(this).find("input[name=no_hp]").val().trim();

    if (!nama || !jabatan || !no_hp) {
      Swal.fire("Oops...", "Semua field harus diisi!", "warning");
      return;
    }

    Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Data karyawan berhasil diedit.',
      showConfirmButton: false,
      timer: 1500
    }).then(() => {
      e.target.submit(); // kirim ke server
    });
  });

});
</script>
@endpush


