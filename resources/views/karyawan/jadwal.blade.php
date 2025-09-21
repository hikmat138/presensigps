@extends('layouts.admin.tabler')
@section('title', 'Jadwal Karyawan')
@section('content')
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Jadwal</div>
        <h2 class="page-title">JADWAL KERJA</h2>
      </div>
    </div>
  </div>
</div>

<div class="section mt-2">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <table class="table table-hover align-middle text-center">
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
                        <td>
                            <span class="tanggal">
                                {{ \Carbon\Carbon::parse($j->jam_masuk)->format('H:i') }} WIB
                            </span>
                            <a href="#" class="badge bg-info p-2 fs-6 edit-jam" 
                               data-id="{{ $j->id }}" 
                               data-tipe="masuk">
                                <i class="bi bi-pencil-square"></i>&nbsp;Edit
                            </a>
                        </td>
                        <td>
                            <span class="tanggal">
                                {{ \Carbon\Carbon::parse($j->jam_pulang)->format('H:i') }} WIB
                            </span>
                            <a href="#" class="badge bg-info p-2 fs-6 edit-jam" 
                               data-id="{{ $j->id }}" 
                               data-tipe="pulang">
                                <i class="bi bi-pencil-square"></i>&nbsp;Edit
                            </a>
                        </td>
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

{{-- Tambahan: Form Input Libur Nasional --}}
<div class="section mt-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header">
            <h3 class="card-title">Daftar Libur Nasional</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('libur.store') }}" method="POST" class="row g-3 mb-3">
                @csrf
                <div class="col-md-4">
                    <input type="text" id="tanggal_libur" name="tanggal" class="form-control datepicker" placeholder="Pilih Tanggal" required>
                </div>
                <div class="col-md-6">
                    <input type="text" name="keterangan" class="form-control" placeholder="Keterangan libur (opsional)">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Tambah</button>
                </div>
            </form>

            <table class="table table-sm table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width: 20%">Tanggal</th>
                        <th style="width: 50%">Keterangan</th>
                        <th style="width: 30%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($libur as $l)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($l->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $l->keterangan ?? '-' }}</td>
                        <td>
                            <form action="{{ route('libur.destroy', $l->id) }}" method="POST" onsubmit="return confirm('Hapus libur ini?')" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script Datepicker --}}
@push('myscript')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr("#tanggal_libur", {
  dateFormat: "Y-m-d",
  altInput: true,
  altFormat: "d-m-Y",
  locale: "id"  // sudah ada bawaan bahasa Indonesia
});
// Edit jam masuk/pulang
$(document).on("click", ".edit-jam", function(e) {
    e.preventDefault();
    let id   = $(this).data("id");
    let tipe = $(this).data("tipe");

    Swal.fire({
        title: 'Edit Jam ' + (tipe === 'masuk' ? 'Masuk' : 'Pulang'),
        html: `<input type="text" id="jamInput" class="form-control" placeholder="Pilih Jam">`,
        showCancelButton: true,
        confirmButtonText: 'Simpan',
        didOpen: () => {
            flatpickr("#jamInput", {
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i",
                time_24hr: true
            });
        },
        preConfirm: () => {
            return document.getElementById("jamInput").value;
        }
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            $.ajax({
                url: "/jadwal/update/" + id,
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    tipe: tipe,
                    jam: result.value
                },
                success: function(res) {
                    if (res.success) {
                        Swal.fire('Berhasil!', 'Jam berhasil diperbarui.', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Gagal!', res.message || 'Tidak bisa update jam.', 'error');
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText); // debug detail error Laravel
                    Swal.fire('Error!', xhr.responseJSON?.message || 'Terjadi kesalahan server.', 'error');
                }
            });
        }
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endpush

@endsection
