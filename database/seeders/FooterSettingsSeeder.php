<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SysSetting;

class FooterSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Set default footer mode to classic for backward compatibility
        SysSetting::setValue('footer_mode', 'classic');

        // Set default footer columns
        SysSetting::setValue('footer_columns', 3);

        // Set default footer background color
        SysSetting::setValue('footer_bg_color', '#212529');

        // Widget Area 1 - Disabled (description moved to left branding area)
        $widget1 = [
            'enabled' => false,
            'title' => 'Tentang Kami',
            'type' => 'custom_text',
            'content' => '<p>SERASI adalah sistem informasi pendidikan yang menyediakan data dan informasi pendidikan di Kabupaten Teluk Bintuni.</p>',
        ];
        SysSetting::setValue('footer_widget_1', json_encode($widget1));

        // Create sample widget configurations for Widget Area 2 (Quick Links / Navigation)
        $widget2 = [
            'enabled' => true,
            'title' => 'Link Cepat',
            'type' => 'navigation',
            'links' => [
                ['label' => 'Beranda', 'url' => '/'],
                ['label' => 'Tentang', 'url' => '/tentang'],
                ['label' => 'Sekolah', 'url' => '/sekolah'],
                ['label' => 'Sebaran Sekolah', 'url' => '/sebaran'],
                ['label' => 'Kalender', 'url' => '/kalender'],
            ],
        ];
        SysSetting::setValue('footer_widget_2', json_encode($widget2));

        // Create sample widget configurations for Widget Area 3 (Contact Info)
        $widget3 = [
            'enabled' => true,
            'title' => 'Kontak Kami',
            'type' => 'contact',
            'address' => 'Jl. Contoh No. 123, Kabupaten Teluk Bintuni',
            'phone' => '0812-3456-7890',
            'email' => 'info@serasi-bintuni.go.id',
        ];
        SysSetting::setValue('footer_widget_3', json_encode($widget3));

        // Create sample widget configurations for Widget Area 4 (Social Media)
        $widget4 = [
            'enabled' => true,
            'title' => 'Ikuti Kami',
            'type' => 'social_media',
            'platforms' => [
                ['platform' => 'facebook', 'url' => 'https://facebook.com/example'],
                ['platform' => 'instagram', 'url' => 'https://instagram.com/example'],
                ['platform' => 'youtube', 'url' => 'https://youtube.com/@example'],
                ['platform' => 'twitter', 'url' => 'https://twitter.com/example'],
            ],
        ];
        SysSetting::setValue('footer_widget_4', json_encode($widget4));

        $this->command->info('Footer settings seeded successfully!');
    }
}
