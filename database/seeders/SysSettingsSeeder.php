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
                'value' => 'Assalamu’alaikum warahmatullahi wabarakatuh,
Salam sejahtera bagi kita semua,
Om Swastyastu, Namo Buddhaya, Salam Kebajikan.

Puji dan syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, kita dapat terus melanjutkan upaya bersama dalam membangun dunia pendidikan di Kabupaten Teluk Bintuni tercinta ini.

Pendidikan merupakan fondasi utama dalam membentuk generasi yang cerdas, berakhlak mulia, serta mampu bersaing di era global. Sebagai Kepala Dinas Pendidikan Kabupaten Teluk Bintuni, saya menyampaikan apresiasi yang setinggi-tingginya kepada seluruh pemangku kepentingan – baik para pendidik, tenaga kependidikan, peserta didik, orang tua, maupun masyarakat luas – yang selama ini telah berperan aktif dalam mendukung kemajuan pendidikan di daerah kita.

Pemerintah Kabupaten Teluk Bintuni melalui Dinas Pendidikan terus berkomitmen untuk meningkatkan kualitas layanan pendidikan, pemerataan akses, serta penguatan karakter peserta didik. Program-program strategis seperti peningkatan kompetensi guru, digitalisasi sekolah, pembangunan sarana prasarana pendidikan, dan pemberdayaan sekolah berbasis masyarakat menjadi fokus utama dalam mendukung visi dan misi pembangunan daerah di bidang pendidikan.

Kami menyadari bahwa tantangan ke depan tidaklah ringan. Oleh karena itu, kolaborasi dan sinergi dari semua pihak sangat diperlukan. Mari kita terus bergandengan tangan untuk menciptakan ekosistem pendidikan yang inklusif, berkualitas, dan berkelanjutan.

Akhir kata, saya mengajak seluruh elemen masyarakat untuk terus menjaga semangat belajar, berinovasi, dan berkontribusi demi terwujudnya generasi Teluk Bintuni yang unggul dan berdaya saing tinggi.

Terima kasih.
Wassalamu’alaikum warahmatullahi wabarakatuh.
Salam sejahtera bagi kita semua.



Kepala Dinas Pendidikan Kabupaten Teluk Bintuni
Dr. Angling Dharma, S.Hut., S.Jati.',
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
        ]);
    }
}
