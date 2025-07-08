<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index()
    {
        $title = 'Tentang Sispendik Bintuni';
        $subtitle = 'Tentang Sispendik Bintuni';

        return view('frontend.pages.kalender', compact(
            'title',
            'subtitle',
        ));
    }
}
