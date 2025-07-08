<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TentangController extends Controller
{
    public function index()
    {
        $title = 'Tentang Sispendik Bintuni';
        $subtitle = 'Tentang Sispendik Bintuni';

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
        ));
    }
}
