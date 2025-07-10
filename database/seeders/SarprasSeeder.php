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
                $jumlahIdeal = fake()->numberBetween(5, 20);
                $jumlahSaatIni = fake()->numberBetween(0, 20);

                $kurangLebih = $jumlahSaatIni < $jumlahIdeal ? 'Kurang' : 'Lebih';

                Sarpras::create([
                    'id' => Str::uuid(),
                    'sekolah_id' => $sekolah->id,
                    'jenis_sarpras_id' => $jenis->id,
                    'kategori' => fake()->randomElement($kategoriOptions),
                    'jumlah_ideal' => $jumlahIdeal,
                    'jumlah_saat_ini' => $jumlahSaatIni,
                    'kondisi' => fake()->randomElement($kondisiOptions),
                    'kurang_lebih' => $kurangLebih,
                    'keterangan' => fake()->sentence(),
                ]);
            }
        }
    }
}
