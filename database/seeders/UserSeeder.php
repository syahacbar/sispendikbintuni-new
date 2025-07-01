<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $super = User::updateOrCreate([
            'email' => 'superadmin@example.com',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
        ]);
        $super->assignRole('super_admin');

        // Admin Dinas
        $dinas = User::updateOrCreate([
            'email' => 'admindinas@example.com',
        ], [
            'name' => 'Admin Dinas',
            'password' => Hash::make('password'),
        ]);
        $dinas->assignRole('admin_dinas');

        // Admin Sekolah
        $sekolah = User::updateOrCreate([
            'email' => 'adminsekolah@example.com',
        ], [
            'name' => 'Admin Sekolah',
            'password' => Hash::make('password'),
        ]);
        $sekolah->assignRole('admin_sekolah');
    }
}
