<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Informasi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InformasiController extends Controller
{

    public function berita()
    {
        $title = 'Berita';
        $subtitle = 'Informasi terkini dan terpercaya.';


        $berita = Informasi::where('kategori', 'Berita')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.berita', compact('berita', 'title', 'subtitle'));
    }

    public function pengumuman()
    {
        $title = 'Pengumuman';
        $subtitle = 'Pengumuman resmi dari dinas pendidikan.';


        $pengumuman = Informasi::where('kategori', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.pengumuman', compact('pengumuman', 'title', 'subtitle'));
    }

    public function kegiatan()
    {
        $title = 'Kegiatan';
        $subtitle = 'Dokumentasi berbagai kegiatan dan program.';


        $kegiatan = Informasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.pages.kegiatan', compact('kegiatan', 'title', 'subtitle'));
    }


    public function show_berita($slug)
    {
        $title = 'Berita';
        $subtitle = 'Berita';

        $berita = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_berita', compact('berita', 'title', 'subtitle'));
    }



    public function show_pengumuman($slug)
    {
        $title = 'Berita';
        $subtitle = 'Berita';
        $pengumuman = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_pengumuman', compact('pengumuman', 'title', 'subtitle'));
    }

    public function show_kegiatan($slug)
    {
        $title = 'Berita';
        $subtitle = 'Berita';
        $kegiatan = Informasi::where('slug', $slug)->firstOrFail();

        return view('frontend.pages.detail_kegiatan', compact('kegiatan', 'title', 'subtitle'));
    }

    public function getByDate(Request $request)
    {
        $title = 'Berita';
        $subtitle = 'Berita';
        $date = $request->get('date');

        $kegiatan = Informasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.pages.kegiatan-list', compact('kegiatan', 'title', 'subtitle'));
    }
}
