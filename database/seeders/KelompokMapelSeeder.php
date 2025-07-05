<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KelompokMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kelompokMapels = [
            'Umum',
            'MIPA',
            'IPS',
            'Bahasa dan Budaya',
            'Vokasi dan Prakarya',
            'Dasar Bidang Keahlian',
            'Dasar Program Keahlian',
            'Kompetensi Keahlian',
            'Peminatan',
        ];

        foreach ($kelompokMapels as $nama) {
            DB::table('tbl_kelompok_mapels')->insert([
                'id' => Str::uuid(),
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
