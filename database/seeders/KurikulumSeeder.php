<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_kurikulums')->insert([
            [
                'id' => Str::uuid(),
                'kode' => 'KUR2021',
                'nama' => 'Kurikulum Nasional 2021',
                'jenis' => 'Nasional',
                'tahun_mulai' => 2021,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'kode' => 'KURMUL2020',
                'nama' => 'Kurikulum Muatan Lokal 2020',
                'jenis' => 'Muatan Lokal',
                'tahun_mulai' => 2020,
                'status' => 'Tidak Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'kode' => 'KURLAIN2019',
                'nama' => 'Kurikulum Khusus 2019',
                'jenis' => 'Lainnya',
                'tahun_mulai' => 2019,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
