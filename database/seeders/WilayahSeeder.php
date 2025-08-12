<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class WilayahSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('seeders/data/tbl_wilayahs.csv');

        $file = fopen($csvFile, 'r');

        // Lewati header
        fgetcsv($file, 0, ';');

        while (($row = fgetcsv($file, 0, ';')) !== false) {
            // Cek minimal ada 2 kolom (kode dan nama)
            if (count($row) < 2) continue;

            DB::table('ref_wilayah')->insert([
                'kode' => trim($row[0]),
                'nama' => trim($row[1]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        fclose($file);
    }
}
