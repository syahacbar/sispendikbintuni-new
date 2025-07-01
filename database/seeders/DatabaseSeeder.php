<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            KurikulumSeeder::class,
            PtkSeeder::class,
            PesertaDidikSeeder::class,
            RombonganBelajarSeeder::class,
            AnggotaRombelSeeder::class,
            RegistrasiPesertaDidikSeeder::class,
            PrasaranaSeeder::class,
            SaranaSeeder::class,
            MataPelajaranSeeder::class,
            RombelMapelSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class
        ]);
    }
}
