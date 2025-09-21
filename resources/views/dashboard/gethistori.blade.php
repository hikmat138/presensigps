@php
    // Mapping hari Indonesia
    $hariIndo = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => "Jum'at",
        'Saturday' => 'Sabtu'
    ];
@endphp

<div class="histori-container">
    <table class="table table-bordered text-center histori-table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Keterangan Masuk</th>
                <th>Jam Pulang</th>
                <th>Keterangan Pulang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($histori as $h)
            @php
                $hari = $hariIndo[date('l', strtotime($h->tgl_presensi))];

                if ($hari === 'Minggu') {
                    $jamIn = $jamOut = $ketMasuk = $ketPulang = 'Libur';
                } else {
                    // Ambil jadwal dari tabel jadwal sesuai hari
                    $jadwal = DB::table('jadwal')->where('hari', $hari)->first();
                    $jamMasuk = optional($jadwal)->jam_masuk ?? "07:00:00";
                    $jamPulang = optional($jadwal)->jam_pulang ?? "14:00:00";

                    // Jam & keterangan masuk
                    if ($h->jam_in) {
                        $jamIn = $h->jam_in;
                        $ketMasuk = ($h->jam_in > $jamMasuk) ? 'Telat' : 'Tepat Waktu';
                    } else {
                        $jamIn = '-';
                        $ketMasuk = '-';
                    }

                    // Jam & keterangan pulang
                    if ($h->jam_out) {
                        $jamOut = $h->jam_out;
                        $ketPulang = ($h->jam_out < $jamPulang) ? 'Pulang Cepat' : 'Tepat Waktu';
                    } else {
                        $jamOut = '-';
                        $ketPulang = '-';
                    }
                }
            @endphp
            <tr> 
                <td>{{ $hari }}, {{ date('d-M-Y', strtotime($h->tgl_presensi)) }}</td> 
                 <td>{{ $jamIn }}</td>
                <td> <span class="badge {{ $ketMasuk == 'Telat' ? 'bg-danger' : ($ketMasuk == 'Tepat Waktu' ? 'bg-success' : 'bg-secondary') }}"> {{ $ketMasuk }} </span> </td> 
                <td>{{ $jamOut }}</td>
                <td> <span class="badge {{ $ketPulang == 'Pulang Cepat' ? 'bg-danger' : ($ketPulang == 'Tepat Waktu' ? 'bg-success' : 'bg-secondary') }}"> {{ $ketPulang }} </span> </td> </tr> @endforeach
        </tbody>
    </table>
</div>

<style>
    .histori-container {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .histori-table {
        width: 90%;
        max-width: 1000px;
        font-size: 15px;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0,0,0,0.1);
        background: white;
    }

    .histori-table thead {
        background: linear-gradient(45deg, #007bff, #00c6ff);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        text-align: center;
    }

    .histori-table th, 
    .histori-table td {
        padding: 12px;
        vertical-align: middle;
        text-align: center; /* semua teks rata tengah */
    }

    .histori-table tbody tr:hover {
        background-color: #f1f7ff;
        transition: 0.3s;
    }

    @media (max-width: 768px) {
        .histori-table {
            font-size: 13px;
            width: 100%;
        }
        .histori-table th, .histori-table td {
            padding: 8px;
        }
    }
</style>
