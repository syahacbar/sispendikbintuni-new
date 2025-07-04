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
        $data = [
            [
                'id' => (string) Str::uuid(),
                'npsn' => '1010000001',
                'nama' => 'SD Negeri Harapan Bangsa',
                'jenjang' => 'SD',
                'alamat_jalan' => 'Jl. Merdeka No.1',
                'desa_kelurahan' => 'Kelurahan A',
                'kode_pos' => '98211',
                'kecamatan' => 'Kecamatan Barat',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'kode_wilayah' => '920100',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'A',
                'email' => 'sdharapan@example.com',
                'telepon' => '0987123456',
                'sk_pendirian' => 'SK-001/2020',
                'tanggal_sk_pendirian' => Carbon::parse('2020-01-10'),
                'slug' => 'sd-negeri-harapan-bangsa',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'npsn' => '1010000002',
                'nama' => 'SMP Negeri Cemerlang',
                'jenjang' => 'SMP',
                'alamat_jalan' => 'Jl. Pendidikan No.2',
                'desa_kelurahan' => 'Kelurahan B',
                'kode_pos' => '98212',
                'kecamatan' => 'Kecamatan Timur',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'kode_wilayah' => '920101',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'B',
                'email' => 'smpcemerlang@example.com',
                'telepon' => '0987123457',
                'sk_pendirian' => 'SK-002/2019',
                'tanggal_sk_pendirian' => Carbon::parse('2019-03-15'),
                'slug' => 'smp-negeri-cemerlang',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'npsn' => '1010000003',
                'nama' => 'SMA Swasta Nusantara',
                'jenjang' => 'SMA',
                'alamat_jalan' => 'Jl. Nusantara No.3',
                'desa_kelurahan' => 'Kelurahan C',
                'kode_pos' => '98213',
                'kecamatan' => 'Kecamatan Utara',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'kode_wilayah' => '920102',
                'status_sekolah' => 'Swasta',
                'akreditasi' => 'A',
                'email' => 'smanusantara@example.com',
                'telepon' => '0987123458',
                'sk_pendirian' => 'SK-003/2018',
                'tanggal_sk_pendirian' => Carbon::parse('2018-06-20'),
                'slug' => 'sma-swasta-nusantara',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'npsn' => '1010000004',
                'nama' => 'SMK Negeri 1 Teknologi',
                'jenjang' => 'SMK',
                'alamat_jalan' => 'Jl. Teknologi No.4',
                'desa_kelurahan' => 'Kelurahan D',
                'kode_pos' => '98214',
                'kecamatan' => 'Kecamatan Selatan',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'kode_wilayah' => '920103',
                'status_sekolah' => 'Negeri',
                'akreditasi' => 'B',
                'email' => 'smkteknologi@example.com',
                'telepon' => '0987123459',
                'sk_pendirian' => 'SK-004/2017',
                'tanggal_sk_pendirian' => Carbon::parse('2017-09-25'),
                'slug' => 'smk-negeri-1-teknologi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'npsn' => '1010000005',
                'nama' => 'MI Swasta Al-Falah',
                'jenjang' => 'MI',
                'alamat_jalan' => 'Jl. Pesantren No.5',
                'desa_kelurahan' => 'Kelurahan E',
                'kode_pos' => '98215',
                'kecamatan' => 'Kecamatan Tengah',
                'kabupaten' => 'Kabupaten Teluk Bintuni',
                'provinsi' => 'Papua Barat',
                'kode_wilayah' => '920104',
                'status_sekolah' => 'Swasta',
                'akreditasi' => 'C',
                'email' => 'mialfalah@example.com',
                'telepon' => '0987123460',
                'sk_pendirian' => 'SK-005/2016',
                'tanggal_sk_pendirian' => Carbon::parse('2016-11-30'),
                'slug' => 'mi-swasta-al-falah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('tbl_sekolahs')->insert($data);

        $this->command->info('5 data sekolah berhasil di-seed.');
    }
}
