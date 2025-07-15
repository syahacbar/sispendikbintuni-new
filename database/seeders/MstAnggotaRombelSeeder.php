<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory;

class MstAnggotaRombelSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('id_ID');

        $rombelIds = DB::table('mst_rombel')->pluck('id')->toArray();
        $pesertaIds = DB::table('mst_peserta_didik')->pluck('id')->toArray();
        $semesterIds = DB::table('ref_semester')->pluck('id')->toArray();

        if (empty($rombelIds) || empty($pesertaIds) || empty($semesterIds)) {
            echo "⚠️ Data referensi belum tersedia (rombel/peserta_didik/semester).\n";
            return;
        }

        $anggota = [];
        $usedPeserta = [];

        foreach ($rombelIds as $rombelId) {
            // Ambil 20–35 siswa unik untuk tiap rombel
            $jumlah = rand(20, 35);
            $siswaDipilih = array_diff($pesertaIds, $usedPeserta);
            $siswaDipilih = collect($siswaDipilih)->shuffle()->take($jumlah)->values()->all();

            foreach ($siswaDipilih as $siswaId) {
                $usedPeserta[] = $siswaId;

                $tanggalMasuk = $faker->dateTimeBetween('-1 years', '-3 months');
                $tanggalKeluar = $faker->boolean(10) ? $faker->dateTimeBetween('-2 months', 'now') : null;

                $anggota[] = [
                    'id' => Str::uuid(),
                    'rombel_id' => $rombelId,
                    'peserta_didik_id' => $siswaId,
                    'status_keaktifan' => true,
                    'tanggal_masuk' => $tanggalMasuk->format('Y-m-d'),
                    'tanggal_keluar' => $tanggalKeluar?->format('Y-m-d'),
                    'keterangan' => $faker->optional()->sentence(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('mst_anggota_rombel')->insert($anggota);
        echo "✅ Seeder mst_anggota_rombel berhasil dijalankan (" . count($anggota) . " data).\n";
    }
}
