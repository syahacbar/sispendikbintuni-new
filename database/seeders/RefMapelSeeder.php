<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RefMapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapels = [
            ['kode' => '100001', 'nama' => 'Pendidikan Agama Islam'],
            ['kode' => '100002', 'nama' => 'Pendidikan Agama Kristen'],
            ['kode' => '100003', 'nama' => 'Pendidikan Agama Katolik'],
            ['kode' => '100004', 'nama' => 'Pendidikan Agama Hindu'],
            ['kode' => '100005', 'nama' => 'Pendidikan Agama Buddha'],
            ['kode' => '100006', 'nama' => 'Pendidikan Agama Khonghucu'],
            ['kode' => '200001', 'nama' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['kode' => '200002', 'nama' => 'Bahasa Indonesia'],
            ['kode' => '200003', 'nama' => 'Matematika'],
            ['kode' => '200004', 'nama' => 'Ilmu Pengetahuan Alam (IPA)'],
            ['kode' => '200005', 'nama' => 'Ilmu Pengetahuan Sosial (IPS)'],
            ['kode' => '200006', 'nama' => 'Bahasa Inggris'],
            ['kode' => '200007', 'nama' => 'Seni Budaya'],
            ['kode' => '200008', 'nama' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['kode' => '200009', 'nama' => 'Prakarya dan Kewirausahaan'],
            ['kode' => '300001', 'nama' => 'Fisika'],
            ['kode' => '300002', 'nama' => 'Kimia'],
            ['kode' => '300003', 'nama' => 'Biologi'],
            ['kode' => '300004', 'nama' => 'Ekonomi'],
            ['kode' => '300005', 'nama' => 'Geografi'],
            ['kode' => '300006', 'nama' => 'Sosiologi'],
            ['kode' => '400001', 'nama' => 'Bahasa Daerah'],
            ['kode' => '400002', 'nama' => 'Muatan Lokal'],
            ['kode' => '500001', 'nama' => 'Produk Kreatif dan Kewirausahaan'],
            ['kode' => '500002', 'nama' => 'Simulasi Digital'],
            ['kode' => '500003', 'nama' => 'Dasar-dasar Kejuruan'],
            ['kode' => '500004', 'nama' => 'Pemrograman Dasar'],
            ['kode' => '500005', 'nama' => 'Teknologi Layanan Jaringan'],
            ['kode' => '500006', 'nama' => 'Basis Data'],
            ['kode' => '500007', 'nama' => 'Desain Multimedia'],
            ['kode' => '500008', 'nama' => 'Administrasi Sistem Jaringan'],
            ['kode' => '500009', 'nama' => 'Pemrograman Web dan Perangkat Bergerak'],
        ];

        foreach ($mapels as $mapel) {
            DB::table('ref_mapel')->insert([
                'id' => Str::uuid(),
                'kode' => $mapel['kode'],
                'nama' => $mapel['nama'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
