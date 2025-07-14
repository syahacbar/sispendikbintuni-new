<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefJenisGtkSeeder extends Seeder
{
    public function run(): void
    {
        $jenisGtkList = [
            'Guru',
            'Kepala Sekolah',
            'Tenaga Kependidikan',
        ];

        foreach ($jenisGtkList as $nama) {
            DB::table('ref_jenis_gtk')->insert([
                'id' => Str::uuid(),
                'nama' => $nama,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
