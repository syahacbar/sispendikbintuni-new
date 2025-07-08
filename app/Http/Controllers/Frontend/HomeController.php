<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Ptk;
use App\Models\Sarana;
use App\Models\Sarpras;
use App\Models\Sekolah;
use App\Models\Prasarana;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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

        // Akreditasi
        // Akreditasi (stacked per jenjang)
        $akreditasiLabels = ['A', 'B', 'C', 'Belum Terakreditasi'];
        $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        $colors = [
            'A' => '#28a745',
            'B' => '#ffc107',
            'C' => '#dc3545',
            'Belum Terakreditasi' => '#6c757d',
        ];

        // Data akreditasi per jenjang
        $akreditasiByJenjang = [];

        foreach ($akreditasiLabels as $akreditasi) {
            foreach ($jenjangList as $jenjang) {
                $akreditasiByJenjang[$akreditasi][$jenjang] = Sekolah::where('jenjang', $jenjang)
                    ->where('akreditasi', $akreditasi)
                    ->count();
            }
        }

        // Dataset Akreditasi ChartJS
        $akreditasiDatasets = [];

        foreach ($akreditasiLabels as $akreditasi) {
            $data = [];
            foreach ($jenjangList as $jenjang) {
                $data[] = $akreditasiByJenjang[$akreditasi][$jenjang] ?? 0;
            }

            $akreditasiDatasets[] = [
                'label' => $akreditasi,
                'data' => $data,
                'backgroundColor' => $colors[$akreditasi],
                'stack' => 'Stack 0'
            ];
        }

        // Status PTK
        $statusPTKLabels = ['PNS', 'Honorer', 'GTY'];
        $colors = [
            'PNS' => '#0093dd',
            'Honorer' => '#17a2b8',
            'GTY' => '#ffc107',
        ];

        $statusPTKByJenjang = [];

        foreach ($statusPTKLabels as $status) {
            foreach ($jenjangList as $jenjang) {
                $statusPTKByJenjang[$status][$jenjang] = Ptk::where('status', $status)
                    ->whereHas('sekolah', fn($q) => $q->where('jenjang', $jenjang))
                    ->count();
            }
        }

        $statusPTKDatasets = [];

        foreach ($statusPTKLabels as $status) {
            $data = [];
            foreach ($jenjangList as $jenjang) {
                $data[] = $statusPTKByJenjang[$status][$jenjang] ?? 0;
            }

            $statusPTKDatasets[] = [
                'label' => $status,
                'data' => $data,
                'backgroundColor' => $colors[$status],
                'stack' => 'Stack 0'
            ];
        }


        // Sarpras (Stacked per Jenjang)
        $sarprasLabels = ['Baik', 'Rusak Ringan', 'Rusak Berat']; // akan jadi legenda
        $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM']; // akan jadi label X (sumbu X)

        // Warna untuk kondisi (BUKAN jenjang)
        $colors = [
            'Baik' => '#0d6efd',
            'Rusak Ringan' => '#ffc107',
            'Rusak Berat' => '#dc3545',
        ];

        // Data sarpras
        $sarprasByJenjangKondisi = [];

        // Hitung jumlah per jenjang per kondisi
        foreach ($sarprasLabels as $kondisi) {
            foreach ($jenjangList as $jenjang) {
                $count = Sarpras::where('kondisi', $kondisi)
                    ->whereHas('sekolah', function ($q) use ($jenjang) {
                        $q->where('jenjang', $jenjang);
                    })
                    ->count();

                $sarprasByJenjangKondisi[$kondisi][$jenjang] = $count;
            }
        }

        // Bangun dataset ChartJS berdasarkan kondisi (bukan jenjang)
        $datasets = [];

        foreach ($sarprasLabels as $kondisi) {
            $data = [];
            foreach ($jenjangList as $jenjang) {
                $data[] = $sarprasByJenjangKondisi[$kondisi][$jenjang] ?? 0;
            }

            $datasets[] = [
                'label' => $kondisi,
                'data' => $data,
                'backgroundColor' => $colors[$kondisi],
                'stack' => 'Stack 0'
            ];
        }


        // Kualifikasi Guru
        $kualifikasiLabels = ['D3', 'S1', 'S2', 'S3'];
        $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        $colors = [
            'D3' => '#6c757d',
            'S1' => '#17a2b8',
            'S2' => '#0093dd',
            'S3' => '#6610f2',
        ];

        // Hitung jumlah guru per jenjang per kualifikasi
        $kualifikasiByJenjang = [];

        foreach ($kualifikasiLabels as $kualifikasi) {
            foreach ($jenjangList as $jenjang) {
                $count = Ptk::where('kualifikasi', $kualifikasi)
                    ->whereHas('sekolah', fn($q) => $q->where('jenjang', $jenjang))
                    ->count();

                $kualifikasiByJenjang[$kualifikasi][$jenjang] = $count;
            }
        }

        // Format data ke dalam dataset ChartJS
        $kualifikasiDatasets = [];

        foreach ($kualifikasiLabels as $kualifikasi) {
            $data = [];
            foreach ($jenjangList as $jenjang) {
                $data[] = $kualifikasiByJenjang[$kualifikasi][$jenjang] ?? 0;
            }

            $kualifikasiDatasets[] = [
                'label' => $kualifikasi,
                'data' => $data,
                'backgroundColor' => $colors[$kualifikasi],
                'stack' => 'Stack 0',
            ];
        }

        // Sebaran Sekolah per kecamatan
        $sebaranSekolahKecamatan = Sekolah::with('kecamatanWilayah')
            ->select('kecamatan', DB::raw('count(*) as jumlah'))
            ->groupBy('kecamatan')
            ->orderBy('kecamatan')
            ->get();

        // Ambil nama kecamatan dari relasi Wilayah
        $kecamatanLabels = $sebaranSekolahKecamatan->map(fn($item) => $item->kecamatanWilayah->nama ?? $item->kecamatan);
        $jumlahSekolahData = $sebaranSekolahKecamatan->pluck('jumlah');


        return view('frontend.pages.home', compact(
            'statistik',
            'peserta_didik',
            'guru',
            'jumlah_peserta_didik',
            'jumlah_guru',
            'total_peserta_didik',
            'total_guru',
            'akreditasiLabels',
            'statusPTKLabels',
            'sarprasLabels',
            'kualifikasiLabels',
            'jenjangList',
            'datasets',
            'akreditasiDatasets',
            'statusPTKDatasets',
            'kualifikasiDatasets',
            'kecamatanLabels',       // baru
            'jumlahSekolahData'      // baru
        ));
    }
}
