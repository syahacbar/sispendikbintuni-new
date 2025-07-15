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
                'value' => 'My Awesome Website',
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
        ]);
    }
}
