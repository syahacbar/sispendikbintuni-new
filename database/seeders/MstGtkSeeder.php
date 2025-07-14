<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class MstGtkSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID'); // Faker lokal Indonesia

        $agama = ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu'];
        $jk = ['L', 'P'];
        $statusKepegawaian = ['PNS', 'PPPK', 'Honorer Daerah', 'Honorer Sekolah', 'GTY/PTY', 'Lainnya'];
        $pendidikan = ['SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3'];
        $statusKeaktifan = ['Aktif', 'Tidak Aktif'];

        // Ambil UUID dari jenis GTK yang sudah ada (pastikan data ref_jenis_gtk sudah ada)
        $jenisGtkIds = DB::table('ref_jenis_gtk')->pluck('id')->toArray();

        foreach (range(1, 50) as $i) {
            $jenisKelamin = $faker->randomElement($jk);

            DB::table('mst_gtk')->insert([
                'id' => Str::uuid(),
                'nama' => $faker->name($jenisKelamin == 'L' ? 'male' : 'female'),
                'nik' => $faker->nik(),
                'nip' => $faker->optional()->numerify('1975############'),
                'nuptk' => $faker->optional()->numerify('##########'),
                'tempat_lahir' => $faker->city(),
                'tgl_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'jenis_kelamin' => $jenisKelamin,
                'agama' => $faker->randomElement($agama),
                'status_kepegawaian' => $faker->randomElement($statusKepegawaian),
                'jenis_gtk' => $faker->randomElement($jenisGtkIds),
                'pend_terakhir' => $faker->randomElement($pendidikan),
                'status_keaktifan' => $faker->randomElement($statusKeaktifan),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
