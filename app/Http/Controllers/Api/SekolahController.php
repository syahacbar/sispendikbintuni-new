<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function byDistrik($kode_wilayah)
    {
        if (strlen($kode_wilayah) != 8 || !str_starts_with($kode_wilayah, '92.06')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Kode wilayah tidak valid'
            ], 400);
        }

        // Key cache unik per distrik
        $cacheKey = 'sekolah_distrik_' . $kode_wilayah;

        $data = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($kode_wilayah) {
            $sekolahList = DB::table('tbl_sekolahs')
                ->where('kode_wilayah', $kode_wilayah)
                ->select('id', 'nama', 'npsn', 'jenjang', 'status_sekolah', 'latitude', 'longitude')
                ->orderBy('jenjang')
                ->orderBy('nama')
                ->get();

            return $sekolahList->map(function ($sekolah) {
                $jumlahPesertaDidik = DB::table('tbl_peserta_didiks')
                    ->where('sekolah_id', $sekolah->id)
                    ->count();

                $jumlahRombel = DB::table('tbl_rombongan_belajars')
                    ->where('sekolah_id', $sekolah->id)
                    ->count();

                $jumlahGuru = DB::table('tbl_ptks')
                    ->where('sekolah_id', $sekolah->id)
                    ->count();

                return [
                    'sekolah_id' => $sekolah->id,
                    'nama' => $sekolah->nama,
                    'npsn' => $sekolah->npsn,
                    'jenjang' => $sekolah->jenjang,
                    'status_sekolah' => $sekolah->status_sekolah,
                    'latitude' => $sekolah->latitude,
                    'longitude' => $sekolah->longitude,
                    'peserta_didik' => $jumlahPesertaDidik,
                    'rombel' => $jumlahRombel,
                    'guru' => $jumlahGuru,
                ];
            });
        });

        return response()->json([
            'status' => 'success',
            'total' => $data->count(),
            'data' => $data
        ]);
    }

    public function detail($id)
    {
        // Ambil data sekolah
        $sekolah = DB::table('tbl_sekolahs')
            ->where('id', $id)
            ->first();

        if (!$sekolah) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sekolah tidak ditemukan'
            ], 404);
        }

        // Hitung total terkait
        $jumlahPesertaDidik = DB::table('tbl_peserta_didiks')
            ->where('sekolah_id', $id)
            ->count();

        $jumlahRombel = DB::table('tbl_rombongan_belajars')
            ->where('sekolah_id', $id)
            ->count();

        $jumlahGuru = DB::table('tbl_ptks')
            ->where('sekolah_id', $id)
            ->count();

        return response()->json([
            'status' => 'success',
            'data' => [
                'sekolah_id' => $sekolah->id,
                'npsn' => $sekolah->npsn,
                'nama' => $sekolah->nama,
                'jenjang' => $sekolah->jenjang,
                'status_sekolah' => $sekolah->status_sekolah,

                'total_peserta_didik' => $jumlahPesertaDidik,
                'total_rombel' => $jumlahRombel,
                'total_guru' => $jumlahGuru,
            ]
        ]);
    }
}
