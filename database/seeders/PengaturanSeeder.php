<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengaturanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            ['key' => 'title', 'value' => 'Sispendik Bintuni'],
            ['key' => 'tagline', 'value' => 'Sistem Informasi Pendidikan'],
            ['key' => 'light_color', 'value' => '#020617'],
            ['key' => 'logo', 'value' => '01JR5EKV0E1691Z5VK2RQHT6ZC.svg'],
            ['key' => 'favicon', 'value' => '01JR331RF1M9S9RFTC6S35KHDZ.svg'],
            ['key' => 'footer', 'value' => 'Sispendik Bintuni | All rights reserved. | '],
            ['key' => 'created_by', 'value' => 'Arasoft Digital Media'],
            ['key' => 'google_client_id', 'value' => '710778939365-cnpnbt45n52r5thhcb7vk7j5flks5u3f.apps.googleusercontent.com'],
            ['key' => 'google_client_secret', 'value' => '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'],
            ['key' => 'google_redirect_uri', 'value' => 'http://localhost:8000/auth/google/callback'],
            ['key' => 'recaptcha_site_key', 'value' => '6Lfggx8rAAAAADFqtO_kFlNj4FRMep2GXYW0OJ8H'],
            ['key' => 'recaptcha_secret_key', 'value' => '6Lfggx8rAAAAAP5aqT6AmQzU8FisqtDAM2Zj4Ngp'],
            ['key' => 'microsoft_client_id', 'value' => '0b5cc2c4-60dd-4bcb-ad4f-e8caab7cbf03'],
            ['key' => 'microsoft_client_secret', 'value' => 'Wzm8Q~EKH-BwijKjUOYgreqGZGffo6RLjeSMebXI'],
            ['key' => 'microsoft_redirect_uri', 'value' => 'http://localhost:8000/auth/microsoft/callback'],
            ['key' => 'name', 'value' => 'Forum Mailer'],
            ['key' => 'email', 'value' => 'noreply@forum.test'],
            ['key' => 'driver', 'value' => 'smtp'],
            ['key' => 'secret_key', 'value' => 'sk_test_dummykey123456'],
            ['key' => 'domain', 'value' => 'mg.forum.test'],
            ['key' => 'region', 'value' => 'us-east-1'],
            ['key' => 'host', 'value' => 'smtp.mailgun.org'],
            ['key' => 'port', 'value' => '587'],
            ['key' => 'encryption', 'value' => 'tls'],
            ['key' => 'username', 'value' => 'smtp-user'],
            ['key' => 'password', 'value' => 'supersecretpassword'],
            ['key' => 'status', 'value' => '1'],
            ['key' => 'zenziva_userkey', 'value' => 'abc123xyz'],
            ['key' => 'zenziva_passkey', 'value' => 'secretpassword'],
            ['key' => 'zenziva_sender', 'value' => 'ZENZIVA_SMS'],
            ['key' => 'google_maps_api_key', 'value' => 'AIzaSyBjh8gPTMxhsaeTmsxtzxvEhFvVKCcWUFg'],
            ['key' => 'firebase_server_key', 'value' => 'AIzaSyBjh8gPTMxhsae'],
            ['key' => 'firebase_project_id', 'value' => 'TmsxtzxvEhFvVKCcWUFg'],
        ];

        foreach ($data as $item) {
            DB::table('tbl_pengaturans')->insert([
                'id' => Str::uuid(),
                'key' => $item['key'],
                'value' => $item['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
