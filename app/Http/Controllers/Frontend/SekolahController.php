<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\MstSekolah;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolah = MstSekolah::orderBy('nama')->get();

        return view('frontend.pages.sekolah', compact('sekolah'));
    }

    public function show($slug)
    {
        $sekolah = MstSekolah::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_sekolah', compact('sekolah'));
    }
}
