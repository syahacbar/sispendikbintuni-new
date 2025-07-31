<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class ExtInformasiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $informasiList = [
            [
                'judul' => 'Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran 2025/2026',
                'kategori' => 'Pengumuman',
                'deskripsi' => 'Pendaftaran peserta didik baru dibuka mulai tanggal 1 Juni 2025 sampai dengan 30 Juni 2025. Calon siswa diharapkan membawa berkas lengkap seperti fotokopi KK, akta kelahiran, dan rapor terakhir. Informasi selengkapnya dapat dilihat di papan pengumuman atau website resmi sekolah.',
            ],
            [
                'judul' => 'Upacara Peringatan Hari Pendidikan Nasional',
                'kategori' => 'Kegiatan',
                'deskripsi' => 'Sekolah akan mengadakan upacara peringatan Hari Pendidikan Nasional pada tanggal 2 Mei 2025 di halaman sekolah. Siswa diharapkan memakai seragam lengkap dan hadir tepat waktu. Kegiatan ini akan diisi dengan pidato kepala sekolah dan penampilan seni siswa.',
            ],
            [
                'judul' => 'Workshop Digitalisasi Pembelajaran bagi Guru',
                'kategori' => 'Berita',
                'deskripsi' => 'Sebanyak 50 guru dari berbagai jenjang mengikuti workshop digitalisasi pembelajaran yang diselenggarakan oleh Dinas Pendidikan. Workshop ini membahas penggunaan platform pembelajaran online dan strategi pengajaran interaktif berbasis teknologi.',
            ],
            [
                'judul' => 'Kegiatan Pramuka Lintas Sekolah',
                'kategori' => 'Kegiatan',
                'deskripsi' => 'Kegiatan pramuka gabungan antar sekolah diadakan pada tanggal 10 Agustus 2025 di Bumi Perkemahan Cibubur. Kegiatan ini bertujuan untuk melatih kemandirian, kepemimpinan, dan kekompakan antar peserta pramuka.',
            ],
            [
                'judul' => 'Pengumuman Kelulusan Siswa Kelas XII',
                'kategori' => 'Pengumuman',
                'deskripsi' => 'Hasil kelulusan siswa kelas XII diumumkan secara daring melalui website sekolah pada tanggal 3 Mei 2025 pukul 10.00 WIB. Siswa diimbau untuk tidak melakukan konvoi atau aksi coret-coret sebagai bentuk perayaan.',
            ],
            [
                'judul' => 'Simulasi Ujian Sekolah Berbasis Komputer',
                'kategori' => 'Kegiatan',
                'deskripsi' => 'Simulasi USBK akan dilaksanakan mulai tanggal 15 Februari 2025 untuk memastikan kesiapan teknis dan mental siswa. Semua peserta diwajibkan membawa kartu ujian dan hadir minimal 30 menit sebelum ujian dimulai.',
            ],
            [
                'judul' => 'Kegiatan MPLS untuk Siswa Baru',
                'kategori' => 'Kegiatan',
                'deskripsi' => 'Masa Pengenalan Lingkungan Sekolah (MPLS) akan dilaksanakan selama 3 hari mulai 15 Juli 2025. Siswa baru akan dikenalkan dengan lingkungan sekolah, tata tertib, guru, serta kegiatan ekstrakurikuler.',
            ],
            [
                'judul' => 'Pengumuman Libur Akhir Semester',
                'kategori' => 'Pengumuman',
                'deskripsi' => 'Libur akhir semester ganjil dimulai pada tanggal 20 Desember 2025 hingga 3 Januari 2026. Siswa diharapkan tetap menjaga kesehatan dan mengisi waktu liburan dengan kegiatan positif.',
            ],
            [
                'judul' => 'Pelatihan Kurikulum Merdeka',
                'kategori' => 'Berita',
                'deskripsi' => 'Sekolah menyelenggarakan pelatihan internal bagi guru untuk mendalami implementasi Kurikulum Merdeka. Pelatihan ini difokuskan pada metode pembelajaran berbasis proyek dan asesmen formatif.',
            ],
            [
                'judul' => 'Pentas Seni dan Budaya Sekolah',
                'kategori' => 'Kegiatan',
                'deskripsi' => 'Pentas seni tahunan akan menampilkan pertunjukan dari berbagai kelas seperti tari tradisional, drama, dan musik. Acara ini dilaksanakan pada 18 November 2025 di aula sekolah dan terbuka untuk umum.',
            ],
        ];

        $data = [];

        foreach (range(1, 50) as $i) {
            $item = $faker->randomElement($informasiList);

            $data[] = [
                'id' => Str::uuid(),
                'judul' => $item['judul'],
                'deskripsi' => $item['deskripsi'],
                'kategori' => $item['kategori'],
                'gambar' => $faker->imageUrl(640, 480, 'education', true, $item['kategori']),
                'slug' => Str::slug($item['judul']) . '-' . Str::random(5),
                'lihat' => $faker->numberBetween(100, 1000),
                // 'users_id' => null,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => now(),
            ];
        }

        DB::table('ext_informasi')->insert($data);

        echo "✅ Seeder ext_informasi berhasil dijalankan (50 data real pendidikan Indonesia).\n";
    }
}
