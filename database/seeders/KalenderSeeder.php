<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KalenderSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            // --- LIBUR NASIONAL DAN HARI RAYA ---
            ['Tahun Baru Masehi', 'Libur Tahun Baru 2025', '2025-01-01', '2025-01-01'],
            ['Tahun Baru Imlek 2576', 'Hari Raya Imlek 2025', '2025-01-29', '2025-01-29'],
            ['Isra Mikraj Nabi Muhammad SAW', 'Isra Mikraj 1446 H', '2025-02-27', '2025-02-27'],
            ['Hari Raya Nyepi', 'Tahun Baru Saka 1947', '2025-03-29', '2025-03-29'],
            ['Wafat Isa Almasih', 'Jumat Agung', '2025-04-18', '2025-04-18'],
            ['Idul Fitri 1446 H', 'Hari Raya Idul Fitri', '2025-03-31', '2025-04-01'],
            ['Hari Buruh Nasional', 'Hari Buruh Internasional', '2025-05-01', '2025-05-01'],
            ['Kenaikan Isa Almasih', 'Kenaikan Yesus Kristus', '2025-05-29', '2025-05-29'],
            ['Hari Lahir Pancasila', 'Memperingati Lahirnya Pancasila', '2025-06-01', '2025-06-01'],
            ['Idul Adha 1446 H', 'Hari Raya Kurban', '2025-06-07', '2025-06-07'],
            ['Tahun Baru Islam 1447 H', '1 Muharram 1447 H', '2025-06-26', '2025-06-26'],
            ['Hari Kemerdekaan RI', 'HUT RI ke-80', '2025-08-17', '2025-08-17'],
            ['Maulid Nabi Muhammad SAW', 'Peringatan Maulid Nabi', '2025-09-05', '2025-09-05'],
            ['Hari Natal', 'Hari Raya Natal', '2025-12-25', '2025-12-25'],

            // --- KALENDER PENDIDIKAN UMUM 2025/2026 ---
            ['Awal Tahun Pelajaran', 'Hari pertama masuk sekolah tahun ajaran 2025/2026', '2025-07-14', '2025-07-14'],
            ['Masa Pengenalan Lingkungan Sekolah (MPLS)', 'Orientasi siswa baru selama 3 hari', '2025-07-14', '2025-07-16'],
            ['Penilaian Tengah Semester (PTS) Ganjil', 'Ujian tengah semester ganjil', '2025-09-22', '2025-09-27'],
            ['Penilaian Akhir Semester (PAS) Ganjil', 'Ujian akhir semester ganjil', '2025-12-01', '2025-12-06'],
            ['Libur Semester Ganjil', 'Libur semester ganjil 2025/2026', '2025-12-20', '2026-01-04'],
            ['Masuk Semester Genap', 'Awal semester genap 2025/2026', '2026-01-06', '2026-01-06'],
            ['Penilaian Tengah Semester (PTS) Genap', 'Ujian tengah semester genap', '2026-03-16', '2026-03-21'],
            ['Penilaian Akhir Tahun (PAT)', 'Ujian akhir tahun pelajaran', '2026-06-01', '2026-06-06'],
            ['Libur Akhir Tahun Pelajaran', 'Libur akhir tahun ajaran 2025/2026', '2026-06-15', '2026-07-12'],
        ];

        foreach ($events as [$nama, $deskripsi, $tglMulai, $tglAkhir]) {
            DB::table('tbl_kalenders')->insert([
                'id' => Str::uuid(),
                'nama' => $nama,
                'tanggal_mulai' => $tglMulai,
                'tanggal_akhir' => $tglAkhir,
                'waktu' => false,
                'deskripsi' => $deskripsi,
                'jam_mulai' => null,
                'jam_akhir' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
