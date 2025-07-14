<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefSarprasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $items = [
            // Prasarana
            ['nama' => 'Ruang Kelas', 'kategori' => 'Prasarana'],
            ['nama' => 'Ruang Guru', 'kategori' => 'Prasarana'],
            ['nama' => 'Laboratorium IPA', 'kategori' => 'Prasarana'],
            ['nama' => 'Laboratorium Komputer', 'kategori' => 'Prasarana'],
            ['nama' => 'Perpustakaan', 'kategori' => 'Prasarana'],
            ['nama' => 'WC Siswa', 'kategori' => 'Prasarana'],
            ['nama' => 'WC Guru', 'kategori' => 'Prasarana'],
            ['nama' => 'Kantor Kepala Sekolah', 'kategori' => 'Prasarana'],
            ['nama' => 'Ruang UKS', 'kategori' => 'Prasarana'],
            ['nama' => 'Lapangan Olahraga', 'kategori' => 'Prasarana'],
            ['nama' => 'Gudang', 'kategori' => 'Prasarana'],
            ['nama' => 'Ruang Ibadah', 'kategori' => 'Prasarana'],
            ['nama' => 'Tempat Parkir', 'kategori' => 'Prasarana'],
            ['nama' => 'Ruang Tata Usaha', 'kategori' => 'Prasarana'],
            ['nama' => 'Laboratorium Bahasa', 'kategori' => 'Prasarana'],

            // Sarana
            ['nama' => 'Meja Siswa', 'kategori' => 'Sarana'],
            ['nama' => 'Kursi Siswa', 'kategori' => 'Sarana'],
            ['nama' => 'Meja Guru', 'kategori' => 'Sarana'],
            ['nama' => 'Kursi Guru', 'kategori' => 'Sarana'],
            ['nama' => 'Papan Tulis', 'kategori' => 'Sarana'],
            ['nama' => 'Komputer', 'kategori' => 'Sarana'],
            ['nama' => 'Proyektor', 'kategori' => 'Sarana'],
            ['nama' => 'Lemari', 'kategori' => 'Sarana'],
            ['nama' => 'Alat Laboratorium IPA', 'kategori' => 'Sarana'],
            ['nama' => 'Alat Laboratorium Komputer', 'kategori' => 'Sarana'],
            ['nama' => 'Buku Teks', 'kategori' => 'Sarana'],
            ['nama' => 'Buku Referensi', 'kategori' => 'Sarana'],
            ['nama' => 'Alat Musik', 'kategori' => 'Sarana'],
            ['nama' => 'Bola Sepak', 'kategori' => 'Sarana'],
            ['nama' => 'Net Voli', 'kategori' => 'Sarana'],
            ['nama' => 'Alat Kebersihan', 'kategori' => 'Sarana'],
            ['nama' => 'Printer', 'kategori' => 'Sarana'],
        ];

        foreach ($items as $item) {
            DB::table('ref_sarpras')->insert([
                'id'         => Str::uuid(),
                'nama'       => $item['nama'],
                'kategori'   => $item['kategori'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
