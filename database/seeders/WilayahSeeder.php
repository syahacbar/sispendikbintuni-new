<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $wilayah = [
            ['kode' => '99', 'nama' => 'Provinsi Contoh'],
            ['kode' => '99.01', 'nama' => 'Kabupaten Contoh Selatan'],
            ['kode' => '99.01.01', 'nama' => 'Kecamatan Contoh Barat'],
            ['kode' => '99.01.01.1001', 'nama' => 'Desa Alpha'],
            ['kode' => '99.01.01.1002', 'nama' => 'Desa Beta'],
            ['kode' => '99.01.01.1003', 'nama' => 'Desa Gamma'],
            ['kode' => '99.01.01.1004', 'nama' => 'Desa Delta'],
            ['kode' => '99.01.02', 'nama' => 'Kecamatan Contoh Timur'],
            ['kode' => '99.01.02.1001', 'nama' => 'Desa Epsilon'],
            ['kode' => '99.01.02.1002', 'nama' => 'Desa Zeta'],
            ['kode' => '99.02', 'nama' => 'Kabupaten Contoh Utara'],
            ['kode' => '99.02.01', 'nama' => 'Kecamatan Contoh Tengah'],
            ['kode' => '99.02.01.1001', 'nama' => 'Desa Eta'],
            ['kode' => '99.02.01.1002', 'nama' => 'Desa Theta'],
        ];

        foreach ($wilayah as $item) {
            DB::table('tbl_wilayahs')->insert([
                'kode' => $item['kode'],
                'nama' => $item['nama'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
