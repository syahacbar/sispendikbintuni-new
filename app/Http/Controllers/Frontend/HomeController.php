<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\PesertaDidik;
use App\Models\Prasarana;
use App\Models\Sarana;

class HomeController extends Controller
{

    public function index()
    {
        $jenjang = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        $jumlah_peserta_didik = PesertaDidik::with('sekolah')
            ->get()
            ->groupBy(fn($pd) => $pd->sekolah->jenjang ?? 'Tidak Diketahui')
            ->map(fn($group) => $group->count());

        $jumlah_guru = Ptk::with('sekolah')
            ->get()
            ->groupBy(fn($ptk) => $ptk->sekolah->jenjang ?? 'Tidak Diketahui')
            ->map(fn($group) => $group->count());

        $total_peserta_didik = $jumlah_peserta_didik->sum();
        $total_guru = $jumlah_guru->sum();

        $statistik = [
            'semua' => [],
            'Negeri' => [],
            'Swasta' => [],
        ];

        foreach ($jenjang as $j) {
            $statistik['semua'][$j] = Sekolah::where('jenjang', $j)->count();
            $statistik['Negeri'][$j] = Sekolah::where('jenjang', $j)->where('status_sekolah', 'Negeri')->count();
            $statistik['Swasta'][$j] = Sekolah::where('jenjang', $j)->where('status_sekolah', 'Swasta')->count();
        }

        $peserta_didik = PesertaDidik::with('sekolah')->get()->groupBy(fn($pd) => $pd->sekolah->jenjang ?? 'Tidak Diketahui')->map->count();

        $guru = Ptk::with('sekolah')->get()->groupBy(fn($ptk) => $ptk->sekolah->jenjang ?? 'Tidak Diketahui')->map->count();

        $akreditasi = Sekolah::selectRaw('akreditasi, count(*) as total')
            ->groupBy('akreditasi')
            ->pluck('total', 'akreditasi');

        $status_ptk = Ptk::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $kondisi_sarpras = Prasarana::selectRaw('jumlah, count(*) as total')
            ->groupBy('jumlah')
            ->pluck('total', 'jumlah');


        // Akreditasi
        $akreditasiLabels = ['A', 'B', 'C', 'Belum Terakreditasi'];
        $akreditasiCounts = Sekolah::selectRaw('akreditasi, count(*) as total')
            ->groupBy('akreditasi')
            ->pluck('total', 'akreditasi');
        $akreditasiData = [];
        foreach ($akreditasiLabels as $label) {
            $akreditasiData[] = $akreditasiCounts[$label] ?? 0;
        }

        // Status PTK
        $statusPTKLabels = ['PNS', 'Honorer', 'GTY'];
        $statusPTKCounts = Ptk::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');
        $statusPTKData = [];
        foreach ($statusPTKLabels as $label) {
            $statusPTKData[] = $statusPTKCounts[$label] ?? 0;
        }

        // Kondisi Sarpras
        $sarprasLabels = ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'];
        $sarprasCounts = Prasarana::selectRaw('kondisi, count(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');
        $sarprasData = [];
        foreach ($sarprasLabels as $label) {
            $sarprasData[] = $sarprasCounts[$label] ?? 0;
        }

        // Kualifikasi Guru
        $kualifikasiLabels = ['D3', 'S1', 'S2', 'S3'];
        $kualifikasiCounts = Ptk::selectRaw('kualifikasi, count(*) as total')
            ->groupBy('kualifikasi')
            ->pluck('total', 'kualifikasi');
        $kualifikasiData = [];
        foreach ($kualifikasiLabels as $label) {
            $kualifikasiData[] = $kualifikasiCounts[$label] ?? 0;
        }

        return view('frontend.pages.home', compact(
            'statistik',
            'peserta_didik',
            'guru',
            'jumlah_peserta_didik',
            'jumlah_guru',
            'total_peserta_didik',
            'total_guru',
            'akreditasiLabels',
            'akreditasiData',
            'statusPTKLabels',
            'statusPTKData',
            'sarprasLabels',
            'sarprasData',
            'kualifikasiLabels',
            'kualifikasiData',
        ));
    }
}
