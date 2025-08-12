<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MstSekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_sekolah.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Validasi: minimal 11 kolom (index 0 - 10)
            if (count($row) < 11) {
                $this->command->warn('Baris dilewati karena jumlah kolom kurang: ' . json_encode($row));
                continue;
            }

            DB::table('mst_sekolah')->insert([
                'id' => (string) Str::uuid(),
                'npsn' => trim($row[0]),
                'nama' => trim($row[1]),
                'alamat' => trim($row[2]),
                'kode_wilayah' => trim($row[3]),
                'kode_pos' => trim($row[4]),
                'status' => trim($row[5]),
                'kode_jenjang' => trim($row[6]),
                'akreditasi' => trim($row[7]),
                'email' => trim($row[8]),
                'latitude' => trim($row[9]) ?: null,
                'longitude' => trim($row[10]) ?: null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
