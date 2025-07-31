<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MstSekolah;

class SebaranController extends Controller
{
    public function index()
    {
        $title = 'Peta Sebaran Sekolah';
        $subtitle = 'Visualisasi lokasi sekolah di wilayah Kabupaten Teluk Bintuni.';

        $sekolah = MstSekolah::with(['rombonganBelajars.kurikulum'])
            ->select('id', 'nama', 'npsn', 'kode_jenjang', 'status', 'latitude', 'longitude')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('frontend.pages.sebaran', compact(
            'title',
            'subtitle',
            'sekolah'
        ));
    }
}
