<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;


class PengaduanController extends Controller
{
    public function index()
    {
        $title = 'Form Pengaduan';
        $subtitle = 'Setiap pengaduan akan ditindaklanjuti sesuai prosedur yang berlaku.';

        return view('frontend.pages.pengaduan', compact('title', 'subtitle'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_laporan' => 'required|string|max:255',
            'nama_pelapor' => 'required|string|max:100',
            'email' => 'required|email',
            'no_hp' => 'required|string|max:20',
            'kategori' => 'required|string',
            'isi' => 'required|string',
            'dok_lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx|max:2048',
        ]);

        if ($request->hasFile('dok_lampiran')) {
            $validated['dok_lampiran'] = $request->file('dok_lampiran')->store('pengaduan_lampiran', 'public');
        }

        $pengaduan = Pengaduan::create($validated);

        $tahunBulan = now()->format('Ym');

        $countInThisMonth = Pengaduan::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $urutan = str_pad($countInThisMonth, 5, '0', STR_PAD_LEFT);

        $nomorLaporan = "LP/{$tahunBulan}/{$urutan}";

        $pengaduan->update([
            'nomor_laporan' => $nomorLaporan,
        ]);

        return back()->with([
            'success' => 'Pengaduan berhasil dikirim!',
            'nomor_laporan' => $nomorLaporan,
        ]);
    }

    public function lacakForm()
    {
        $title = 'Lacak Pengaduan';
        $subtitle = 'Cek Status Laporan dan detail perkembangan penanganannya.';


        return view('frontend.pages.lacak_pengaduan', compact('title', 'subtitle'));
    }

    public function lacak(Request $request)
    {
        $title = 'Berita';
        $subtitle = 'Berita';

        $request->validate([
            'cek_laporan' => 'required|string',
        ]);

        $data = Pengaduan::where('nomor_laporan', $request->cek_laporan)->first();

        if (!$data) {
            return back()->withErrors(['cek_laporan' => 'Nomor laporan tidak ditemukan.'])->withInput();
        }

        return view('frontend.pages.lacak_pengaduan', compact('data', 'title', 'subtitle'));
    }
}
