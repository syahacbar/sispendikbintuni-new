<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Faker\Factory;

class MstGtkSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/mst_gtk.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Validasi jumlah kolom minimal 12
            if (count($row) < 12) {
                $this->command->warn("Baris dilewati: kolom kurang dari 12 → " . json_encode($row));
                continue;
            }

            // Coba parsing tgl_lahir jika valid
            $tanggal = null;
            try {
                $tanggal = Carbon::createFromFormat('d/m/Y', trim($row[6]))->format('Y-m-d');
            } catch (\Exception $e) {
                $this->command->warn("Format tanggal tidak valid untuk nama: {$row[0]}, value: {$row[6]}");
            }

            DB::table('mst_gtk')->insert([
                'id' => Str::uuid(),
                'nama' => trim($row[0]),
                'nik' => $this->toNull($row[1]),
                'nip' => $this->toNull($row[2]),
                'nuptk' => $this->toNull($row[3]),
                'tempat_tugas' => trim($row[5]),
                'tempat_lahir' => trim($row[4]),
                'tgl_lahir' => $tanggal,
                'jenis_kelamin' => trim($row[7]),
                'status_kepegawaian' => trim($row[8]),
                'jenis_gtk' => trim($row[9]),
                'pend_terakhir' => trim($row[10]),
                'status_keaktifan' => trim($row[11]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }

    // Fungsi bantu untuk ubah 'null' string menjadi nilai null
    private function toNull($value)
    {
        $val = trim($value);
        return ($val === '' || strtolower($val) === 'null') ? null : $val;
    }
}
