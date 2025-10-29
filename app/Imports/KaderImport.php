<?php

namespace App\Imports;

use App\Models\Kader;
use App\Models\Pac;
use App\Enums\KaderStatus;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class KaderImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $pac = Pac::where('name', $row['kecamatan'])->first();

        return new Kader([
            'nia' => $row['nia'] ?? null,
            'nik' => $row['nik'] ?? null,
            'username' => $row['username'] ?? null,
            'email' => $row['email'] ?? null,
            'phone_number' => $row['no_hp'] ?? null,
            'name' => $row['nama_lengkap'] ?? null,
            'place_of_birth' => $row['tempat_lahir'] ?? null,
            'date_of_birth' => $row['tanggal_lahir'] ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']) : null,
            'hobby' => $row['hobi'] ?? null,
            'address' => $row['alamat'] ?? null,
            'village' => $row['kelurahan'] ?? null,
            'city' => $row['kabupaten'] ?? null,
            'province' => $row['provinsi'] ?? null,
            'status' => KaderStatus::tryFrom($row['status']) ?? KaderStatus::Aktif,
            'pac_id' => $pac ? $pac->id : null,
        ]);
    }
}
