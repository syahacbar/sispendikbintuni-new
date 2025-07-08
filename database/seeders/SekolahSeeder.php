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
                'npsn' => '1010000001',
                'nama' => 'SD Negeri Harapan Bangsa',
                'jenjang' => 'SD',
                'alamat_jalan' => 'Jl. Merdeka No.1',
                'desa_kelurahan' => 'Kelurahan A',
                'kode_pos' => '98211',
                'kecamatan' => 'Kecamatan Barat',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'email' => 'sdharapan@example.com',
                'telepon' => '0987123456',
                'kepemilikan' => null,
                'sk_pendirian' => 'SK-001/2020',
                'tanggal_sk_pendirian' => Carbon::parse('2020-01-10'),
                'sk_izin_operasional' => null,
                'tanggal_sk_izin_operasional' => null,
                'lintang' => null,
                'bujur' => null,
                'slug' => 'sd-negeri-harapan-bangsa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'kurikulum_id' => $kurikulumIds->random(),
                'npsn' => '1010000002',
                'nama' => 'SMP Negeri Cemerlang',
                'jenjang' => 'SMP',
                'alamat_jalan' => 'Jl. Pendidikan No.2',
                'desa_kelurahan' => 'Kelurahan B',
                'kode_pos' => '98212',
                'kecamatan' => 'Kecamatan Timur',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'B',
                'email' => 'smpcemerlang@example.com',
                'telepon' => '0987123457',
                'kepemilikan' => null,
                'sk_pendirian' => 'SK-002/2019',
                'tanggal_sk_pendirian' => Carbon::parse('2019-03-15'),
                'sk_izin_operasional' => null,
                'tanggal_sk_izin_operasional' => null,
                'lintang' => null,
                'bujur' => null,
                'slug' => 'smp-negeri-cemerlang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tbl_sekolahs')->insert($data);
        $this->command->info(count($data) . ' data sekolah berhasil di-seed.');
    }
}
