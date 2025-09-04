<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MstPesertaDidikSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_peserta_didik.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Validasi jumlah kolom minimal 11
            if (count($row) < 11) {
                $this->command->warn("Baris dilewati: kolom kurang dari 11 → " . json_encode($row));
                continue;
            }

            // Parsing tgl_lahir (format: dd/mm/YYYY atau YYYY-mm-dd)
            $tanggal = null;
            if (!empty(trim($row[5]))) {
                try {
                    if (preg_match('/\d{2}\/\d{2}\/\d{4}/', $row[5])) {
                        $tanggal = Carbon::createFromFormat('d/m/Y', trim($row[5]))->format('Y-m-d');
                    } else {
                        $tanggal = Carbon::parse(trim($row[5]))->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Format tanggal tidak valid untuk nama: {$row[0]}, value: {$row[5]}");
                }
            }

            DB::table('mst_peserta_didik')->insert([
                'id'            => Str::uuid(),
                'nama'          => trim($row[0]),
                'nipd'          => trim($row[1]),
                'nisn'          => $this->toNull($row[2]),
                'nik'           => $this->toNull($row[3]),
                'tempat_lahir'  => $this->toNull($row[4]),
                'tgl_lahir'     => $tanggal,
                'jenis_kelamin' => trim($row[6]),
                'agama'         => trim($row[7]),
                'alamat'        => trim($row[8]),
                'kode_wilayah'  => $this->toNull($row[9]),
                'kode_pos'      => trim($row[10]),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        fclose($file);
    }

    // Fungsi bantu untuk ubah 'null' string atau kosong jadi null
    private function toNull($value)
    {
        $val = trim($value);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }
}
