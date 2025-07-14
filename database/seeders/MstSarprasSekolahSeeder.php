<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class MstSarprasSekolahSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $sekolahIds = DB::table('mst_sekolah')->pluck('id')->toArray();
        $sarprasItems = DB::table('ref_sarpras')->get();

        if (empty($sekolahIds) || $sarprasItems->isEmpty()) {
            echo "⚠️ Data sekolah atau sarpras tidak ditemukan. Seeder dibatalkan.\n";
            return;
        }

        $data = [];

        foreach ($sekolahIds as $sekolahId) {
            // Ambil 5–10 sarpras secara acak untuk tiap sekolah
            $jumlahSarpras = rand(5, 10);
            $sampleSarpras = $sarprasItems->random($jumlahSarpras);

            foreach ($sampleSarpras as $sarpras) {
                $jumlahSaatIni = rand(0, 10);
                $jumlahIdeal = rand($jumlahSaatIni, $jumlahSaatIni + 5);

                $data[] = [
                    'id' => Str::uuid(),
                    'sekolah_id' => $sekolahId,
                    'sarpras_id' => $sarpras->id,
                    'nama' => $sarpras->nama ?? $faker->words(2, true),
                    'jumlah_saat_ini' => $jumlahSaatIni,
                    'jumlah_ideal' => $jumlahIdeal,
                    'keterangan' => $faker->optional()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('mst_sarpras_sekolah')->insert($data);
        echo "✅ Seeder mst_sarpras_sekolah berhasil dijalankan (" . count($data) . " records).\n";
    }
}
