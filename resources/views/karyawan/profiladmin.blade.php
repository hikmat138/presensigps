@extends('layouts.admin.tabler')
@section('title','PROFIL ADMIN')
@section('content')

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Profil</div>
        <h2 class="page-title">PROFIL ADMIN</h2>
      </div>
    </div>
  </div>
</div>


<style>
    .profile-container {
        margin-top: 80px; /* biar gak ketimpa header */
        display: flex;
        justify-content: center;
    }

    .profile-card {
        width: 380px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background: #fff;
        text-align: center;
        padding: 20px;
    }

    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
        border: 4px solid #007bff;
    }

    .profile-card h3 {
        margin: 10px 0 5px 0;
        font-size: 20px;
        font-weight: bold;
    }

    .profile-card p {
        margin: 3px 0;
        color: #666;
        font-size: 14px;
    }

    .profile-card .instansi {
        font-weight: bold;
        color: #007bff;
        margin-top: 10px;
    }

    .btn-edit {
        margin-top: 15px;
        padding: 8px 18px;
        font-size: 14px;
        border-radius: 8px;
    }
</style>
<div class="profile-container">
    <div class="profile-card">
        {{-- Foto --}}
        <img src="{{ !empty($admin->foto) 
            ? asset('uploads/pegawai/'.$admin->foto).'?v='.time() 
            : asset('assets/img/sample/avatar/avatar1.jpg') }}"
     alt="Foto Profil"
     class="profile-img">

        {{-- Nama Lengkap --}}
        <h3>{{ $admin->name }}</h3>

        {{-- Email --}}
        <p>{{ $admin->email }}</p>


        {{-- Instansi (hardcode / default semua) --}}
        <p class="instansi">SDN Ranca Tales</p>

        {{-- Tombol Edit Profil --}}
        <a href="{{ url('/editprofiladmin') }}" class="btn btn-warning btn-edit">
            <ion-icon name="create-outline"></ion-icon> Edit Profil
        </a>
    </div>
</div>
@endsection