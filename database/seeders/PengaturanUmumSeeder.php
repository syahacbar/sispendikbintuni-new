<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengaturanUmumSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            ['key' => 'title', 'value' => 'Sispendik Bintuni'],
            ['key' => 'tagline', 'value' => 'Sistem Informasi Pendidikan'],
            ['key' => 'light_color', 'value' => '#020617'],
            ['key' => 'logo', 'value' => '01JR5EKV0E1691Z5VK2RQHT6ZC.svg'],
            ['key' => 'favicon', 'value' => '01JR331RF1M9S9RFTC6S35KHDZ.svg'],
            ['key' => 'footer', 'value' => 'Sispendik Bintuni | All rights reserved. | '],
            ['key' => 'created_by', 'value' => 'Arasoft Digital Media'],
        ];

        foreach ($data as $item) {
            DB::table('tbl_pengaturan_umums')->insert([
                'id' => Str::uuid(),
                'key' => $item['key'],
                'value' => $item['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
