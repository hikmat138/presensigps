@extends('layouts.admin.tabler')
@section('title','Konfigurasi Lokasi Kantor')

@section('content')
<style>
    html, body {
        height: 100%;   /* ✅ full tinggi layar */
        margin: 0;
    }
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    .page-wrapper {
        flex: 1;  /* biar isi dorong footer ke bawah */
        display: flex;
        flex-direction: column;
    }
    .main-content {
        flex: 1;  /* isi konten */
    }
</style>

<div class="page-wrapper">
    <div class="container mt-3 main-content">
        <div class="card">
            <div class="card-body">
                <h3>Konfigurasi Lokasi Kantor</h3>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ url('/updatelokasi') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama Lokasi</label>
                        <input type="text" name="lokasi_kantor" class="form-control" 
                            value="{{ old('lokasi_kantor', $lokasi->lokasi_kantor ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Latitude</label>
                        <input type="text" name="latitude" class="form-control" 
                            value="{{ old('latitude', $lokasi->latitude ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Longitude</label>
                        <input type="text" name="longitude" class="form-control" 
                            value="{{ old('longitude', $lokasi->longitude ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label>Radius (meter)</label>
                        <input type="number" name="radius" class="form-control" 
                            value="{{ old('radius', $lokasi->radius ?? 100) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
