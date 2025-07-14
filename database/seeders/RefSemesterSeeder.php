<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefSemesterSeeder extends Seeder
{
    public function run(): void
    {
        $semesters = [
            ['kode_semester' => '20231', 'tahun_ajaran' => '2023/2024', 'nama_semester' => 'Semester Ganjil', 'is_aktif' => false],
            ['kode_semester' => '20232', 'tahun_ajaran' => '2023/2024', 'nama_semester' => 'Semester Genap',  'is_aktif' => false],
            ['kode_semester' => '20241', 'tahun_ajaran' => '2024/2025', 'nama_semester' => 'Semester Ganjil', 'is_aktif' => true],
            ['kode_semester' => '20242', 'tahun_ajaran' => '2024/2025', 'nama_semester' => 'Semester Genap',  'is_aktif' => false],
            ['kode_semester' => '20251', 'tahun_ajaran' => '2025/2026', 'nama_semester' => 'Semester Ganjil', 'is_aktif' => false],
            ['kode_semester' => '20252', 'tahun_ajaran' => '2025/2026', 'nama_semester' => 'Semester Genap',  'is_aktif' => false],
        ];

        foreach ($semesters as $semester) {
            DB::table('ref_semester')->insert([
                'id' => Str::uuid(),
                'kode_semester' => $semester['kode_semester'],
                'tahun_ajaran' => $semester['tahun_ajaran'],
                'nama_semester' => $semester['nama_semester'],
                'is_aktif' => $semester['is_aktif'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
