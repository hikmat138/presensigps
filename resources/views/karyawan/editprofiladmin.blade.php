@extends('layouts.admin.tabler')
@section('title', 'EDIT PROFIL ADMIN')
@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Profil</div>
        <h2 class="page-title">EDIT PROFIL ADMIN</h2>
      </div>
    </div>
  </div>
</div>

<div class="section" style="margin-top:2rem">
    <div class="card shadow-lg border-0 rounded-4" style="max-width:420px;margin:0 auto;">
        <div class="card-body text-center">

            {{-- Form --}}
            <form action="{{ route('updateprofil') }}" method="POST" enctype="multipart/form-data" 
                  style="max-width:300px; margin:0 auto; text-align:left;">
                @csrf

                {{-- Foto Profil --}}
                <div class="position-relative text-center mb-3">
    <img id="previewFoto"
         src="{{ !empty($admin->foto) 
                ? asset('uploads/pegawai/'.$admin->foto).'?v='.time() 
                : asset('assets/img/sample/avatar/avatar1.jpg') }}"
         class="rounded-circle border border-3 border-primary shadow-sm"
         width="110" height="110" style="object-fit:cover;">

    <<div class="mb-3">
    <label class="form-label fw-semibold">Foto</label>
    <input type="file" name="foto" id="foto" class="form-control" accept="image/*" onchange="previewImage(event)">
</div>


                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control text-center"
                           value="{{ $admin->name ?? '' }}" required>
                </div>

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control text-center"
                           value="{{ $admin->email ?? '' }}">
                </div>

                {{-- Password --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control text-center"
                           placeholder="Kosongkan jika tidak ingin mengganti password">
                </div>

                {{-- Tombol Simpan --}}
                <div class="d-grid">
                    <button type="submit" class="btn btn-gradient-primary btn-lg rounded-pill shadow-sm">
                        <ion-icon name="save-outline"></ion-icon> Simpan Perubahan
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

{{-- SweetAlert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session("success") }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: '{{ session("error") }}',
        timer: 2000,
        showConfirmButton: false
    });
</script>
@endif

{{-- CSS tambahan --}}
<style>
    .btn-gradient-primary{
        background: linear-gradient(45deg,#4facfe,#00f2fe);
        border:none;color:#fff;transition:.25s;
    }
    .btn-gradient-primary:hover{
        filter:brightness(1.05);
        transform:translateY(-1px);
    }
    .form-control { 
        width: 100% !important; 
    }
</style>

{{-- Preview foto saat pilih file --}}
<script>
    function previewImage(e){
    const file = e.target.files?.[0];
    if(!file) return;
    const reader = new FileReader();
    reader.onload = () => document.getElementById('previewFoto').src = reader.result;
    reader.readAsDataURL(file);
}

</script>
@endsection
