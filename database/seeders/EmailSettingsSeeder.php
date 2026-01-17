<?php

namespace Database\Seeders;

use App\Models\SysSetting;
use Illuminate\Database\Seeder;

class EmailSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emailSettings = [
            // Email Verification Setting
            [
                'key' => 'email_verification_enabled',
                'value' => '1', // true by default
                'group' => 'email',
            ],

            // Default SMTP Settings (from .env if available)
            [
                'key' => 'mail_driver',
                'value' => env('MAIL_MAILER', 'smtp'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_host',
                'value' => env('MAIL_HOST', 'mail.smkn1manokwari.sch.id'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_port',
                'value' => env('MAIL_PORT', '587'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_username',
                'value' => env('MAIL_USERNAME', 'noreplay@smkn1manokwari.sch.id'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_password',
                'value' => env('MAIL_PASSWORD', ''),
                'group' => 'email',
            ],
            [
                'key' => 'mail_encryption',
                'value' => env('MAIL_ENCRYPTION', 'tls'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_from_address',
                'value' => env('MAIL_FROM_ADDRESS', 'noreplay@smkn1manokwari.sch.id'),
                'group' => 'email',
            ],
            [
                'key' => 'mail_from_name',
                'value' => env('MAIL_FROM_NAME', env('APP_NAME', 'SERASI BINTUNI')),
                'group' => 'email',
            ],
        ];

        foreach ($emailSettings as $setting) {
            SysSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'group' => $setting['group'],
                ]
            );
        }

        $this->command->info('✅ Default email settings telah di-seed dengan email verification ENABLED');
    }
}
