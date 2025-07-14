<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class ExtKalenderSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $events = [
            'Ujian Tengah Semester',
            'Ujian Akhir Semester',
            'Rapat Guru',
            'Libur Nasional',
            'Penerimaan Rapor',
            'Hari Santri',
            'Kegiatan Pramuka',
            'Kegiatan Literasi',
            'Class Meeting',
            'Pendaftaran Siswa Baru',
        ];

        $data = [];

        foreach (range(1, 30) as $i) {
            $nama = $faker->randomElement($events);
            $tanggalMulai = $faker->dateTimeBetween('-2 months', '+2 months');
            $lamaHari = rand(0, 2); // kegiatan bisa 1–3 hari
            $tanggalAkhir = clone $tanggalMulai;
            $tanggalAkhir->modify("+$lamaHari days");

            $withTime = (bool) rand(0, 1); // acak apakah pakai jam atau tidak

            $data[] = [
                'id' => Str::uuid(),
                'nama' => $nama,
                'tanggal_mulai' => $tanggalMulai->format('Y-m-d'),
                'tanggal_akhir' => $tanggalAkhir->format('Y-m-d'),
                'waktu' => $withTime,
                'deskripsi' => $faker->optional()->sentence(),
                'jam_mulai' => $withTime ? $faker->time('H:i:s') : null,
                'jam_akhir' => $withTime ? $faker->time('H:i:s') : null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('ext_kalender')->insert($data);

        echo "✅ Seeder ext_kalender berhasil dibuat (30 data event).\n";
    }
}
