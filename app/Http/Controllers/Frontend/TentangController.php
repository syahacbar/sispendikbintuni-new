<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\SysSetting;

class TentangController extends Controller
{
    public function index()
    {
        $title = 'Tentang';
        $subtitle = 'Tata Kelola Pendidikan Dengan Sistem Perencanaan Terintegrasi (SERASI) Kabupaten Teluk Bintuni';

        $pengaturan = SysSetting::pluck('value', 'key');

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
            'pengaturan'
        ));
    }
}
