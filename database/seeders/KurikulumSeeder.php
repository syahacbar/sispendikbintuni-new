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
                'kode' => 'KTSP',
                'nama' => 'Kurikulum Tingkat Satuan Pendidikan',
                'jenis' => 'Nasional',
                'tahun_mulai' => 2006,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'kode' => 'KBK',
                'nama' => 'Kurikulum Berbasis Kompetensi',
                'jenis' => 'Nasional',
                'tahun_mulai' => 2007,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'kode' => 'K13',
                'nama' => 'Kurikulum 2013',
                'jenis' => 'Nasional',
                'tahun_mulai' => 2013,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => Str::uuid(),
                'kode' => 'KKNI',
                'nama' => 'Kurikulum Kerangka Kualifikasi Nasional Indonesia',
                'jenis' => 'Nasional',
                'tahun_mulai' => 2021,
                'status' => 'Aktif',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
