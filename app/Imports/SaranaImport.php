<?php

namespace App\Imports;

use App\Models\Sarana;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SaranaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Sarana([
            'id' => Str::uuid(),
            'sekolah_id' => $row['sekolah_id'],
            'r_kelas' => $row['r_kelas'] ?? 0,
            'r_perpus' => $row['r_perpus'] ?? 0,
            'r_lab' => $row['r_lab'] ?? 0,
            'r_praktik' => $row['r_praktik'] ?? 0,
            'r_pimpinan' => $row['r_pimpinan'] ?? 0,
            'r_guru' => $row['r_guru'] ?? 0,
            'r_ibadah' => $row['r_ibadah'] ?? 0,
            'r_uks' => $row['r_uks'] ?? 0,
            'r_toilet' => $row['r_toilet'] ?? 0,
            'r_gudang' => $row['r_gudang'] ?? 0,
            'r_sirkulasi' => $row['r_sirkulasi'] ?? 0,
            'tempat_bermain' => $row['tempat_bermain'] ?? 0,
            'r_tu' => $row['r_tu'] ?? 0,
            'r_konseling' => $row['r_konseling'] ?? 0,
            'r_osis' => $row['r_osis'] ?? 0,
            'r_bangunan' => $row['r_bangunan'] ?? 0,
        ]);
    }
}
