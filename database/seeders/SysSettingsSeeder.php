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
                'value' => 'Sistem Perencanaan Terintegrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'site_description',
                'value' => 'Tata Kelola Pendidikan Dengan Sistem Perencanaan Terintegrasi (SERASI) Kabupaten Teluk Bintuni',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'site_tagline',
                'value' => ' ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'site',
                'key' => 'welcome_text',
                'value' => 'Selamat Datang di Website',
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
                'value' => 'info@SERASIbintuni.go.id',
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
                'value' => '',
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
                'value' => '<p>Puji syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, Kepala Dinas Pendidikan, Kebudayaan, Pemuda dan Olahraga Kabupaten Teluk Bintuni dapat meluncurkan website <em>"Tata Kelola Pendidikan dengan Sistem Perencanaan Terintegrasi"</em> ini.</p><p>Peluncuran sistem ini merupakan langkah strategis dalam mewujudkan tata kelola pendidikan yang lebih transparan, akuntabel, serta berorientasi pada data dan kebutuhan riil di lapangan. Kami menyadari bahwa kualitas pendidikan yang merata dan berkeadilan hanya dapat dicapai melalui perencanaan yang tepat, terukur, dan melibatkan semua pemangku kepentingan.</p><p>Melalui platform ini, kami berharap proses perencanaan, penganggaran, pelaksanaan, hingga evaluasi program pendidikan dapat berjalan lebih efektif dan efisien. Selain itu, sistem ini juga menjadi bentuk komitmen kami dalam meningkatkan mutu layanan pendidikan di Kabupaten Teluk Bintuni.</p><p>Kami mengajak seluruh jajaran satuan pendidikan, pengelola data, tenaga pendidik, serta masyarakat untuk bersama-sama memanfaatkan sistem ini dengan sebaik-baiknya. Semoga inovasi ini dapat menjadi salah satu pondasi penting dalam membangun generasi Teluk Bintuni yang cerdas, berkarakter, dan berdaya saing.</p><p>Terima kasih.</p><p>Kepala Dinas Pendidikan, Kebudayaan, Pemuda dan Olahraga Kabupaten Teluk Bintuni<br><strong>Dr. Henry Donald Kapuangan, S.Pd., MM.</strong></p>',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'group' => 'sambutan',
                'key' => 'sambutan_foto',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            // Grup Tentang
            [
                'group' => 'tentang',
                'key' => 'tentang_page_title',
                'value' => 'Tentang SERASI',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'tentang_page_subtitle',
                'value' => 'Sistem Perencanaan Terintegrasi Kabupaten Teluk Bintuni.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'deskripsi_web',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'visi',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'misi',
                'value' => '',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'group' => 'tentang',
                'key' => 'tujuan',
                'value' => '',
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
