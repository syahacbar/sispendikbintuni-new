<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ExtPengaduanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $kategoriList = ['Fasilitas', 'Kekerasan', 'Keuangan', 'Pelanggaran Tata Tertib', 'Lainnya'];

        foreach (range(1, 100) as $i) {
            $nomor = 'PL-' . now()->format('Ymd') . '-' . str_pad($i, 5, '0', STR_PAD_LEFT);

            DB::table('ext_pengaduan')->insert([
                'id' => Str::uuid(),
                'nomor_laporan' => $nomor,
                'nama_pelapor' => $faker->name(),
                'judul_laporan' => $faker->sentence(6),
                'email' => $faker->safeEmail(),
                'no_hp' => $faker->phoneNumber(),
                'kategori' => $faker->randomElement($kategoriList),
                'dok_lampiran' => null, // Bisa diganti dengan path file jika diperlukan
                'isi' => $faker->paragraphs(rand(2, 4), true),
                'status' => 'terkirim',
                'ip_address' => $faker->ipv4(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "✅ Seeder ext_pengaduan berhasil dibuat (100 data).\n";
    }
}
