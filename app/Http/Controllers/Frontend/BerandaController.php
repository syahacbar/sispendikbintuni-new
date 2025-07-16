<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MstGtk;
use App\Models\Sarana;
use App\Models\Sarpras;
use App\Models\MstSekolah;
use App\Models\Wilayah;
use App\Models\Prasarana;
use App\Models\SysSetting;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        // Kalo mau ambil semua data di tabel
        $pengaturan = SysSetting::getAllAsArray();

        // Kalo ambil berdasarkan group
        // $pengaturan = SysSetting::where('group', 'site')->get()->pluck('value', 'key');


        // Tampilkan data statistik jenjang sekolah (semua, negeri dan swasra) halaman beranda
        // $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];
        $jenjangList = ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];
        $statistik = [
            'semua' => [],
            'Negeri' => [],
            'Swasta' => [],
        ];

        foreach ($jenjangList as $jenjang) {
            $statistik['semua'][$jenjang] = MstSekolah::where('kode_jenjang', $jenjang)->count();
            $statistik['Negeri'][$jenjang] = MstSekolah::where('kode_jenjang', $jenjang)->where('status', 'Negeri')->count();
            $statistik['Swasta'][$jenjang] = MstSekolah::where('kode_jenjang', $jenjang)->where('status', 'Swasta')->count();
        }


        // Jumlah Peserta didik seluruh jenjang dan per jenjang
        $jumlah_peserta_didik = DB::table('mst_peserta_didik as pd')
            ->join('mst_anggota_rombel as ar', 'ar.peserta_didik_id', '=', 'pd.id')
            ->join('mst_rombel as r', 'r.id', '=', 'ar.rombel_id')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->select('s.kode_jenjang', DB::raw('COUNT(DISTINCT pd.id) as total'))
            ->groupBy('s.kode_jenjang')
            ->pluck('total', 's.kode_jenjang')
            ->toArray();


        $total_peserta_didik = DB::table('mst_peserta_didik as pd')
            ->join('mst_anggota_rombel as ar', 'ar.peserta_didik_id', '=', 'pd.id')
            ->count(DB::raw('DISTINCT pd.id'));


        // Total GTK semua jenjang dan per jenjang
        $gtk_wali_kelas = DB::table('mst_rombel as r')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'r.wali_kelas_ptk_id')
            ->select('s.kode_jenjang', 'g.id');

        $gtk_pembelajaran = DB::table('mst_pembelajaran as pb')
            ->join('mst_rombel as r', 'r.id', '=', 'pb.rombongan_belajar_id')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'pb.gtk_id')
            ->select('s.kode_jenjang', 'g.id');

        // Gabungkan keduanya
        $gtk_union = $gtk_wali_kelas->unionAll($gtk_pembelajaran);

        // Ambil semua data hasil union
        $gtk_data = DB::query()->fromSub($gtk_union, 'gtk_data')->get();

        // Ambil unik berdasarkan id GTK
        $gtk_unique = $gtk_data->unique('id');

        // Hitung per jenjang
        $jumlah_guru = $gtk_unique->groupBy('kode_jenjang')
            ->map(fn($group) => $group->count())
            ->toArray();

        // Total keseluruhan
        $total_guru = $gtk_unique->count();


        // Kreditasi bagian ini
        // Akreditasi
        $akreditasiLabels = ['A', 'B', 'C', 'Belum Terakreditasi'];
        $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        $colors = [
            'A' => '#28a745',
            'B' => '#ffc107',
            'C' => '#dc3545',
            'Belum Terakreditasi' => '#6c757d',
        ];

        // // Data akreditasi per jenjang
        $akreditasiByJenjang = [];

        foreach ($akreditasiLabels as $akreditasi) {
            foreach ($jenjangList as $jenjang) {
                $akreditasiByJenjang[$akreditasi][$jenjang] = MstSekolah::where('kode_jenjang', $jenjang)
                    ->where('akreditasi', $akreditasi)
                    ->count();
            }
        }

        // // Dataset Akreditasi ChartJS
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
                $akreditasiByJenjang[$akreditasi][$jenjang] = MstSekolah::where('kode_jenjang', $jenjang)
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
        // $statusPTKLabels = ['PNS', 'Honorer', 'GTY'];
        // $colors = [
        //     'PNS' => '#0093dd',
        //     'Honorer' => '#17a2b8',
        //     'GTY' => '#ffc107',
        // ];

        // $statusPTKByJenjang = [];

        // foreach ($statusPTKLabels as $status) {
        //     foreach ($jenjangList as $jenjang) {
        //         $statusPTKByJenjang[$status][$jenjang] = MstGtk::where('status_kepegawaian', $status)
        //             ->whereHas('sekolah', fn($q) => $q->where('kode_jenjang', $jenjang))
        //             ->count();
        //     }
        // }

        // $statusPTKDatasets = [];

        // foreach ($statusPTKLabels as $status) {
        //     $data = [];
        //     foreach ($jenjangList as $jenjang) {
        //         $data[] = $statusPTKByJenjang[$status][$jenjang] ?? 0;
        //     }

        //     $statusPTKDatasets[] = [
        //         'label' => $status,
        //         'data' => $data,
        //         'backgroundColor' => $colors[$status],
        //         'stack' => 'Stack 0'
        //     ];
        // }


        // Sarpras (Stacked per Jenjang)
        // $sarprasLabels = ['Baik', 'Rusak Ringan', 'Rusak Berat']; // akan jadi legenda
        // $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM']; // akan jadi label X (sumbu X)

        // // Warna untuk kondisi (BUKAN jenjang)
        // $colors = [
        //     'Baik' => '#0d6efd',
        //     'Rusak Ringan' => '#ffc107',
        //     'Rusak Berat' => '#dc3545',
        // ];

        // Data sarpras
        // $sarprasByJenjangKondisi = [];

        // Hitung jumlah per jenjang per kondisi
        // foreach ($sarprasLabels as $kondisi) {
        //     foreach ($jenjangList as $jenjang) {
        //         $count = Sarpras::where('kondisi', $kondisi)
        //             ->whereHas('sekolah', function ($q) use ($jenjang) {
        //                 $q->where('jenjang', $jenjang);
        //             })
        //             ->count();

        //         $sarprasByJenjangKondisi[$kondisi][$jenjang] = $count;
        //     }
        // }

        // Bangun dataset ChartJS berdasarkan kondisi (bukan jenjang)
        // $datasets = [];

        // foreach ($sarprasLabels as $kondisi) {
        //     $data = [];
        //     foreach ($jenjangList as $jenjang) {
        //         $data[] = $sarprasByJenjangKondisi[$kondisi][$jenjang] ?? 0;
        //     }

        //     $datasets[] = [
        //         'label' => $kondisi,
        //         'data' => $data,
        //         'backgroundColor' => $colors[$kondisi],
        //         'stack' => 'Stack 0'
        //     ];
        // }


        // Kualifikasi Guru
        // $kualifikasiLabels = ['D3', 'S1', 'S2', 'S3'];
        // $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];

        // $colors = [
        //     'D3' => '#6c757d',
        //     'S1' => '#17a2b8',
        //     'S2' => '#0093dd',
        //     'S3' => '#6610f2',
        // ];

        // Hitung jumlah guru per jenjang per kualifikasi
        // $kualifikasiByJenjang = [];

        // foreach ($kualifikasiLabels as $kualifikasi) {
        //     foreach ($jenjangList as $jenjang) {
        //         $count = MstGtk::where('kualifikasi', $kualifikasi)
        //             ->whereHas('sekolah', fn($q) => $q->where('kode_jenjang', $jenjang))
        //             ->count();

        //         $kualifikasiByJenjang[$kualifikasi][$jenjang] = $count;
        //     }
        // }

        // Format data ke dalam dataset ChartJS
        // $kualifikasiDatasets = [];

        // foreach ($kualifikasiLabels as $kualifikasi) {
        //     $data = [];
        //     foreach ($jenjangList as $jenjang) {
        //         $data[] = $kualifikasiByJenjang[$kualifikasi][$jenjang] ?? 0;
        //     }

        //     $kualifikasiDatasets[] = [
        //         'label' => $kualifikasi,
        //         'data' => $data,
        //         'backgroundColor' => $colors[$kualifikasi],
        //         'stack' => 'Stack 0',
        //     ];
        // }


        return view('frontend.pages.beranda', compact(
            'pengaturan',
            'statistik',
            'jenjangList',
            'jumlah_peserta_didik',
            'total_peserta_didik',
            'jumlah_guru',
            'total_guru',
            'akreditasiLabels',
            'akreditasiDatasets',

            // 'statusPTKLabels',
            // 'sarprasLabels',
            // 'kualifikasiLabels',
            // 'jenjangList',
            // 'datasets',
            // 'statusPTKDatasets',
            // 'kualifikasiDatasets',
        ));
    }
}
