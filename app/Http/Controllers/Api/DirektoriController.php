<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;

class DirektoriController extends Controller
{
    public function distrik()
    {
        // Ambil wilayah yang punya sekolah (distinct kode)
        $distrik = Wilayah::whereIn('kode', function ($query) {
            $query->select('kode_wilayah')->from('tbl_sekolahs');
        })
            ->select('kode', 'nama')
            ->orderBy('nama')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $distrik
        ]);
    }
}

//tes auto deploy ini cuma iseng2 saja
