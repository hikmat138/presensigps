@extends('layouts.presensi')
@section('title', 'Izin')

@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">DATA IZIN / SAKIT</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')

@php
    use Carbon\Carbon;
    if(session('success')){
        echo '<div class="alert alert-success text-center" style="margin:80px 10px 10px 10px;">' . session('success') . '</div>';
    }
@endphp

<!-- Floating Action Button -->
<a href="/buatizin" class="fab">
    <ion-icon name="add-outline"></ion-icon>
</a>

<div class="row justify-content-center" style="margin:80px 10px 10px 10px;">   
    <div class="col-md-10">
        <div class="table-responsive">
            <table class="table table-bordered text-center izin-table">
                <thead>
                    <tr>
                        <th style="width: 20%">Tanggal</th>
                        <th style="width: 15%">Status</th>
                        <th style="width: 40%">Keterangan</th>
                        <th style="width: 25%">Status Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataizin as $h)
                    <tr>
                        <td>
                            {{ \Carbon\Carbon::parse($h->tgl_izin)->translatedFormat('l, d F Y') }}
                        </td>
                        <td>{{ $h->status == 's' ? 'Sakit' : 'Izin' }}</td>
                        <td class="text-start" style="white-space: normal; word-wrap: break-word;">
                            {{ $h->keterangan ?? '-' }}
                        </td>
                        <td>
                            <span class="badge 
                                {{ ($h->status_aproved == '1') ? 'bg-success' : 
                                   (($h->status_aproved == '2') ? 'bg-danger' : 'bg-warning') }}">
                                {{ $h->status_aproved == '1' ? 'Disetujui Admin' : ($h->status_aproved == '2' ? 'Ditolak Admin' : 'Menunggu Persetujuan Admin') }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .izin-table {
        font-size: 16px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        margin: auto;
        text-align: center;
    }

    .izin-table thead {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    .izin-table th, 
    .izin-table td {
        padding: 14px;
        vertical-align: middle;
    }

    .izin-table tbody tr:hover {
        background-color: #f1f7ff;
        transition: 0.3s;
    }

    .izin-table .badge {
        font-size: 14px;
        padding: 6px 12px;
        border-radius: 12px;
    }

    /* Supaya keterangan wrap */
    .izin-table td {
        white-space: normal !important;
        word-wrap: break-word;
    }
.fab {
        position: fixed;
        bottom: 80px; /* supaya nggak ketutup bottom menu */
        right: 20px;
        background: #007bff;
        color: white;
        font-size: 28px;
        width: 55px;
        height: 55px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        text-decoration: none;
        z-index: 1100;
        transition: 0.3s;
    }
    .fab:hover {
        background: #0056b3;
        transform: scale(1.05);
    }
    /* Responsive untuk HP */
    @media (max-width: 768px) {
        .izin-table {
            font-size: 14px;
        }
        .izin-table th, .izin-table td {
            padding: 10px;
        }
        .izin-table thead {
            font-size: 13px;
        }
    }
</style>
@endsection
