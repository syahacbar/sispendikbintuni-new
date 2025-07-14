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

        if (!file_exists($csvFile)) {
            $this->command->error("CSV file not found: $csvFile");
            return;
        }

        $file = fopen($csvFile, 'r');

        // Skip header
        fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            DB::table('ref_wilayah')->insert([
                'kode' => $row[0],
                'nama' => $row[1],
                'created_at' => $row[2],
                'updated_at' => $row[3],
            ]);
        }

        fclose($file);
    }
}
