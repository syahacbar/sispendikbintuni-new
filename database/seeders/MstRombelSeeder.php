<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class MstRombelSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Ambil data referensi
        $kurikulumIds = DB::table('ref_kurikulum')->pluck('id')->toArray();
        $semesterIds = DB::table('ref_semester')->pluck('id')->toArray();
        $waliIds = DB::table('mst_gtk')->pluck('id')->toArray();
        $sekolahIds = DB::table('mst_sekolah')->pluck('id')->toArray();

        // Daftar jurusan umum di Dapodik SMK/SMA
        $jurusanList = [
            'IPA',
            'IPS',
            'Bahasa',
            'Akuntansi',
            'Teknik Komputer',
            'TKJ',
            'RPL',
            'Multimedia',
            'Perhotelan',
            'Farmasi',
            'Teknik Mesin',
            'Teknik Otomotif'
        ];

        foreach (range(1, 200) as $i) {
            $tingkat = $faker->numberBetween(1, 12);
            $jenjang = $tingkat <= 6 ? 'SD' : ($tingkat <= 9 ? 'SMP' : 'SMA/SMK');

            DB::table('mst_rombel')->insert([
                'id' => Str::uuid(),
                'sekolah_id' => $faker->randomElement($sekolahIds),
                'kurikulum_id' => $faker->randomElement($kurikulumIds),
                'nama' => 'Kelas ' . $tingkat . $faker->randomElement(['A', 'B', 'C']),
                'tingkat' => $tingkat,
                'jurusan' => $jenjang === 'SMA/SMK' ? $faker->randomElement($jurusanList) : null,
                'kapasitas' => $faker->numberBetween(25, 40),
                'wali_kelas_ptk_id' => $faker->randomElement($waliIds),
                'semester_id' => $faker->randomElement($semesterIds),
                'status_aktif' => true,
                'keterangan' => $faker->optional()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        echo "✅ Seeder mst_rombel berhasil dibuat (200 rombel).\n";
    }
}
