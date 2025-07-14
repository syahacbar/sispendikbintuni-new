<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefJenjangPendidikanSeeder extends Seeder
{
    public function run(): void
    {

        $jenisGtkList = [
            ['kode' => 'TK', 'nama' => 'Taman Kanak-kanak'],
            ['kode' => 'KB', 'nama' => 'Kelompok Bermain'],
            ['kode' => 'TPA', 'nama' => 'Tempat Penitipan Anak'],
            ['kode' => 'SPS', 'nama' => 'Satuan PAUD Sejenis'],
            ['kode' => 'PKBM', 'nama' => 'Pusat Kegiatan Belajar Masyarakat'],
            ['kode' => 'SKB', 'nama' => 'Sanggar Kegiatan Belajar'],
            ['kode' => 'SD', 'nama' => 'Sekolah Dasar'],
            ['kode' => 'SMP', 'nama' => 'Sekolah Menengah Pertama'],
            ['kode' => 'SMA', 'nama' => 'Sekolah Menengah Atas'],
            ['kode' => 'SMK', 'nama' => 'Sekolah Menengah Kejuruan'],
            ['kode' => 'SLB', 'nama' => 'Sekolah Luar Biasa'],
        ];

        foreach ($jenisGtkList as $nama) {
            DB::table('ref_jenjang_pendidikan')->insert([
                'kode' => $nama['kode'],
                'nama' => $nama['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
