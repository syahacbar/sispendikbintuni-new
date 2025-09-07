<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefSarprasSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $filePath = database_path('seeders/data/ref_sarpras.csv');

        if (!file_exists($filePath)) {
            $this->command->error("File CSV tidak ditemukan: {$filePath}");
            return;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = str_contains($firstLine, ';') ? ';' : ',';

            $header = fgetcsv($handle, 1000, $delimiter);
            $header = array_map(fn($h) => strtolower(trim($h, "\xEF\xBB\xBF \t\n\r\0\x0B")), $header);

            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data = array_combine($header, $row);
                $nama     = $data['nama'] ?? null;
                $kategori = $data['kategori'] ?? null;

                // Normalisasi kategori agar sesuai constraint DB
                $kategori = ucfirst(strtolower($kategori));

                if (!$nama || !$kategori) {
                    continue; // skip kalau ada kolom kosong
                }

                // Cek duplikat berdasarkan nama + kategori
                $exists = DB::table('ref_sarpras')
                    ->where('nama', $nama)
                    ->where('kategori', $kategori)
                    ->exists();

                if ($exists) {
                    $this->command->warn("Skip duplikat: {$nama} - {$kategori}");
                    continue;
                }

                DB::table('ref_sarpras')->insert([
                    'id'         => Str::uuid(),
                    'nama'       => $nama,
                    'kategori'   => $kategori,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            fclose($handle);
        }
    }
}
