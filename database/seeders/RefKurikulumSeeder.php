<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RefKurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kurikulums = [
            [
                'kode' => 'DIKNAS',
                'nama' => 'Kurikulum Nasional 1994',
                'deskripsi' => 'Kurikulum nasional sebelum diberlakukannya KBK dan KTSP.',
                'tahun_mulai' => 1994,
                'status' => 'Tidak Aktif',
            ],
            [
                'kode' => 'KBK',
                'nama' => 'Kurikulum Berbasis Kompetensi (KBK)',
                'deskripsi' => 'Kurikulum transisi sebelum KTSP yang mulai dikenalkan pada awal 2000-an.',
                'tahun_mulai' => 2004,
                'status' => 'Tidak Aktif',
            ],
            [
                'kode' => 'PAKEM',
                'nama' => 'Pembelajaran Aktif, Kreatif, Efektif, Menyenangkan (PAKEM)',
                'deskripsi' => 'Pendekatan pembelajaran sebelum KTSP, sering dipadukan dalam pelatihan guru.',
                'tahun_mulai' => 2003,
                'status' => 'Tidak Aktif',
            ],
            [
                'kode' => 'KTSP',
                'nama' => 'Kurikulum Tingkat Satuan Pendidikan (KTSP)',
                'deskripsi' => 'Kurikulum yang mulai diberlakukan sejak tahun 2006 dengan keleluasaan sekolah menyusun silabus.',
                'tahun_mulai' => 2006,
                'status' => 'Tidak Aktif',
            ],
            [
                'kode' => 'K13',
                'nama' => 'Kurikulum 2013',
                'deskripsi' => 'Kurikulum nasional yang menekankan pada kompetensi inti dan sikap, pengetahuan, serta keterampilan.',
                'tahun_mulai' => 2013,
                'status' => 'Tidak Aktif',
            ],
            [
                'kode' => 'K13R',
                'nama' => 'Kurikulum 2013 Revisi',
                'deskripsi' => 'Revisi Kurikulum 2013 yang menyempurnakan struktur dan penilaian pembelajaran.',
                'tahun_mulai' => 2016,
                'status' => 'Aktif',
            ],
            [
                'kode' => 'KMB',
                'nama' => 'Kurikulum Merdeka',
                'deskripsi' => 'Kurikulum baru yang fleksibel, fokus pada kompetensi dan diferensiasi peserta didik.',
                'tahun_mulai' => 2022,
                'status' => 'Aktif',
            ],
        ];

        foreach ($kurikulums as $kurikulum) {
            DB::table('ref_kurikulum')->insert([
                'id' => Str::uuid(),
                'kode' => $kurikulum['kode'],
                'nama' => $kurikulum['nama'],
                'deskripsi' => $kurikulum['deskripsi'],
                'tahun_mulai' => $kurikulum['tahun_mulai'],
                'status' => $kurikulum['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
