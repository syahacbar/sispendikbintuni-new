<?php

namespace App\Imports;

use App\Models\PesertaDidik;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PesertaDidikImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new PesertaDidik([
            'id' => Str::uuid(),
            'sekolah_id' => $row['sekolah_id'],
            'nama' => $row['nama'],
            'nisn' => $row['nisn'],
            'nik' => $row['nik'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tgl_lahir' => $this->formatTanggal($row['tgl_lahir']),
            'jenjang' => $row['jenjang'],
            'alamat_jalan' => $row['alamat_jalan'],
            'desa_kelurahan' => $row['desa_kelurahan'],
            'kode_pos' => $row['kode_pos'],
            'kecamatan' => $row['kecamatan'],
            'kabupaten' => $row['kabupaten'],
            'provinsi' => $row['provinsi'],
        ]);
    }

    private function formatTanggal($value)
    {
        if (!$value) {
            return null;
        }

        // Jika numeric, kemungkinan besar serial Excel
        if (is_numeric($value)) {
            try {
                return Date::excelToDateTimeObject($value)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }

        // Jika format string, coba parse
        try {
            return Carbon::parse(str_replace('/', '-', $value))->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
