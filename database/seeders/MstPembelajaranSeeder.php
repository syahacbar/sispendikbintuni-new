<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class MstPembelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        // Ambil data referensi UUID
        $rombelIds = DB::table('mst_rombel')->pluck('id')->toArray();
        $mapelIds = DB::table('ref_mapel')->pluck('id')->toArray();
        $ptkIds = DB::table('mst_gtk')->pluck('id')->toArray();
        $semesterIds = DB::table('ref_semester')->pluck('id')->toArray();

        if (empty($rombelIds) || empty($mapelIds) || empty($semesterIds)) {
            echo "⚠️ Rombel, Mapel, atau Semester belum tersedia.\n";
            return;
        }

        $data = [];

        foreach ($rombelIds as $rombonganBelajarId) {
            $jumlahMapel = rand(5, 10); // tiap rombel punya 5-10 mapel
            $selectedMapels = $faker->randomElements($mapelIds, $jumlahMapel);

            foreach ($selectedMapels as $mapelId) {
                $data[] = [
                    'id' => Str::uuid(),
                    'rombongan_belajar_id' => $rombonganBelajarId,
                    'mata_pelajaran_id' => $mapelId,
                    'gtk_id' => $faker->randomElement($ptkIds),
                    'semester_id' => $faker->randomElement($semesterIds),
                    'jam_mengajar_per_minggu' => rand(2, 6),
                    'jenis_pembelajaran' => $faker->randomElement(['Tatap Muka', 'Daring', 'Hybrid']),
                    'status_aktif' => true,
                    'tgl_mulai' => $faker->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
                    'tgl_selesai' => $faker->dateTimeBetween('now', '+2 months')->format('Y-m-d'),
                    'keterangan' => $faker->optional()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('mst_pembelajaran')->insert($data);
        echo "✅ Seeder mst_pembelajaran berhasil dijalankan (" . count($data) . " data).\n";
    }
}
