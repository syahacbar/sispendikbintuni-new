<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MstAnggotaRombelSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_anggota_rombel.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        $count = 0;

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Minimal 6 kolom
            if (count($row) < 6) {
                $this->command->warn("Baris dilewati: kolom kurang dari 6 → " . json_encode($row));
                continue;
            }

            $tanggalMasuk = $this->parseDate($row[3]);
            $tanggalKeluar = $this->parseDate($row[4]);

            DB::table('mst_anggota_rombel')->insert([
                'id'              => Str::uuid(),
                'rombel_id'       => $this->toNull($row[0]),
                'peserta_didik_id' => $this->toNull($row[1]),
                'status_keaktifan' => $this->toNull($row[2]) ?? true,
                'tanggal_masuk'   => $tanggalMasuk,
                'tanggal_keluar'  => $tanggalKeluar,
                'keterangan'      => $this->toNull($row[5]),
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            $count++;
        }

        fclose($file);

        $this->command->info("✅ Seeder mst_anggota_rombel berhasil dijalankan ($count data).");
    }

    private function toNull($value)
    {
        $val = trim($value);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }

    private function parseDate($value)
    {
        $val = trim($value);
        if ($val === '' || strtolower($val) === 'null') {
            return null;
        }

        try {
            // Coba parsing dalam format Y-m-d
            return Carbon::parse($val)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
