<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PengaturanEmailSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
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
        ];

        foreach ($data as $item) {
            DB::table('tbl_pengaturan_emails')->insert([
                'id' => Str::uuid(),
                'key' => $item['key'],
                'value' => $item['value'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
