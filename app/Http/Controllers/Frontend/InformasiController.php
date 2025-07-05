<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Informasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformasiController extends Controller
{

    public function berita()
    {
        $berita = Informasi::where('kategori', 'Berita')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.berita', compact('berita'));
    }

    public function pengumuman()
    {
        $pengumuman = Informasi::where('kategori', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.pengumuman', compact('pengumuman'));
    }

    public function kegiatan()
    {
        $kegiatan = Informasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.kegiatan', compact('kegiatan'));
    }


    public function show_berita($slug)
    {
        $berita = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_berita', compact('berita'));
    }



    public function show_pengumuman($slug)
    {
        $pengumuman = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_pengumuman', compact('pengumuman'));
    }

    public function show_kegiatan($slug)
    {
        $kegiatan = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_kegiatan', compact('kegiatan'));
    }

    public function getByDate(Request $request)
    {
        $date = $request->get('date');

        $kegiatan = Informasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.pages.kegiatan-list', compact('kegiatan'));
    }
}
