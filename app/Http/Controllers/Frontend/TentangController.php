<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SysSetting;

class TentangController extends Controller
{
    public function index()
    {
        $title = 'Tentang Sispendik ';
        $subtitle = 'Sistem Informasi Pendidikan Kabupaten Teluk Bintuni.';

        $tentang = SysSetting::where('group', 'tentang')->get()->pluck('value', 'key');

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
            'tentang'
        ));
    }
}
