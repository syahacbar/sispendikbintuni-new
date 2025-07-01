<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PesertaDidik;

class SiswaController extends Controller
{
    public function index()
    {
        $siswa = PesertaDidik::with('sekolah')->get();

        return view('frontend.pages.siswa', compact('siswa'));
    }
}
