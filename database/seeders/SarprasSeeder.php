<?php

namespace Database\Seeders;

use App\Models\Sarpras;
use App\Models\Sekolah;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\JenisSarpras;

class SarprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoriOptions = ['Sarana', 'Prasarana'];
        $kondisiOptions = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
        $kurangLebihOptions = ['Kurang', 'Lebih'];

        $sekolahs = Sekolah::all();
        $jenisSarprasList = JenisSarpras::all();

        foreach ($sekolahs as $sekolah) {
            foreach ($jenisSarprasList as $jenis) {
                Sarpras::create([
                    'id' => Str::uuid(),
                    'sekolah_id' => $sekolah->id,
                    'jenis_sarpras_id' => $jenis->id,
                    'kategori' => fake()->randomElement($kategoriOptions),
                    'jumlah_ideal' => fake()->numberBetween(5, 20),
                    'jumlah_saat_ini' => fake()->numberBetween(0, 20),
                    'kondisi' => fake()->randomElement($kondisiOptions),
                    'kurang_lebih' => fake()->randomElement($kurangLebihOptions),
                    'keterangan' => fake()->sentence(),
                ]);
            }
        }
    }
}
