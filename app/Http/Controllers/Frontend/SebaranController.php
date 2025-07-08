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
        $subtitle = 'Peta Sebaran Sekolah Se-Kabupaten Teluk Bintuni';

        $sekolah = Sekolah::select(
            'nama',
            'npsn',
            'jenjang',
            'status_sekolah',
            'alamat_jalan',
            'kode_wilayah',
            'lintang',
            'bujur'
        )
            ->whereNotNull('lintang')
            ->whereNotNull('bujur')
            ->get();

        return view('frontend.pages.sebaran', compact('title', 'subtitle', 'sekolah'));
    }
}
