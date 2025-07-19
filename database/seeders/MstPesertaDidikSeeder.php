<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class MstPesertaDidikSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');
        $agamaList = ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu'];
        $jkList = ['L', 'P'];

        $batchSize = 100;
        $total = 20000;

        for ($i = 0; $i < $total / $batchSize; $i++) {
            $batchData = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jenisKelamin = $faker->randomElement($jkList);
                $nama = substr($faker->name($jenisKelamin === 'L' ? 'male' : 'female'), 0, 100);
                $nisn = $faker->unique()->numerify('##########'); // 10 digit
                $nik = $faker->numerify('3276############'); // 16 digit
                $tempatLahir = substr($faker->city(), 0, 100);
                $alamat = substr($faker->address(), 0, 255); // cukup untuk text
                $kodeWilayah = substr($faker->numerify('92.06.##.####'), 0, 100);
                $kodePos = substr($faker->postcode(), 0, 10);

                $batchData[] = [
                    'id' => Str::uuid(),
                    'nama' => $nama,
                    'nisn' => $nisn,
                    'nik' => $nik,
                    'tempat_lahir' => $tempatLahir,
                    'tgl_lahir' => $faker->date('Y-m-d', '-6 years'),
                    'jenis_kelamin' => $jenisKelamin,
                    'agama' => $faker->randomElement($agamaList),
                    'alamat' => $alamat,
                    'kode_wilayah' => $kodeWilayah,
                    'kode_pos' => $kodePos,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('mst_peserta_didik')->insert($batchData);
            echo "Batch " . ($i + 1) . " inserted.\n";
        }

        echo "✅ 1000 data peserta didik berhasil dimasukkan sesuai panjang kolom.\n";
    }
}
