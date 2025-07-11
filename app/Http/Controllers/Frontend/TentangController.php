<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Tentang;

class TentangController extends Controller
{
    public function index()
    {
        $title = 'Tentang Sispendik ';
        $subtitle = 'Sistem Informasi Pendidikan Kabupaten Teluk Bintuni.';

        $tentangData = Tentang::pluck('value', 'key')->toArray();

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
            'tentangData'
        ));
    }
}
