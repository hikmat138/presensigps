
<form action="/karyawan/{{$karyawan->nik}}/update" method="POST" id="frmkaryawan">
@csrf
<div class="mb-3">
  <input type="text" class="form-control" name="nik" value="{{ $karyawan->nik }}" readonly>
</div>
<div class="mb-3">
  <input type="text" class="form-control" name="nama_lengkap" value="{{ $karyawan->nama_lengkap }}">
</div>
<div class="mb-3">
  <input type="text" class="form-control" name="jabatan" value="{{ $karyawan->jabatan }}">
</div>
<div class="mb-3">
  <input type="text" class="form-control" name="no_hp" value="{{ $karyawan->no_hp }}">
</div>
<div class="modal-footer">
    <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
</div>
</form>

@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
      icon: 'success',
      title: 'Berhasil!',
      text: 'Data karyawan berhasil diedit.',
    }).then(() => {
      $("#modal-editkarawan").modal("hide");
      // e.target.submit(); // kalau mau update ke server
    });
Swal.fire({
      icon: 'error',
      title: 'Gagal!',
      text: 'Data karyawan Gagal diedit.',
    }).then(() => {
      $("#modal-editkarawan").modal("hide");
      // e.target.submit(); // kalau mau update ke server
    });
</script>

@endpush