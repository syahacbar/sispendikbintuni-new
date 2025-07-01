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
            'nama' => $row['nama'],
            'jenjang' => $row['jenjang'],
            'alamat_jalan' => $row['alamat_jalan'],
            'desa_kelurahan' => $row['desa_kelurahan'],
            'kode_pos' => $row['kode_pos'],
            'kecamatan' => $row['kecamatan'],
            'kabupaten' => $row['kabupaten'],
            'provinsi' => $row['provinsi'],
            'kode_wilayah' => $row['kode_wilayah'],
            'status_sekolah' => $row['status_sekolah'],
            'akreditasi' => $row['akreditasi'],
            'email' => $row['email'],
            'telepon' => $row['telepon'],
            'sk_pendirian' => $row['sk_pendirian'],
            'tanggal_sk_pendirian' => $row['tanggal_sk_pendirian'],
            'slug' => Str::slug($row['nama'] . '-' . $row['npsn']),
        ]);
    }
}
