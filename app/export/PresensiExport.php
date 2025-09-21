<?php

namespace App\Exports;

use App\Models\Presensi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PresensiExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Presensi::all(); // Bisa diganti query sesuai tanggal / filter
    }

    public function headings(): array
    {
        return [
            'No',
            'NIK',
            'Nama Lengkap',
            'Jabatan',
            'Jam Masuk',
            'Keterangan Masuk',
            'Jam Pulang',
            'Keterangan Pulang',
        ];
    }
}
