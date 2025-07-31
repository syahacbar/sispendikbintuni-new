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

            WilayahSeeder::class,
            RefSarprasSeeder::class,
            RefMapelSeeder::class,
            RefJenisGtkSeeder::class,
            RefJenjangPendidikanSeeder::class,
            RefKurikulumSeeder::class,
            RefSemesterSeeder::class,

            MstSekolahSeeder::class,
            MstGtkSeeder::class,
            MstPesertaDidikSeeder::class,
            MstRombelSeeder::class,
            MstSarprasSekolahSeeder::class,

            ExtPengaduanSeeder::class,
            ExtInformasiSeeder::class,
            ExtKalenderSeeder::class,
            MstPembelajaranSeeder::class,
            MstAnggotaRombelSeeder::class,

            SysSettingsSeeder::class,
            MstKondisiSarprasSeeder::class,
            RoleSeeder::class,
        ]);
    }
}
