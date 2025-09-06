<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MstSarprasSekolahSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_sarpras_sekolah.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        $count = 0;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Validasi jumlah kolom minimal 6 (disesuaikan dengan struktur tabel)
            if (count($row) < 6) {
                $this->command->warn("Baris dilewati: kolom kurang dari 6 → " . json_encode($row));
                continue;
            }

            DB::table('mst_sarpras_sekolah')->insert([
                'id'              => Str::uuid(),
                'sekolah_id'      => $this->toNull($row[0]),
                'sarpras_id'      => $this->toNull($row[1]),
                'nama'            => trim($row[2]),
                'jumlah_saat_ini' => $this->toNull($row[3]),
                'jumlah_ideal'    => $this->toNull($row[4]),
                'keterangan'      => $this->toNull($row[5] ?? null),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $count++;
        }

        fclose($file);

        $this->command->info("✅ Seeder mst_sarpras_sekolah berhasil dijalankan ($count records).");
    }

    private function toNull($value)
    {
        if ($value === null) return null;
        $val = trim($value);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }
}
