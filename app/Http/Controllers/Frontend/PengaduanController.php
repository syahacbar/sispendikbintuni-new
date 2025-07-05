<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengaduan;

class PengaduanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:20',
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
        return view('frontend.pages.lacak_pengaduan');
    }

    public function lacak(Request $request)
    {
        $request->validate([
            'cek_laporan' => 'required|string',
        ]);

        $data = Pengaduan::where('nomor_laporan', $request->cek_laporan)->first();

        if (!$data) {
            return back()->withErrors(['cek_laporan' => 'Nomor laporan tidak ditemukan.'])->withInput();
        }

        return view('frontend.pages.lacak_pengaduan', compact('data'));
    }
}
