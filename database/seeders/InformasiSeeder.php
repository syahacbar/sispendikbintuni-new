<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Informasi;
use App\Models\Sekolah;

class InformasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahs = Sekolah::all();

        if ($sekolahs->isEmpty()) {
            $this->command->warn('Tidak ada data sekolah. Seeder tidak dijalankan.');
            return;
        }

        // Berita nasional (dari Kementerian Pendidikan)
        $beritaNasional = [
            'Kemendikbud Rilis Kurikulum Merdeka Resmi',
            'Ujian Nasional Ditiadakan Permanen',
            'Program Digitalisasi Sekolah di Seluruh Indonesia',
            'Beasiswa Indonesia Maju Resmi Dibuka',
            'Hari Pendidikan Nasional Diperingati Secara Virtual',
        ];

        foreach ($beritaNasional as $judul) {
            Informasi::create([
                'id' => Str::uuid(),
                'sekolah_id' => $sekolahs->random()->id,
                'judul' => $judul,
                'deskripsi' => fake()->paragraphs(3, true),
                'kategori' => 'Berita',
                'gambar' => 'assets/berita_nasional.jpg',
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'lihat' => rand(20, 300),
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }

        // Berita lokal (Bintuni)
        $beritaBintuni = [
            'Disdik Bintuni Luncurkan Program Guru Mengabdi',
            'Pelatihan Kurikulum Merdeka bagi Guru SD di Bintuni',
            'SMAN 1 Bintuni Wakili Papua Barat di Lomba Cerdas Cermat',
            'Sosialisasi Pendidikan Anti Perundungan di Bintuni',
            'Peringatan Hari Guru Nasional di Bintuni Berlangsung Meriah',
        ];

        foreach ($beritaBintuni as $judul) {
            Informasi::create([
                'id' => Str::uuid(),
                'sekolah_id' => $sekolahs->random()->id,
                'judul' => $judul,
                'deskripsi' => fake()->paragraphs(2, true),
                'kategori' => 'Berita',
                'gambar' => 'assets/berita_bintuni.jpg',
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'lihat' => rand(10, 150),
                'created_at' => now()->subDays(rand(1, 15)),
                'updated_at' => now(),
            ]);
        }

        // Kegiatan sekolah di Bintuni
        $kegiatan = [
            'Lomba Futsal Antar Sekolah Se-Bintuni',
            'Kegiatan Pramuka Bersama di Lapangan Utama',
            'Bakti Sosial Siswa SMK di Distrik Sumuri',
            'Pelatihan Kewirausahaan untuk Siswa SMA',
            'Workshop IT dan Robotik di Bintuni',
        ];

        foreach ($kegiatan as $judul) {
            Informasi::create([
                'id' => Str::uuid(),
                'sekolah_id' => $sekolahs->random()->id,
                'judul' => $judul,
                'deskripsi' => fake()->paragraphs(2, true),
                'kategori' => 'Kegiatan',
                'gambar' => 'assets/kegiatan_sekolah.jpg',
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'lihat' => rand(5, 100),
                'created_at' => now()->subDays(rand(1, 10)),
                'updated_at' => now(),
            ]);
        }

        // Pengumuman penting
        $pengumuman = [
            'Pengumuman Libur Semester Ganjil',
            'Pendaftaran Siswa Baru Telah Dibuka',
            'Pengambilan Rapor Dijadwalkan Minggu Depan',
            'Jadwal Ujian Akhir Semester Telah Dirilis',
            'Pengumuman Lomba Hari Kemerdekaan',
        ];

        foreach ($pengumuman as $judul) {
            Informasi::create([
                'id' => Str::uuid(),
                'sekolah_id' => $sekolahs->random()->id,
                'judul' => $judul,
                'deskripsi' => fake()->paragraph(),
                'kategori' => 'Pengumuman',
                'gambar' => 'assets/pengumuman.jpg',
                'slug' => Str::slug($judul) . '-' . Str::random(5),
                'lihat' => rand(10, 200),
                'created_at' => now()->subDays(rand(1, 7)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Seeder berhasil menambahkan data informasi relevan dengan konteks Bintuni dan nasional.');
    }
}
