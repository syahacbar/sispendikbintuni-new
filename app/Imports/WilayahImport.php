<?php

namespace App\Imports;

use App\Models\Wilayah;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WilayahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['kode']) || empty($row['nama'])) {
            return null;
        }

        return new Wilayah([
            'kode' => $row['kode'],
            'nama' => $row['nama'],
        ]);
    }
}
