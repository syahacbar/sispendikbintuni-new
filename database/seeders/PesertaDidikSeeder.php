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

        // Ambil semua ID sekolah
        $sekolahIds = DB::table('tbl_sekolahs')->pluck('id');
        $rombongan_belajar_id = DB::table('tbl_rombongan_belajars')->pluck('id');

        for ($i = 0; $i < 12000; $i++) {
            DB::table('tbl_peserta_didiks')->insert([
                'id' => Str::uuid(),
                'sekolah_id' => $faker->randomElement($sekolahIds),
                'nama' => $faker->name(),
                'nisn' => $faker->unique()->numerify('##########'),
                'nik' => $faker->unique()->numerify('####################'),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'tgl_lahir' => $faker->date('Y-m-d', '-5 years'),
                'rombongan_belajar_id' => $faker->randomElement($rombongan_belajar_id),
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
