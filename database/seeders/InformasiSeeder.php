<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Informasi;
use App\Models\Sekolah;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua sekolah yang tersedia
        $sekolahs = Sekolah::all();

        if ($sekolahs->isEmpty()) {
            $this->command->warn('Tidak ada data sekolah. Seeder tidak dijalankan.');
            return;
        }

        $kategoriList = ['Berita', 'Kegiatan', 'Pengumuman'];

        foreach ($kategoriList as $kategori) {
            foreach (range(1, 20) as $i) {
                $judul = fake()->sentence(3);
                $sekolah_id = $sekolahs->random()->id;

                Informasi::create([
                    'id' => Str::uuid(),
                    'sekolah_id' => $sekolah_id,
                    'judul' => $judul,
                    'deskripsi' => fake()->paragraph(),
                    'kategori' => $kategori,
                    'gambar' => 'assets/default.png', // default image
                    'slug' => Str::slug($judul) . '-' . Str::random(5),
                    'created_at' => now()->setDate(2025, 7, rand(3, 7)), // tanggal acak antara 3–7 Juli
                    'updated_at' => now(),
                ]);
            }
        }

        $this->command->info('Seeder berhasil membuat 20 data per kategori (total 60 data).');
    }
}
