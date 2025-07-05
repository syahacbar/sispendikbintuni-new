<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PesertaDidikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Ganti dengan ID sekolah yang valid dari tabel tbl_sekolahs
        $sekolahId = DB::table('tbl_sekolahs')->inRandomOrder()->value('id');

        for ($i = 0; $i < 1000; $i++) {
            DB::table('tbl_peserta_didiks')->insert([
                'id' => Str::uuid(),
                'sekolah_id' => $sekolahId,
                'nama' => $faker->name(),
                'nisn' => $faker->unique()->numerify('##########'),
                'nik' => $faker->unique()->numerify('####################'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'tgl_lahir' => $faker->date('Y-m-d', '-5 years'),
                'alamat_jalan' => $faker->streetAddress(),
                'desa_kelurahan' => $faker->citySuffix(),
                'kode_pos' => $faker->postcode(),
                'kecamatan' => $faker->city(),
                'kabupaten' => $faker->state(),
                'provinsi' => $faker->state(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
