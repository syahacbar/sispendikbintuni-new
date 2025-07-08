<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Sekolah;

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

        $sekolah = User::updateOrCreate([
            'email' => 'adminsekolah@example.com',
        ], [
            'name' => 'Admin Sekolah',
            'password' => Hash::make('password'),
        ]);
        $dinas->assignRole('admin_sekolah');

        // // Admin Sekolah
        // $sekolahTarget = Sekolah::where('nama', 'SD Negeri Harapan Bangsa')->first();

        // if ($sekolahTarget) {
        //     $sekolah = User::updateOrCreate([
        //         'email' => 'adminsekolah@example.com',
        //     ], [
        //         'name' => 'Admin Sekolah',
        //         'password' => Hash::make('password'),
        //         'sekolah_id' => $sekolahTarget->id,
        //     ]);
        //     $sekolah->assignRole('admin_sekolah');
        // }
    }
}
