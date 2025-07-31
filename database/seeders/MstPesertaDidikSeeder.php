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

        // Ambil semua kode wilayah kelurahan (12 digit)
        $kodeWilayahList = DB::table('ref_wilayah')
            ->where('kode', 'LIKE', '__.__.__.____')
            ->pluck('kode')
            ->toArray();

        if (empty($kodeWilayahList)) {
            echo "⚠️ Tidak ditemukan kode wilayah 12 digit di tabel ref_wilayah.\n";
            return;
        }

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
                $alamat = substr($faker->address(), 0, 255);
                $kodeWilayah = $faker->randomElement($kodeWilayahList);
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

        echo "✅ $total data peserta didik berhasil dimasukkan menggunakan kode wilayah 12 digit.\n";
    }
}
