<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MstKondisiSarprasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil beberapa ID dari mst_sarpras_sekolah untuk digunakan sebagai relasi
        $sarprasIds = DB::table('mst_sarpras_sekolah')->pluck('id')->toArray();

        if (empty($sarprasIds)) {
            $this->command->warn('Tidak ada data di mst_sarpras_sekolah. Seeder ini membutuhkan data relasi.');
            return;
        }

        $data = [];

        foreach (range(1, 20) as $i) {
            $data[] = [
                'id' => Str::uuid(),
                'id_mst_sarpras' => $sarprasIds[array_rand($sarprasIds)],
                'kondisi' => collect(['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'])->random(),
                'jumlah' => rand(1, 50),
                'keterangan' => fake()->optional()->sentence(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        DB::table('mst_kondisi_sarpras')->insert($data);
    }
}
