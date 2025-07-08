<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RombonganBelajarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sekolahList = DB::table('tbl_sekolahs')->select('id', 'jenjang')->get();
        $kurikulumId = DB::table('tbl_kurikulums')->value('id');

        if ($sekolahList->isEmpty() || !$kurikulumId) {
            $this->command->warn('Seeder Rombel gagal dijalankan. Pastikan tbl_sekolahs, tbl_ptks, dan tbl_kurikulums sudah memiliki data.');
            return;
        }

        $tingkatKelasMap = [
            'TK' => [1, 2],
            'KB' => [1],
            'TPA' => [1],
            'SPS' => [1],
            'PKBM' => [1, 2, 3],
            'SKB' => [1],
            'SD' => [1, 2, 3, 4, 5, 6],
            'SMP' => [7, 8, 9],
            'SMA' => [10, 11, 12],
            'SMK' => [10, 11, 12],
            'SLB' => [1, 2, 3, 4, 5, 6],
        ];

        $semester = '20251';

        foreach ($sekolahList as $sekolah) {
            $kelasList = $tingkatKelasMap[$sekolah->jenjang] ?? [1];

            // Ambil daftar PTK sesuai sekolah dan jenjang
            $ptkIds = DB::table('tbl_ptks')
                ->where('sekolah_id', $sekolah->id)
                ->where('jenjang', $sekolah->jenjang)
                ->pluck('id');

            if ($ptkIds->isEmpty()) {
                $this->command->warn("Tidak ada PTK untuk sekolah ID {$sekolah->id} dengan jenjang {$sekolah->jenjang}, rombel tidak dibuat.");
                continue;
            }

            foreach ($kelasList as $kelas) {
                for ($i = 1; $i <= 2; $i++) {
                    DB::table('tbl_rombongan_belajars')->insert([
                        'id' => Str::uuid(),
                        'sekolah_id' => $sekolah->id,
                        'wali_ptk_id' => $ptkIds->random(), // pilih acak wali dari daftar guru
                        'nama_rombel' => "{$sekolah->jenjang} {$kelas}.{$i}",
                        'tingkat_kelas' => $kelas,
                        'semester' => $semester,
                        'kurikulum_id' => $kurikulumId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
