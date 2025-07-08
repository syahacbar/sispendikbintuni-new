<?php

// namespace Database\Seeders;

// use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;
// use Carbon\Carbon;
// use Faker\Factory as Faker;

// class PtkSeeder extends Seeder
// {
//     public function run(): void
//     {
//         $faker = Faker::create('id_ID');

//         $sekolahIds = DB::table('tbl_sekolahs')->pluck('id');

//         if ($sekolahIds->isEmpty()) {
//             $this->command->warn('Tidak ada data sekolah. Seeder PTK dilewati.');
//             return;
//         }

//         $namaDepan = ['Ahmad', 'Budi', 'Candra', 'Dewi', 'Eka', 'Fitri', 'Gilang', 'Hari', 'Indah', 'Joko', 'Kiki', 'Linda', 'Mega', 'Nina', 'Oki', 'Putri', 'Qori', 'Rudi', 'Sari', 'Tomi'];
//         $namaBelakang = ['Saputra', 'Wahyuni', 'Santoso', 'Lestari', 'Pratama', 'Rahmawati', 'Anggraini', 'Purnama', 'Hidayat', 'Siregar'];
//         $statusList = ['PNS', 'Honorer', 'GTY'];
//         $jenjangOptions = ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMK', 'SMA', 'SLB'];
//         $kualifikasiOptions = ['D3', 'S1', 'S2', 'S3'];

//         $data = [];

//         for ($i = 1; $i <= 1000; $i++) {
//             $isFemale = rand(0, 1) === 1;
//             $jenisKelamin = $isFemale ? 'P' : 'L';

//             $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];

//             $data[] = [
//                 'id' => (string) Str::uuid(),
//                 'sekolah_id' => $sekolahIds->random(),
//                 'nama' => $nama,
//                 'nuptk' => 'NUPTK' . str_pad($i, 6, '0', STR_PAD_LEFT),
//                 'nik' => str_pad((string)rand(1000000000000000, 9999999999999999), 16, '0', STR_PAD_LEFT),
//                 'jenis_kelamin' => $jenisKelamin,
//                 'status' => $statusList[array_rand($statusList)],
//                 'tgl_lahir' => Carbon::now()->subYears(rand(25, 60))->subDays(rand(0, 365))->format('Y-m-d'),
//                 'jenjang' => $faker->randomElement($jenjangOptions),
//                 'kualifikasi' => $faker->randomElement($kualifikasiOptions),
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ];
//         }

//         DB::table('tbl_ptks')->insert($data);
//         $this->command->info('100 data PTK berhasil di-seed.');
//     }
// }

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PtkSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID'); // Bahasa Indonesia

        $sekolahList = DB::table('tbl_sekolahs')->select('id', 'jenjang')->get();

        foreach ($sekolahList as $sekolah) {
            for ($i = 1; $i <= 3; $i++) {
                DB::table('tbl_ptks')->insert([
                    'id' => Str::uuid(),
                    'sekolah_id' => $sekolah->id,
                    'nama' => $faker->name,
                    'nuptk' => $faker->unique()->numerify('##########'),
                    'nik' => $faker->unique()->numerify('################'),
                    'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                    'status' => $faker->randomElement(['PNS', 'Honorer', 'GTY']),
                    'tgl_lahir' => $faker->date('Y-m-d', '-25 years'),
                    'jenjang' => $sekolah->jenjang,
                    'kualifikasi' => $faker->randomElement(['SMA', 'S1', 'S2', 'D3']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
