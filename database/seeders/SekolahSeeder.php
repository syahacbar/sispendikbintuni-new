<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil ID kurikulum (gunakan random atau default jika kosong)
        $kurikulumIds = DB::table('tbl_kurikulums')->pluck('id');
        if ($kurikulumIds->isEmpty()) {
            $this->command->error('Tidak ada data pada tabel tbl_kurikulums.');
            return;
        }

        $data = [
            [
                'id' => (string) Str::uuid(),
                'kurikulum_id' => $kurikulumIds->random(),
                'npsn' => '60725756',
                'nama' => 'TK NEGERI HERLINA I',
                'jenjang' => 'TK',
                'status_sekolah' => 'Negeri',
                'kode_wilayah' => '92.06.01',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ];

        DB::table('tbl_sekolahs')->insert($data);
        $this->command->info(count($data) . ' data sekolah berhasil di-seed.');
    }
}
