<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PtkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID sekolah
        $sekolahIds = DB::table('tbl_sekolahs')->pluck('id');

        if ($sekolahIds->isEmpty()) {
            $this->command->warn('Tidak ada data sekolah. Seeder PTK dilewati.');
            return;
        }

        $namaDepan = ['Ahmad', 'Budi', 'Candra', 'Dewi', 'Eka', 'Fitri', 'Gilang', 'Hari', 'Indah', 'Joko', 'Kiki', 'Linda', 'Mega', 'Nina', 'Oki', 'Putri', 'Qori', 'Rudi', 'Sari', 'Tomi'];
        $namaBelakang = ['Saputra', 'Wahyuni', 'Santoso', 'Lestari', 'Pratama', 'Rahmawati', 'Anggraini', 'Purnama', 'Hidayat', 'Siregar'];
        $statusList = ['PNS', 'Honorer', 'GTY'];

        $data = [];

        for ($i = 1; $i <= 100; $i++) {
            $isFemale = rand(0, 1) === 1;
            $jenisKelamin = $isFemale ? 'P' : 'L';

            $nama = $namaDepan[array_rand($namaDepan)] . ' ' . $namaBelakang[array_rand($namaBelakang)];

            $data[] = [
                'id' => (string) Str::uuid(),
                'sekolah_id' => $sekolahIds->random(),
                'nama' => $nama,
                'nuptk' => 'NUPTK' . str_pad($i, 6, '0', STR_PAD_LEFT), // max 20 char
                'nik' => str_pad((string)rand(1000000000000000, 9999999999999999), 16, '0', STR_PAD_LEFT), // max 20 char
                'jenis_kelamin' => $jenisKelamin,
                'status' => $statusList[array_rand($statusList)],
                'tgl_lahir' => Carbon::now()->subYears(rand(25, 60))->subDays(rand(0, 365))->format('Y-m-d'),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('tbl_ptks')->insert($data);
        $this->command->info('100 data PTK berhasil di-seed.');
    }
}
