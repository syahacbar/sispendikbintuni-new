<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MstSekolah;
use App\Models\SysSetting;

class SebaranController extends Controller
{
    public function index()
    {
        $title = 'Peta Sebaran Sekolah';
        $subtitle = 'Visualisasi lokasi sekolah di wilayah Kabupaten Teluk Bintuni.';


        $sekolah = MstSekolah::select(
            'nama',
            'npsn',
            'kode_jenjang',
            'status',
            'latitude',
            'longitude'
        )
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
