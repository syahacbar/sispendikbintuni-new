<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MstSekolah;
use App\Models\Wilayah;
use App\Models\MstGtk;
use App\Models\SysSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataPendidikanController extends Controller
{

    // Halaman utama: daftar kecamatan
    public function index()
    {

        $title = 'Data Pendidikan';
        $subtitle = 'Rekapitulasi data pendidikan Berdasarkan Kecamatan.';

        // $jenjangList = Sekolah::select('jenjang')->distinct()->pluck('jenjang')->sortBy(function ($jenjang) {
        //     $order = ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];
        //     return array_search($jenjang, $order) !== false ? array_search($jenjang, $order) : 999;
        // })->values()->all();

        $jenjangList = ['TK', 'KB', 'TPA', 'SPS', 'PKBM', 'SKB', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];


        $wilayahMap = Wilayah::pluck('nama', 'kode');

        $kecamatans = MstSekolah::selectRaw('LEFT(kode_wilayah, 8) as kode_kecamatan')
            ->distinct()
            ->orderBy('kode_kecamatan')
            ->get()
            ->map(function ($item) use ($jenjangList, $wilayahMap) {
                $kodeKecamatan = $item->kode_kecamatan;
                $namaKecamatan = $wilayahMap[$kodeKecamatan] ?? '-';

                $data = MstSekolah::where('kode_wilayah', 'like', $kodeKecamatan . '%')
                    ->select('kode_jenjang', 'status', DB::raw('count(*) as total'))
                    ->groupBy('kode_jenjang', 'status')
                    ->get();

                $grouped = collect();
                $totalAll = ['total' => 0, 'negeri' => 0, 'swasta' => 0];

                foreach ($jenjangList as $jenjang) {
                    $jenjangData = $data->where('kode_jenjang', $jenjang);
                    $total = $jenjangData->sum('total');
                    $negeri = $jenjangData->where('status', 'Negeri')->sum('total');
                    $swasta = $jenjangData->where('status', 'Swasta')->sum('total');

                    $grouped[$jenjang] = [
                        'total' => $total,
                        'negeri' => $negeri,
                        'swasta' => $swasta,
                    ];

                    $totalAll['total'] += $total;
                    $totalAll['negeri'] += $negeri;
                    $totalAll['swasta'] += $swasta;
                }

                return [
                    'kecamatan' => $kodeKecamatan,
                    'nama_kecamatan' => $namaKecamatan,
                    'jumlah' => $grouped,
                    'total_all' => $totalAll,
                ];
            });

        $kodeKecamatan = optional($kecamatans->first())['kecamatan'];
        $kodeKabupaten = substr($kodeKecamatan, 0, 5);
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        return view('frontend.pages.kecamatan', compact(
            'title',
            'subtitle',
            'kecamatans',
            'jenjangList',
            'namaKabupaten',
            'kodeKabupaten'
        ));
    }

    // Halaman daftar sekolah berdasarkan kecamatan
    public function sekolahByKecamatan($kecamatan)
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Rekapitulasi data pendidikan berdasarkan sekolah.';

        $namaKecamatan = Wilayah::getNamaByKode($kecamatan);
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kecamatan), 0, 4);
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2);
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        $sekolahs = MstSekolah::with([
            'jenjang', // relasi ke ref_jenjang_pendidikan
        ])
            ->withCount([
                'rombonganBelajars',
                'pesertaDidiks as peserta_didiks_count', // total peserta didik
                'gtkGuru as ptks_count',                 // total guru
                'gtkPegawai as pegawai_count',           // total pegawai
            ])
            ->where('kode_wilayah', 'like', $kecamatan . '%')
            ->orderBy('kode_jenjang')
            ->orderBy('nama')
            ->get();

        return view('frontend.pages.sekolah_by_kecamatan', compact(
            'title',
            'subtitle',
            'sekolahs',
            'kecamatan',
            'namaKecamatan',
            'namaKabupaten'
        ));
    }



    // Halaman detail sekolah
    public function detail($npsn)
    {
        $title = 'Detail Sekolah';
        $subtitle = 'Informasi lengkap mengenai kondisi sekolah.';

        $sekolah = MstSekolah::with([
            'ptks',
            'pesertaDidiks',
            'mstSarprasSekolah.jenisSarpras',
            // 'prasaranas',
            'rombonganBelajars.waliKelas',
            'rombonganBelajars.pesertaDidiks'
        ])
            ->with(['rombonganBelajars' => function ($query) {
                $query->withCount('pesertaDidiks');
            }])
            ->where('npsn', $npsn)
            ->firstOrFail();

        // Wilayah
        $kodeKecamatan = $sekolah->kode_wilayah ? substr($sekolah->kode_wilayah, 0, 8) : null;
        $kodeKelurahan = $sekolah->kode_wilayah;
        $namaKecamatan = Wilayah::getNamaByKode($kodeKecamatan);
        $namaKelurahan = Wilayah::getNamaByKode($kodeKelurahan);
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kodeKecamatan), 0, 4);
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2);
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        $kurikulum = optional($sekolah->rombonganBelajars->first()?->kurikulum);
        // Chart Data
        $kualifikasiGuru = $sekolah->ptks->groupBy('kualifikasi')->map(fn($group) => $group->count());
        $statusGuru = $sekolah->ptks->groupBy('status')->map(fn($group) => $group->count());

        // Siapkan label & data chart
        $kualifikasiLabels = $kualifikasiGuru->keys();
        $kualifikasiData = $kualifikasiGuru->values();
        $statusLabels = $statusGuru->keys();
        $statusData = $statusGuru->values();

        // Ambil data wali kelas dari rombongan belajar
        $gtkIds = $sekolah->rombonganBelajars->pluck('wali_kelas_ptk_id')->unique()->filter();
        $ptks = MstGtk::whereIn('id', $gtkIds)->get();

        return view('frontend.pages.detail_sekolah', compact(
            'title',
            'subtitle',
            'sekolah',
            'namaKecamatan',
            'namaKelurahan',
            'namaKabupaten',
            'kodeKecamatan',
            'kodeKelurahan',
            'kualifikasiGuru',
            'statusGuru',
            'kualifikasiLabels',
            'kualifikasiData',
            'statusLabels',
            'statusData',
            'kurikulum'
        ));
    }
}
