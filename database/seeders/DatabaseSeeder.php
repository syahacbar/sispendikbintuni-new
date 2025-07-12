<?php

namespace Database\Seeders;

use App\Models\JenisSarpras;
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
            SekolahSeeder::class,
            PtkSeeder::class,
            PesertaDidikSeeder::class,
            RombonganBelajarSeeder::class,
            AnggotaRombelSeeder::class,
            RegistrasiPesertaDidikSeeder::class,
            MataPelajaranSeeder::class,
            RombelMapelSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionSeeder::class,
            InformasiSeeder::class,
            JenisSarprasSeeder::class,
            KelompokMapelSeeder::class,
            KelompokMapelSeeder::class,
            PengaduanSeeder::class,
            PengaturanAPISeeder::class,
            PengaturanEmailSeeder::class,
            PengaturanUmumSeeder::class,
            TentangSeeder::class,
            //WilayahSeeder::class,
            KalenderSeeder::class,
        ]);
    }
}
