<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExtBannerMobile;

class ExtBannerMobileSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'nama' => 'Pelatihan Sistem Informasi Sekolah',
                'deskripsi' => 'Tingkatkan kompetensi guru dan staf dalam mengelola data sekolah melalui sistem informasi digital.',
                'is_active' => true,
            ],
            [
                'nama' => 'Sosialisasi Dapodik Terbaru',
                'deskripsi' => 'Ikuti webinar nasional tentang pembaruan aplikasi Dapodik dan tata kelola data pendidikan.',
                'is_active' => true,
            ],
            [
                'nama' => 'Workshop Digitalisasi Data Siswa',
                'deskripsi' => 'Pelatihan intensif untuk operator sekolah dalam menginput dan memverifikasi data siswa.',
                'is_active' => false,
            ],
            [
                'nama' => 'Pengenalan Aplikasi e-Raport',
                'deskripsi' => 'Simulasi penggunaan aplikasi e-Raport versi terbaru bagi guru mata pelajaran.',
                'is_active' => true,
            ],
            [
                'nama' => 'Seminar Transformasi Digital Pendidikan',
                'deskripsi' => 'Diskusi panel tentang tren dan tantangan implementasi digitalisasi sekolah.',
                'is_active' => false,
            ],
        ];

        foreach ($banners as $data) {
            ExtBannerMobile::create($data);
        }
    }
}
