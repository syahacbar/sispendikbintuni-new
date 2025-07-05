<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class JenisSarprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama' => 'Ruangan Kelas'],
            ['nama' => 'Ruangan Perpustakaan'],
            ['nama' => 'Ruangan Laboratorium'],
            ['nama' => 'Ruangan Praktik'],
            ['nama' => 'Ruangan Pimpinan'],
            ['nama' => 'Ruangan Guru'],
            ['nama' => 'Ruangan Ibadah'],
            ['nama' => 'Ruangan UKS'],
            ['nama' => 'Ruangan Toilet'],
            ['nama' => 'Ruangan Gudang'],
            ['nama' => 'Ruangan Sirkulasi'],
            ['nama' => 'Tempat Bermain'],
            ['nama' => 'Ruangan Tata Usaha'],
            ['nama' => 'Ruangan Konseling'],
            ['nama' => 'Ruangan OSIS'],
            ['nama' => 'Bangunan'],
        ];

        foreach ($data as $item) {
            DB::table('tbl_jenis_sarpras')->insert([
                'id' => Str::uuid(),
                'nama' => $item['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
