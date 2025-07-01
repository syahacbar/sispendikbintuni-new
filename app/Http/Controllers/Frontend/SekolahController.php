<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::orderBy('nama')->get();

        return view('frontend.pages.sekolah', compact('sekolah'));
    }

    public function show($slug)
    {
        $sekolah = Sekolah::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_sekolah', compact('sekolah'));
    }
}
