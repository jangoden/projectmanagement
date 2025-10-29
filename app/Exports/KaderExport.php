<?php

namespace App\Exports;

use App\Models\Kader;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KaderExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'NIK',
            'Username',
            'Email',
            'Nama Lengkap',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Provinsi',
            'Kabupaten',
            'Kecamatan',
            'Kelurahan',
            'No HP',
            'Hobi',
            'Status',
            'NIA',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Kader::with('pac')->get()->map(function ($kader) {
            return [
                $kader->nik,
                $kader->username,
                $kader->email,
                $kader->name,
                $kader->place_of_birth,
                $kader->date_of_birth ? $kader->date_of_birth->format('Y-m-d') : null,
                $kader->address,
                $kader->province,
                $kader->city,
                $kader->pac->name ?? null, // Kecamatan (PAC name)
                $kader->village,
                $kader->phone_number,
                $kader->hobby,
                $kader->status->value,
                $kader->nia,
            ];
        });
    }
}
