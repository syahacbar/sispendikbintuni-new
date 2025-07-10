<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TentangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'key' => 'deskripsi',
                'value' => '<p>Sistem Informasi Pendidikan Kabupaten Teluk Bintuni (Sispendik Bintuni) merupakan platform digital yang dikembangkan untuk memberikan kemudahan dalam pengelolaan dan penyajian data pendidikan. Sistem ini menjadi wadah integrasi informasi dari satuan pendidikan, tenaga kependidikan, peserta didik, hingga sarana dan prasarana secara realtime dan akurat.</p>',
            ],
            [
                'key' => 'visi',
                'value' => '<p>Menjadi sistem informasi pendidikan yang akurat, terintegrasi, dan transparan untuk mendukung peningkatan mutu pendidikan di Kabupaten Teluk Bintuni.</p>',
            ],
            [
                'key' => 'misi',
                'value' => '<ul><li>Menyediakan akses data pendidikan yang cepat dan mudah.</li><li>Mendukung pengambilan kebijakan berbasis data.</li><li>Mempermudah koordinasi antar instansi pendidikan.</li><li>Meningkatkan partisipasi publik terhadap pendidikan melalui transparansi informasi.</li></ul>',
            ],
            [
                'key' => 'tujuan',
                'value' => '<ul><li>Memberikan informasi yang valid dan terkini tentang kondisi pendidikan.</li><li>Mendukung efisiensi dalam pengelolaan data pendidikan.</li><li>Mendorong akuntabilitas dalam pelaksanaan program pendidikan.</li></ul>',
            ],
        ];

        foreach ($data as $index => $item) {
            DB::table('tbl_tentangs')->insert([
                'id' => Str::uuid(),
                'key' => $item['key'],
                'value' => $item['value'],
                'sort_order' => $index,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
