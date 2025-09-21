@extends('layouts.presensi')
@section('title', 'Jadwal Kerja')

@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/dashboard" class="headerButton">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Jadwal Kerja</div>
</div>
@endsection

@section('content')
<div class="jadwal-container" style="margin-top:100px">
    <div class="card shadow-sm w-100" style="max-width: 800px; margin-left:430px;">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover text-center align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th style="width: 20%">Hari</th>
                            <th style="width: 20%">Tanggal</th>
                            <th style="width: 20%">Jam Masuk</th>
                            <th style="width: 20%">Jam Pulang</th>
                            <th style="width: 20%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            use Carbon\Carbon;
                            $hariMap = [
                                'Minggu' => 0,
                                'Senin' => 1,
                                'Selasa' => 2,
                                'Rabu' => 3,
                                'Kamis' => 4,
                                "Jum'at" => 5,
                                'Sabtu' => 6,
                            ];
                        @endphp
                        @foreach ($jadwal as $j)
                            @php
                                $tanggalHariIni = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays($hariMap[$j->hari]);
                                $cekLibur = \App\Models\LiburNasional::whereDate('tanggal', $tanggalHariIni)->first();

                                if ($j->hari == 'Minggu') {
                                    $status = 'Minggu (Libur)';
                                } elseif ($cekLibur) {
                                    $status = 'Libur Nasional: ' . $cekLibur->keterangan;
                                } else {
                                    $status = 'Masuk';
                                }
                            @endphp
                            <tr>
                                <td class="fw-semibold">{{ $j->hari }}</td>
                                <td>{{ $tanggalHariIni->format('d-m-Y') }}</td>
                                <td><span class="tanggal">{{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }} WIB</span></td>
                                <td><span class="tanggal">{{ \Carbon\Carbon::parse($j->jam_pulang)->format('H:i') }} WIB</span></td>
                                <td>
                                    @if(Str::contains($status, 'Libur'))
                                        <span class="badge bg-danger p-2 fs-6">{{ $status }}</span>
                                    @else
                                        <span class="badge bg-primary p-2 fs-6">{{ $status }}</span>
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

<p class="text-center" style="margin-left:500px">Jadwal ini tidak bisa di rubah</p>
@endsection

@push('styles')
<style>
/* bikin container penuh layar dan center */
.jadwal-container { /* sisakan tinggi header + footer */
    margin-top: 80px; /* biar gak ketimpa header */
    display: flex;
    justify-content: center;
}

.card {
   width: 380px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    background: #fff;
    text-align: center;
    padding: 20px;
}
</style>
@endpush
