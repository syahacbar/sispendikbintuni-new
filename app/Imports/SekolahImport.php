<?php

namespace App\Imports;

use App\Models\Sekolah;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SekolahImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Sekolah([
            'id' => Str::uuid(),
            'npsn' => $row['npsn'],
            'kurikulum_id' => $row['kurikulum_id'],
            'nama' => $row['nama'],
            'jenjang' => $row['jenjang'],
            'alamat_jalan' => $row['alamat_jalan'],
            'kode_pos' => $row['kode_pos'],
            'status_sekolah' => $row['status_sekolah'],
            'akreditasi' => $row['akreditasi'],
            'email' => $row['email'],
            'telepon' => $row['telepon'],
            'sk_pendirian' => $row['sk_pendirian'],
            'tanggal_sk_pendirian' => $row['tanggal_sk_pendirian'],
            'sk_izin_operasional' => $row['sk_izin_operasional'],
            'tanggal_sk_izin_operasional' => $row['tanggal_sk_izin_operasional'],
            'lintang' => $row['lintang'],
            'bujur' => $row['bujur'],
            'kode_wilyah' => $row['kode_wilayah'],
            'slug' => Str::slug($row['nama'] . '-' . $row['npsn']),
        ]);
    }
}
