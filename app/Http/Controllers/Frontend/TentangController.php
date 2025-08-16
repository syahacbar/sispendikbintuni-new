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

        $tentang = SysSetting::where('group', 'tentang')->get();

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
            'tentang'
        ));
    }
}
