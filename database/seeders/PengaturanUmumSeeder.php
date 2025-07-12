<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PengaturanUmumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'judul_sambutan' => 'Sambutan Kepala Dinas Pendidikan Kabupaten Teluk Bintuni',
            'isi_sambutan' => '<p>Assalamu’alaikum warahmatullahi wabarakatuh,<br>Salam sejahtera bagi kita semua,<br>Om Swastyastu, Namo Buddhaya, Salam Kebajikan.</p><p>Puji dan syukur kita panjatkan ke hadirat Tuhan Yang Maha Esa, karena atas rahmat dan karunia-Nya, kita dapat terus melanjutkan upaya bersama dalam membangun dunia pendidikan di Kabupaten Teluk Bintuni tercinta ini.</p><p>Pendidikan merupakan fondasi utama dalam membentuk generasi yang cerdas, berakhlak mulia, serta mampu bersaing di era global. Sebagai Kepala Dinas Pendidikan Kabupaten Teluk Bintuni, saya menyampaikan apresiasi yang setinggi-tingginya kepada seluruh pemangku kepentingan – baik para pendidik, tenaga kependidikan, peserta didik, orang tua, maupun masyarakat luas – yang selama ini telah berperan aktif dalam mendukung kemajuan pendidikan di daerah kita.</p><p>Pemerintah Kabupaten Teluk Bintuni melalui Dinas Pendidikan terus berkomitmen untuk meningkatkan kualitas layanan pendidikan, pemerataan akses, serta penguatan karakter peserta didik. Program-program strategis seperti peningkatan kompetensi guru, digitalisasi sekolah, pembangunan sarana prasarana pendidikan, dan pemberdayaan sekolah berbasis masyarakat menjadi fokus utama dalam mendukung visi dan misi pembangunan daerah di bidang pendidikan.</p><p>Kami menyadari bahwa tantangan ke depan tidaklah ringan. Oleh karena itu, kolaborasi dan sinergi dari semua pihak sangat diperlukan. Mari kita terus bergandengan tangan untuk menciptakan ekosistem pendidikan yang inklusif, berkualitas, dan berkelanjutan.</p><p>Akhir kata, saya mengajak seluruh elemen masyarakat untuk terus menjaga semangat belajar, berinovasi, dan berkontribusi demi terwujudnya generasi Teluk Bintuni yang unggul dan berdaya saing tinggi.</p><p>Terima kasih.<br>Wassalamu’alaikum warahmatullahi wabarakatuh.<br>Salam sejahtera bagi kita semua.</p><p><br></p><p><strong>Kepala Dinas Pendidikan Kabupaten Teluk Bintuni<br>Dr. Angling Dharma, S.Hut., S.Jati.</strong></p>',
            'gambar_kadin' => 'assets/01JZWAVE3CXPVGAJ9MFGJGKVVG.png',
            'slogan' => 'Membangun Pendidikan Cerdas, Terhubung, dan Transparan',
            'hak_cipta' => '© 2025 - Sistem Informasi Pendidikan Kabupaten Teluk Bintuni',
            'teks_selamat_datang' => 'Selamat Datang di',
            'alamat_lengkap' => 'Jalan Trikora Wesiri, Kec. Bintuni, Kabupaten Teluk Bintuni, Provinsi Papua Barat',
            'facebook' => 'https://www.facebook.com/',
            'email' => 'info@sispendikbintuni.go.id',
            'instagram' => 'https://www.instagram.com/',
            'youtube' => 'https://www.youtube.com/',
            'twitter' => 'https://www.twitter.com/',
            'logo' => '01JZZ7D66YH6NK149EKCBY31Z1.png',
            'favicon' => '01JZZ7D674646TW2WD1Z3WR210.png',
            'nama_instansi' => 'Kabupaten Teluk Bintuni',
            'judul' => 'Sipendik Bintuni',
            'deskripsi' => 'Sistem Informasi Pendidikan',
            'kode_pos' => '98563',
            'no_hp' => '62184544454',
            'telepon' => '(0986)-25445',
        ];

        foreach ($data as $key => $value) {
            DB::table('tbl_pengaturan_umums')->updateOrInsert(
                ['key' => $key],
                [
                    'id' => Str::uuid(),
                    'value' => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
