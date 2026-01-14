<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefMapelSeeder extends Seeder
{
    public function run(): void
    {
        $filePath = database_path('seeders/data/ref_mapel.csv');

        if (!file_exists($filePath)) {
            $this->command->error("File CSV tidak ditemukan: {$filePath}");
            return;
        }

        if (($handle = fopen($filePath, 'r')) !== false) {
            // Deteksi delimiter (`,` atau `;`)
            $firstLine = fgets($handle);
            rewind($handle);
            $delimiter = str_contains($firstLine, ';') ? ';' : ',';

            // Baca header
            $header = fgetcsv($handle, 1000, $delimiter);
            $header = array_map(fn($h) => strtolower(trim($h, "\xEF\xBB\xBF \t\n\r\0\x0B")), $header);

            // Loop isi CSV
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                $data = array_combine($header, $row);

                $kode     = $data['kode'] ?? null;
                $nama     = $data['nama'] ?? null;
                $jenjang  = $data['kode_jenjang_pendidikan'] ?? null;
                $jjp      = $data['jjp'] ?? null;
                $tingkat  = $data['tingkat'] ?? null;

                if (!$kode || !$nama || !$jenjang || !$jjp || !$tingkat) {
                    $this->command->warn("Lewati baris karena ada kolom kosong: " . json_encode($data));
                    continue;
                }

                // Cek duplikat berdasarkan kode + jenjang
                $exists = DB::table('ref_mapel')
                    ->where('kode', $kode)
                    ->where('kode_jenjang_pendidikan', $jenjang)
                    ->exists();

                if ($exists) {
                    $this->command->warn("Skip duplikat: {$kode} - {$nama}");
                    continue;
                }

                DB::table('ref_mapel')->insert([
                    'id' => Str::uuid(),
                    'kode' => $kode,
                    'nama' => $nama,
                    'kode_jenjang_pendidikan' => $jenjang,
                    'jjp' => $jjp,
                    'tingkat' => $tingkat,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            fclose($handle);
        }
    }
}
