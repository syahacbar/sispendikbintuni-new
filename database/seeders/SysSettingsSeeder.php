<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SysSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sys_settings')->insert([
            [
                'group' => 'site',
                'key' => 'site_name',
                'value' => 'Sispendik Bintuni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'site_description',
                'value' => 'Sistem Informasi Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'site_tagline',
                'value' => 'Membangun Pendidikan Cerdas, Terhubung, dan Transparan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'welcome_text',
                'value' => 'Selamat Datang di',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'address',
                'value' => 'Jalan Trikora Wesiri, Kec. Bintuni, Kabupaten Teluk Bintuni, Provinsi Papua Barat,',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'postal_code',
                'value' => '98563',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'phone',
                'value' => '(0986)-25445',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'social_media',
                'key' => 'email',
                'value' => 'info@sispendikbintuni.go.id',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'social_media',
                'key' => 'youtube',
                'value' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'social_media',
                'key' => 'twitter',
                'value' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'social_media',
                'key' => 'facebook',
                'value' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'social_media',
                'key' => 'instagram',
                'value' => '-',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'group' => 'site',
                'key' => 'site_logo',
                'value' => '/storage/settings/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'api',
                'key' => 'api.google_maps_key',
                'value' => 'AIzaSyEXAMPLE123',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'smtp_host',
                'value' => 'smtp.mailtrap.io',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'smtp',
                'key' => 'smtp_port',
                'value' => '2525',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'contact',
                'key' => 'contact_email',
                'value' => 'support@example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'sambutan',
                'key' => 'judul_sambutan',
                'value' => 'Sambutan Kepala Dinas Pendidikan Kabupaten Teluk Bintuni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'sambutan',
                'key' => 'isi_sambutan',
                'value' => 'Assalamu’alaikum warahmatullahi wabarakatuh',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'group' => 'sambutan',
                'key' => 'sambutan_foto',
                'value' => '/storage/settings/logo.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Grup Tentang
            [
                'group' => 'tentang',
                'key' => 'tentang_page_title',
                'value' => 'Tentang Sispendik',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'tentang_page_subtitle',
                'value' => 'Sistem Informasi Pendidikan Kabupaten Teluk Bintuni.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'deskripsi_web',
                'value' => 'Sistem Informasi Pendidikan Kabupaten Teluk Bintuni (Sispendik Bintuni) merupakan platform digital yang dikembangkan untuk memberikan kemudahan dalam pengelolaan dan penyajian data pendidikan. Sistem ini menjadi wadah integrasi informasi dari satuan pendidikan, tenaga kependidikan, peserta didik, hingga sarana dan prasarana secara realtime dan akurat.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'visi',
                'value' => 'Menjadi sistem informasi pendidikan yang akurat, terintegrasi, dan transparan untuk mendukung peningkatan mutu pendidikan di Kabupaten Teluk Bintuni.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'misi',
                'value' => 'Menyediakan akses data pendidikan yang cepat dan mudah. Mendukung pengambilan kebijakan berbasis data. Mempermudah koordinasi antar instansi pendidikan. Meningkatkan partisipasi publik terhadap pendidikan melalui transparansi informasi.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'tujuan',
                'value' => 'Memberikan informasi yang valid dan terkini tentang kondisi pendidikan. Mendukung efisiensi dalam pengelolaan data pendidikan. Mendorong akuntabilitas dalam pelaksanaan program pendidikan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Grup Data Pendidikan
            [
                'group' => 'data_pendidikan',
                'key' => 'data_pendidikan_page_title',
                'value' => 'Data Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'data_pendidikan',
                'key' => 'data_pendidikan_page_subtitle',
                'value' => 'Rekapitulasi data pendidikan Berdasarkan Kecamatan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Grup Sebaran
            [
                'group' => 'sebaran',
                'key' => 'sebaran_page_title',
                'value' => 'Peta Sebaran Sekolah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'sebaran',
                'key' => 'sebaran_page_subtitle',
                'value' => 'Visualisasi lokasi sekolah di wilayah Kabupaten Teluk Bintuni.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Grup Kalender Pendidikan
            [
                'group' => 'kalender',
                'key' => 'kalender_page_title',
                'value' => 'Kalender Pendidikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'kalender',
                'key' => 'kalender_page_subtitle',
                'value' => 'Informasi jadwal penting sepanjang tahun ajaran.',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Grup Informasi
            [
                'group' => 'informasi',
                'key' => 'berita_page_title',
                'value' => 'Berita',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'informasi',
                'key' => 'berita_page_subtitle',
                'value' => 'Informasi terkini dan terpercaya.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'informasi',
                'key' => 'pengumuman_page_title',
                'value' => 'Pengumuman',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'informasi',
                'key' => 'pengumuman_page_subtitle',
                'value' => 'Pengumuman resmi dari dinas pendidikan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'informasi',
                'key' => 'kegiatan_page_title',
                'value' => 'Kegiatan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'informasi',
                'key' => 'kegiatan_page_subtitle',
                'value' => 'Dokumentasi berbagai kegiatan dan program.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Grup Pengaduan
            [
                'group' => 'pengaduan',
                'key' => 'pengaduan_page_title',
                'value' => 'Form Pengaduan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'pengaduan',
                'key' => 'pengaduan_page_subtitle',
                'value' => 'Setiap pengaduan akan ditindaklanjuti sesuai prosedur yang berlaku.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
