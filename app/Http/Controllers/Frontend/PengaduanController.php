<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExtPengaduan;

class PengaduanController extends Controller
{
    public function index()
    {
        $title = 'Form Pengaduan';
        $subtitle = 'Saluran Resmi Penyampaian Aspirasi, Saran, Keluhan dan Laporan Terkait Layanan Pendidikan di Kab. Teluk Bintuni';

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

        $pengaduan = ExtPengaduan::create($validated);

        $tahunBulan = now()->format('Ym');

        $countInThisMonth = ExtPengaduan::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();

        $urutan = str_pad($countInThisMonth, 5, '0', STR_PAD_LEFT);

        $nomorLaporan = "LP/{$tahunBulan}/{$urutan}";

        $pengaduan->update([
            'nomor_laporan' => $nomorLaporan,
        ]);

        return back()->with([
            'success' => 'Pengaduan berhasil dikirim!',
        ]);
    }
}
