<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PTK;

class PTKController extends Controller
{
    public function index()
    {
        // $ptk = PTK::orderBy('nik')->get();
        $ptk = PTK::with('sekolah')->get();

        return view('frontend.pages.ptk', compact('ptk'));
    }
}
