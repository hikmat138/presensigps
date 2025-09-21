@extends('layouts.presensi')

@section('title', 'Edit Profil')
@section('header')
   <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/profil" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Edit Profil</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
<div class="section" style="margin-top:8rem">
    <div class="card shadow-lg border-0 rounded-4" style="max-width:420px;margin:0 auto;">
        <div class="card-body text-center">

            {{-- Foto Profil + Upload --}}



            {{-- Form --}}
            <form action="/updateprofil" method="POST" enctype="multipart/form-data" 
                  style="max-width:300px; margin:0 auto; text-align:left;">
                @csrf
                <div class="position-relative text-center mb-3">
    <img id="previewFoto"
         src="{{ !empty($pegawai->foto) 
                ? asset('uploads/pegawai/'.$pegawai->foto).'?v='.time() 
                : asset('assets/img/sample/avatar/avatar1.jpg') }}"
         class="rounded-circle border border-3 border-primary shadow-sm"
         width="110" height="110" style="object-fit:cover;">
    <label for="foto"
           class="btn btn-sm btn-light shadow position-absolute bottom-0 end-0 rounded-circle"
           title="Ganti Foto">
        <ion-icon name="camera-outline" class="text-primary"></ion-icon>
    </label>
    <input type="file" id="foto" name="foto" class="d-none" accept="image/*" onchange="previewImage(event)">
</div>
                {{-- Nama Lengkap --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control text-center"
                           value="{{ $pegawai->nama_lengkap ?? '' }}" required>
                </div>

                {{-- Jabatan --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control text-center"
                           value="{{ $pegawai->jabatan ?? '' }}">
                </div>

                {{-- No HP --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold">No HP</label>
                    <input type="text" name="no_hp" class="form-control text-center"
                           value="{{ $pegawai->no_hp ?? '' }}">
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
{{-- SweetAlert CDN --}}
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
        transform:translateY(-1px)
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
