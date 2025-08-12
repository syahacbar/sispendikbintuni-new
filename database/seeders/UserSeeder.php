<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MstSekolah;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        $super = User::updateOrCreate(
            ['email' => 'superadmin@sispendikbintuni.cloud'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );
        $super->assignRole('super_admin');

        // Admin Dinas
        $dinas = User::updateOrCreate(
            ['email' => 'admindinas@sispendikbintuni.cloud'],
            [
                'name' => 'Admin Dinas',
                'password' => Hash::make('password'),
            ]
        );
        $dinas->assignRole('admin_dinas');

        // Daftar NPSN untuk Admin Sekolah
        $npsns = [
            '60403663',
            '60401962',
            '60401955',
            '60401950',
            '60401956',
            '60401954',
            '60401938',
            '60401880',
            '60401899',
            '60401900',
        ];

        foreach ($npsns as $index => $npsn) {
            $sekolah = MstSekolah::where('npsn', $npsn)->first();

            if ($sekolah) {
                $email = $npsn . '@sispendikbintuni.cloud';

                $user = User::updateOrCreate(
                    ['email' => $email],
                    [
                        'name' => 'Admin Sekolah ' . $sekolah->nama,
                        'password' => Hash::make('password'),
                    ]
                );

                $user->assignRole('admin_sekolah');

                // Hubungkan user ke sekolah
                $sekolah->update([
                    'users_id' => $user->id,
                ]);
            }
        }
    }
}
