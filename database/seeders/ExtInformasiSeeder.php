<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ExtInformasiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $kategoriList = ['Berita', 'Kegiatan', 'Pengumuman'];
        $data = [];

        foreach (range(1, 50) as $i) {
            $judul = $faker->sentence(6);
            $kategori = $faker->randomElement($kategoriList);

            $data[] = [
                'id' => Str::uuid(),
                'judul' => $judul,
                'deskripsi' => $faker->paragraphs(rand(2, 4), true),
                'kategori' => $kategori,
                'gambar' => $faker->imageUrl(640, 480, 'education', true, $kategori),
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'lihat' => $faker->numberBetween(0, 500),
                // 'users_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ext_informasi')->insert($data);
        echo "✅ Seeder ext_informasi berhasil dijalankan (50 data, tanpa users_id).\n";
    }
}
