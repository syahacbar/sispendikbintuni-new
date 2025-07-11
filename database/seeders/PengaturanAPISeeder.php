<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengaturanAPISeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            ['key' => 'google_client_id', 'value' => 'firebase_server_key'],
            ['key' => 'google_client_secret', 'value' => 'firebase_server_key'],
            ['key' => 'google_redirect_uri', 'value' => 'firebase_server_key'],
            ['key' => 'recaptcha_site_key', 'value' => 'firebase_server_key'],
            ['key' => 'recaptcha_secret_key', 'value' => 'firebase_server_key'],
            ['key' => 'microsoft_client_id', 'value' => 'firebase_server_key'],
            ['key' => 'microsoft_client_secret', 'value' => 'firebase_server_key'],
            ['key' => 'microsoft_redirect_uri', 'value' => 'hfirebase_server_key'],
            ['key' => 'zenziva_userkey', 'value' => 'abc123xyz'],
            ['key' => 'zenziva_passkey', 'value' => 'secretpassword'],
            ['key' => 'zenziva_sender', 'value' => 'ZENZIVA_SMS'],
            ['key' => 'google_maps_api_key', 'value' => 'firebase_server_key'],
            ['key' => 'firebase_server_key', 'value' => 'firebase_server_key'],
            ['key' => 'firebase_project_id', 'value' => 'firebase_server_key'],

        ];

        foreach ($data as $item) {
            DB::table('tbl_pengaturan_apis')->insert([
                'id' => Str::uuid(),
                'key' => $item['key'],
                'value' => $item['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
