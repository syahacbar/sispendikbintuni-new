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
        $faker = Factory::create('id_ID'); // Lokal Indonesia
        $agamaList = ['Islam', 'Kristen', 'Hindu', 'Buddha', 'Konghucu'];
        $jkList = ['L', 'P'];

        // Untuk efisiensi, masukkan dalam batch
        $batchSize = 1000;
        $total = 20000;

        for ($i = 0; $i < $total / $batchSize; $i++) {
            $batchData = [];

            for ($j = 0; $j < $batchSize; $j++) {
                $jenisKelamin = $faker->randomElement($jkList);

                $batchData[] = [
                    'id' => Str::uuid(),
                    'nama' => $faker->name($jenisKelamin === 'L' ? 'male' : 'female'),
                    'nisn' => $faker->unique()->numerify('############'),
                    'nik' => $faker->numerify('3276##############'),
                    'tempat_lahir' => $faker->city(),
                    'tgl_lahir' => $faker->date('Y-m-d', '-6 years'),
                    'jenis_kelamin' => $jenisKelamin,
                    'agama' => $faker->randomElement($agamaList),
                    'alamat' => $faker->address(),
                    'kode_wilayah' => $faker->numerify('92.06.##.####'),
                    'kode_pos' => $faker->postcode(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('mst_peserta_didik')->insert($batchData);
            echo "Batch " . ($i + 1) . " inserted.\n";
        }

        echo "✅ 20.000 data peserta didik berhasil di-generate.\n";
    }
}
