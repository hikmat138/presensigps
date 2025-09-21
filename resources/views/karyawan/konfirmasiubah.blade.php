@extends('layouts.admin.tabler')
@section('title','Konfirmasi Ubah Password')
@section('content')
<div class="container-xl mt-5">
    <h2 class="mb-4 fw-bold">Reset Password Pegawai</h2>

    @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}'
                });
            });
        </script>
    @endif

    <div class="card shadow-lg rounded-3 border-0">
        <div class="card-header bg-primary-lt">
            <h3 class="card-title">Daftar Permintaan Reset</h3>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-vcenter table-striped table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Jabatan</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $key => $pegawai)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td class="fw-semibold">{{ $pegawai->nama_lengkap }}</td>
                                <td>{{ $pegawai->jabatan }}</td>
                                <td>
                                    <form id="resetForm{{ $pegawai->nik }}" 
                                          action="/resetpassword{{$pegawai->nik}}" 
                                          method="POST">
                                        @csrf
                                        <button type="button" 
                                                class="btn btn-sm btn-danger btn-reset" 
                                                data-id="{{ $pegawai->nik }}" 
                                                data-nama="{{ $pegawai->nama_lengkap }}">
                                            <i class="ti ti-key me-1"></i> Reset
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">Tidak ada permintaan reset</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.btn-reset').forEach(button => {
    button.addEventListener('click', function() {
        let pegawaiNik = this.dataset.id;
        let pegawaiNama = this.dataset.nama;

        Swal.fire({
            title: 'Yakin?',
            text: "Reset password untuk " + pegawaiNama + "?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, reset!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('resetForm' + pegawaiNik).submit();
            }
        });
    });
});
</script>
@endsection
