
<div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
        <thead class="table-dark text-center">
            
        </thead>
        <tbody>
            @foreach ($presensi as $d)
            <tr class="text-center">
                <td>{{ $loop->iteration }}</td>
                <td>{{ $d->nik }}</td>
                <td class="text-start">{{ $d->nama_lengkap }}</td>
                <td>{{ $d->jabatan }}</td>  

                {{-- Jam Masuk --}}
                <td>
                    {!! $d->jamIn ? '<span class="fw-bold text-primary">' . $d->jamIn . '</span>' : '-' !!}
                </td>
                
                {{-- Keterangan Masuk --}}
                <td>
    <span class="button text-dark">
        {{ $d->ketMasuk }}
    </span>
</td>

                {{-- Jam Pulang --}}
                <td>
                    {!! $d->jamOut ? '<span class="fw-bold text-primary">' . $d->jamOut . '</span>' : '-' !!}
                </td>

                {{-- Keterangan Pulang --}}
                <td>
    <span class="button text-dark">
        {{ $d->ketPulang }}
    </span>
</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


