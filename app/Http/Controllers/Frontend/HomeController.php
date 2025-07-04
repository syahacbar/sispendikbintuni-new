<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\PesertaDidik;
use App\Models\Sarana;

class HomeController extends Controller
{

    public function index()
    {
        $jenjang = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        $statistik = [
            'semua' => [],
            'negeri' => [],
            'swasta' => [],
        ];

        foreach ($jenjang as $j) {
            $statistik['semua'][$j] = Sekolah::where('jenjang', $j)->count();
            $statistik['negeri'][$j] = Sekolah::where('jenjang', $j)->where('status_sekolah', 'Negeri')->count();
            $statistik['swasta'][$j] = Sekolah::where('jenjang', $j)->where('status_sekolah', 'Swasta')->count();
        }

        // ================================
        // 1. Total Peserta Didik per jenjang
        $peserta_didik = PesertaDidik::with('sekolah')->get()->groupBy(fn($pd) => $pd->sekolah->jenjang ?? 'Tidak Diketahui')->map->count();

        // 2. Total Guru per jenjang
        $guru = Ptk::with('sekolah')->get()->groupBy(fn($ptk) => $ptk->sekolah->jenjang ?? 'Tidak Diketahui')->map->count();

        // 3. Akreditasi Sekolah
        $akreditasi = Sekolah::selectRaw('akreditasi, count(*) as total')
            ->groupBy('akreditasi')
            ->pluck('total', 'akreditasi');

        // 4. Status PTK (misal kamu punya field "status" di tabel PTK)
        $status_ptk = Ptk::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        // 5. Kondisi Sarpras (misal kamu punya field "kondisi" di Sarana atau Prasarana)
        $kondisi_sarpras = Sarana::selectRaw('kondisi, count(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        return view('frontend.pages.home', compact(
            'statistik',
            'peserta_didik',
            'guru',
            'akreditasi',
            'status_ptk',
            'kondisi_sarpras'
        ));
    }
}
