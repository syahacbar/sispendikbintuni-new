<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MstRombelSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_rombel.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Validasi jumlah kolom minimal 10
            if (count($row) < 10) {
                $this->command->warn("Baris dilewati: kolom kurang dari 10 → " . json_encode($row));
                continue;
            }

            DB::table('mst_rombel')->insert([
                'id'                => Str::uuid(),
                'sekolah_id'        => $this->toNull($row[0]),
                'kurikulum_id'      => $this->toNull($row[1]),
                'nama'              => trim($row[2]),
                'tingkat'           => $this->toNull($row[3]),
                'jurusan'           => $this->toNull($row[4]),
                'kapasitas'         => $this->toNull($row[5]),
                'wali_kelas_ptk_id' => $this->toNull($row[6]),
                'semester_id'       => $this->toNull($row[7]),
                'status_aktif'      => $this->toNull($row[8]),
                'keterangan'        => $this->toNull($row[9]),
                'created_at'        => now(),
                'updated_at'        => now(),
            ]);
        }

        fclose($file);
    }

    private function toNull($value)
    {
        $val = trim($value);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }
}
