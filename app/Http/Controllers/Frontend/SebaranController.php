<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;

class SebaranController extends Controller
{
    public function index()
    {
        $title = 'Peta Sebaran Sekolah';
        $subtitle = 'Visualisasi lokasi sekolah di wilayah Kabupaten Teluk Bintuni.';


        $sekolah = Sekolah::select(
            'nama',
            'npsn',
            'jenjang',
            'status_sekolah',
            'latitude',
            'longitude'
        )
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return view('frontend.pages.sebaran', compact('title', 'subtitle', 'sekolah'));
    }
}
