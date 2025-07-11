<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KalenderController extends Controller
{
    public function index()
    {
        $title = 'Kalender Pendidikan';
        $subtitle = 'Informasi jadwal penting sepanjang tahun ajaran.';

        return view('frontend.pages.kalender', compact(
            'title',
            'subtitle',
        ));
    }
}
