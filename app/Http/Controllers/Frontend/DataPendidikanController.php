<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Sekolah;
use App\Models\Wilayah;
use App\Models\Pengaturan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DataPendidikanController extends Controller
{
    public function index()
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Tabel Data Pendidikan Se-Kabupaten Teluk Bintuni';

        $jenjangList = Sekolah::select('jenjang')
            ->distinct()
            ->pluck('jenjang')
            ->sortBy(function ($jenjang) {
                $order = ['TK', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];
                return array_search($jenjang, $order) !== false ? array_search($jenjang, $order) : 999;
            })
            ->values()
            ->all();

        $kecamatans = Sekolah::select('kecamatan')
            ->distinct()
            ->orderBy('kecamatan')
            ->get()
            ->map(function ($item) use ($jenjangList) {
                $namaKecamatan = Wilayah::where('kode', $item->kecamatan)->value('nama');

                $jumlahPerJenjang = Sekolah::where('kecamatan', $item->kecamatan)
                    ->select('jenjang', DB::raw('count(*) as total'))
                    ->groupBy('jenjang')
                    ->pluck('total', 'jenjang');

                return [
                    'kecamatan' => $item->kecamatan,
                    'nama_kecamatan' => $namaKecamatan,
                    'jumlah' => collect($jenjangList)->mapWithKeys(fn($jenjang) => [
                        $jenjang => $jumlahPerJenjang[$jenjang] ?? 0
                    ])->all(),
                ];
            });

        // Ambil nama kabupaten dari salah satu kecamatan
        $kodeKecamatan = optional($kecamatans->first())['kecamatan'];
        $kodeKabupaten = substr($kodeKecamatan, 0, 5); // misal: "92.06"
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


    public function kelurahan($kecamatan)
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Data Pendidikan berdasarkan Kelurahan di Kabupaten Teluk Bintuni';

        // Ambil jenjang secara dinamis
        $jenjangList = Sekolah::select('jenjang')
            ->distinct()
            ->pluck('jenjang')
            ->sortBy(function ($jenjang) {
                $order = ['TK', 'SD', 'SMP', 'SMA', 'SMK', 'SLB'];
                return array_search($jenjang, $order) !== false ? array_search($jenjang, $order) : 999;
            })
            ->values()
            ->all();

        // Ambil kelurahan dan hitung sekolah per jenjang
        $kelurahans = Sekolah::where('kecamatan', $kecamatan)
            ->select('desa_kelurahan')
            ->distinct()
            ->orderBy('desa_kelurahan')
            ->get()
            ->map(function ($item) use ($kecamatan, $jenjangList) {
                $namaKelurahan = Wilayah::getNamaByKode($item->desa_kelurahan);

                $jumlahPerJenjang = Sekolah::where('kecamatan', $kecamatan)
                    ->where('desa_kelurahan', $item->desa_kelurahan)
                    ->select('jenjang', DB::raw('count(*) as total'))
                    ->groupBy('jenjang')
                    ->pluck('total', 'jenjang');

                return [
                    'desa_kelurahan' => $item->desa_kelurahan,
                    'nama_kelurahan' => $namaKelurahan,
                    'jumlah' => collect($jenjangList)->mapWithKeys(fn($jenjang) => [
                        $jenjang => $jumlahPerJenjang[$jenjang] ?? 0
                    ])->all(),
                ];
            });

        // Ambil nama kecamatan
        $namaKecamatan = Wilayah::getNamaByKode($kecamatan);

        // Ambil nama kabupaten berdasarkan kode kecamatan
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kecamatan), 0, 4); // Contoh: 9206
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2); // Hasil: 92.06
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        return view('frontend.pages.kelurahan', compact(
            'title',
            'subtitle',
            'kelurahans',
            'kecamatan',
            'jenjangList',
            'namaKecamatan',
            'namaKabupaten'
        ));
    }

    public function sekolah($kecamatan, $kelurahan)
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Data Pendidikan berdasarkan Kelurahan di Kabupaten Teluk Bintuni';

        $namaKecamatan = Wilayah::getNamaByKode($kecamatan);
        $namaKelurahan = Wilayah::getNamaByKode($kelurahan);

        // Ambil kode kabupaten dari kode kecamatan
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kecamatan), 0, 4); // 9206
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2); // jadi 92.06
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        $sekolahs = Sekolah::withCount([
            'pesertaDidiks',
            'rombonganBelajars',
            'ptks',
            'saranas',
            'prasaranas',
        ])
            ->where('kecamatan', $kecamatan)
            ->where('desa_kelurahan', $kelurahan)
            ->orderBy('nama')
            ->get();

        return view('frontend.pages.sekolah', compact(
            'title',
            'subtitle',
            'sekolahs',
            'kecamatan',
            'kelurahan',
            'namaKecamatan',
            'namaKelurahan',
            'namaKabupaten'
        ));
    }

    public function detail($slug)
    {
        $title = 'Data Pendidikan';
        $subtitle = 'Data Pendidikan berdasarkan Kelurahan di Kabupaten Teluk Bintuni';

        $sekolah = Sekolah::with(['ptks', 'pesertaDidiks', 'saranas', 'prasaranas'])
            ->where('slug', $slug)
            ->firstOrFail();

        $kodeKecamatan = $sekolah->kecamatan;
        $kodeKelurahan = $sekolah->desa_kelurahan;

        $namaKecamatan = Wilayah::getNamaByKode($kodeKecamatan);
        $namaKelurahan = Wilayah::getNamaByKode($kodeKelurahan);

        // Ambil nama kabupaten dari kode kecamatan
        $kodeKabupaten = substr(preg_replace('/[^0-9]/', '', $kodeKecamatan), 0, 4); // misal: 9206
        $kodeKabupaten = substr($kodeKabupaten, 0, 2) . '.' . substr($kodeKabupaten, 2, 2); // jadi: 92.06
        $namaKabupaten = Wilayah::getNamaByKode($kodeKabupaten);

        return view('frontend.pages.detail_sekolah', compact(
            'title',
            'subtitle',
            'sekolah',
            'namaKecamatan',
            'namaKelurahan',
            'namaKabupaten',
            'kodeKecamatan',
            'kodeKelurahan'
        ));
    }

    public function tentang()
    {
        $title = 'Tentang Sispendik Bintuni';
        $subtitle = 'Tentang Sispendik Bintuni';

        // $sekolah = Pengaturan::all();

        return view('frontend.pages.tentang', compact(
            'title',
            'subtitle',
        ));
    }
}
