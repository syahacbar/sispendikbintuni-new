<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PengaduanSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 20) as $i) {
            DB::table('tbl_pengaduans')->insert([
                'id' => Str::uuid(),
                'nomor_laporan' => 'LAP-' . str_pad($i, 5, '0', STR_PAD_LEFT),
                'nama_pelapor' => fake()->name(),
                'judul_laporan' => fake()->sentence(6),
                'email' => fake()->unique()->safeEmail(),
                'no_hp' => fake()->phoneNumber(),
                'kategori' => fake()->randomElement(['Pelanggaran', 'Kritik', 'Saran', 'Permintaan Informasi']),
                'dok_lampiran' => fake()->optional()->url(),
                'isi' => fake()->paragraph(4),
                'status' => fake()->randomElement(['terkirim', 'diproses', 'selesai']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
