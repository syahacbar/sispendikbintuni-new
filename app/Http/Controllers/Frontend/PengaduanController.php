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
        $recaptcha_pengaduan_enabled = \App\Models\SysSetting::getValue('recaptcha_pengaduan_enabled', false);
        $recaptcha_site_key = \App\Models\SysSetting::getValue('recaptcha_site_key');

        return view('frontend.pages.pengaduan', compact('title', 'subtitle', 'recaptcha_pengaduan_enabled', 'recaptcha_site_key'));
    }

    public function store(\App\Http\Requests\Frontend\StorePengaduanRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('dok_lampiran')) {
            $validated['dok_lampiran'] = $request->file('dok_lampiran')->store('pengaduan_lampiran', 'public');
        }

        // Remove g-recaptcha-response from validated data before creating model
        unset($validated['g-recaptcha-response']);

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
