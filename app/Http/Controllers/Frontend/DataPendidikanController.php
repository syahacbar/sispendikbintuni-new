<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Sekolah;
use App\Models\Wilayah;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataPendidikanController extends Controller
{
    // Halaman utama: daftar kecamatan
    public function index()
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Tabel Data Pendidikan Se-Kabupaten Teluk Bintuni';

        $jenjangList = Sekolah::select('jenjang')->distinct()->pluck('jenjang')->sortBy(function ($jenjang) {
            $order = ['TK', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];
            return array_search($jenjang, $order) !== false ? array_search($jenjang, $order) : 999;
        })->values()->all();

        $wilayahMap = Wilayah::pluck('nama', 'kode');

        $kecamatans = Sekolah::selectRaw('LEFT(kode_wilayah, 8) as kode_kecamatan')
            ->distinct()
            ->orderBy('kode_kecamatan')
            ->get()
            ->map(function ($item) use ($jenjangList, $wilayahMap) {
                $kodeKecamatan = $item->kode_kecamatan;
                $namaKecamatan = $wilayahMap[$kodeKecamatan] ?? '-';

                $data = Sekolah::where('kode_wilayah', 'like', $kodeKecamatan . '%')
                    ->select('jenjang', 'status_sekolah', DB::raw('count(*) as total'))
                    ->groupBy('jenjang', 'status_sekolah')
                    ->get();

                $grouped = collect();
                $totalAll = ['total' => 0, 'negeri' => 0, 'swasta' => 0];

                foreach ($jenjangList as $jenjang) {
                    $jenjangData = $data->where('jenjang', $jenjang);
                    $total = $jenjangData->sum('total');
                    $negeri = $jenjangData->where('status_sekolah', 'Negeri')->sum('total');
                    $swasta = $jenjangData->where('status_sekolah', 'Swasta')->sum('total');

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
        $subtitle = 'Data Sekolah di Kecamatan';

        $namaKecamatan = Wilayah::getNamaByKode($kecamatan);
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kecamatan), 0, 4);
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2);
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        $sekolahs = Sekolah::withCount([
            'pesertaDidiks',
            'rombonganBelajars',
            'ptks',
            'saranas',
            'prasaranas',
        ])
            ->where('kode_wilayah', 'like', $kecamatan . '%')
            ->orderBy('jenjang')
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
    public function detail($slug)
    {
        $title = 'Detail Sekolah';
        $subtitle = 'Informasi Lengkap Sekolah';

        $sekolah = Sekolah::with([
            'ptks',
            'pesertaDidiks',
            'sarpras.jenisSarpras',
            'prasaranas',
            'rombonganBelajars.waliKelas',
            'rombonganBelajars.pesertaDidiks'
        ])
            ->with(['rombonganBelajars' => function ($query) {
                $query->withCount('pesertaDidiks');
            }])
            ->where('slug', $slug)
            ->firstOrFail();

        $kodeKecamatan = $sekolah->kode_wilayah ? substr($sekolah->kode_wilayah, 0, 8) : null;
        $kodeKelurahan = $sekolah->kode_wilayah;

        $namaKecamatan = Wilayah::getNamaByKode($kodeKecamatan);
        $namaKelurahan = Wilayah::getNamaByKode($kodeKelurahan);
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kodeKecamatan), 0, 4);
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2);
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        $kualifikasiGuru = $sekolah->ptks->groupBy('kualifikasi')->map(fn($group) => $group->count());
        $statusGuru = $sekolah->ptks->groupBy('status')->map(fn($group) => $group->count());

        $kualifikasiLabels = $kualifikasiGuru->keys();
        $kualifikasiData = $kualifikasiGuru->values();

        $statusLabels = $statusGuru->keys();
        $statusData = $statusGuru->values();

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
            'statusData'
        ));
    }
}
