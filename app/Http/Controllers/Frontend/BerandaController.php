<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MstGtk;
use App\Models\Sarana;
use App\Models\Sarpras;
use App\Models\RefWilayah;
use App\Models\ExtInformasi;
use App\Models\MstSekolah;
use App\Models\SysSetting;
use App\Models\PesertaDidik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\RefJenjangPendidikan;

class BerandaController extends Controller
{
    public function index()
    {
        $title = 'Beranda';
        // $subtitle = 'Tata Kelola Pendidikan Dengan Sistem Perencanaan Terintegrasi (SERASI) Kabupaten Teluk Bintuni';
        // Tampilkan data statistik jenjang sekolah (semua, negeri dan swasra) halaman beranda
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




        // Section Sebaran Sekolah Per Kecamatan
        // 1. Ambil data jumlah sekolah berdasarkan 8 digit awal kode_wilayah (kecamatan)
        $sebaranSekolahKecamatan = DB::table('mst_sekolah')
            ->selectRaw("SUBSTRING(kode_wilayah, 1, 8) as kode_wilayah, COUNT(*) as jumlah")
            ->groupBy('kode_wilayah')
            ->orderBy('kode_wilayah')
            ->get();

        // 2. Ambil semua nama kecamatan dari tabel wilayah
        $kecamatanCodes = $sebaranSekolahKecamatan->pluck('kode_wilayah');
        $wilayahMap = RefWilayah::whereIn('kode', $kecamatanCodes)->pluck('nama', 'kode');

        // 3. Siapkan data untuk Chart.js
        $kecamatanLabels = $sebaranSekolahKecamatan->map(
            fn($item) => $wilayahMap[$item->kode_wilayah] ?? $item->kode_wilayah
        );
        $jumlahSekolahData = $sebaranSekolahKecamatan->pluck('jumlah');


        // Akreditasi Sekolah per jenjang
        // Akreditasi
        $akreditasiLabels = ['A', 'B', 'C', 'Belum Terakreditasi'];

        $colors = [
            'A' => '#28a745',
            'B' => '#ffc107',
            'C' => '#dc3545',
            'Belum Terakreditasi' => '#6c757d',
        ];

        // Ambil jenjangList dari tabel referensi
        $jenjangList = RefJenjangPendidikan::orderBy('kode')->pluck('kode', 'kode')->toArray();


        // Inisialisasi data
        $akreditasiByJenjang = [];

        foreach ($akreditasiLabels as $akreditasi) {
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $akreditasiByJenjang[$akreditasi][$nama_jenjang] = MstSekolah::where('kode_jenjang', $kode_jenjang)
                    ->where('akreditasi', $akreditasi)
                    ->count();
            }
        }

        // Susun dataset untuk ChartJS
        $akreditasiDatasets = [];

        foreach ($akreditasiLabels as $akreditasi) {
            $data = [];
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $data[] = $akreditasiByJenjang[$akreditasi][$nama_jenjang] ?? 0;
            }

            $akreditasiDatasets[] = [
                'label' => $akreditasi,
                'data' => $data,
                'backgroundColor' => $colors[$akreditasi],
                'stack' => 'Stack 0'
            ];
        }

        // Label jenjang di chart di halaman beranda
        // $jenjangLabels = array_values($jenjangList);
        $akreditasiJenjangLabels = array_values($jenjangList); // untuk chart akreditasi
        $kualifikasiJenjangLabels = array_values($jenjangList); // untuk chart kualifikasi guru


        // ==================================
        // Kualifikasi Guru
        $guruJenisId = 'Guru';
        $pendidikanLabels = ['SMA', 'D3', 'S1', 'S2', 'S3'];

        $colors = [
            'SMA' => '#ffc107',
            'D3' => '#fd7e14',
            'S1' => '#28a745',
            'S2' => '#007bff',
            'S3' => '#6f42c1',
        ];

        $gtk_wali_kelas = DB::table('mst_rombel as r')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'r.wali_kelas_ptk_id')
            ->select('s.kode_jenjang', 'g.id', 'g.pend_terakhir', 'g.status_keaktifan', 'g.jenis_gtk');

        $gtk_pembelajaran = DB::table('mst_pembelajaran as pb')
            ->join('mst_rombel as r', 'r.id', '=', 'pb.rombongan_belajar_id')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'pb.gtk_id')
            ->select('s.kode_jenjang', 'g.id', 'g.pend_terakhir', 'g.status_keaktifan', 'g.jenis_gtk');

        // UNION ALL keduanya
        $gtk_union = $gtk_wali_kelas->unionAll($gtk_pembelajaran);

        // Hasil union
        $gtk_data = DB::query()->fromSub($gtk_union, 'gtk_data')
            ->where('status_keaktifan', 'Aktif')
            ->where('jenis_gtk', $guruJenisId)
            ->get();


        $gtkKualifikasiByJenjang = [];

        foreach ($pendidikanLabels as $pendidikan) {
            foreach ($jenjangList as $kode_jenjang => $labelJenjang) {
                $gtkKualifikasiByJenjang[$pendidikan][$labelJenjang] = $gtk_data->filter(function ($item) use ($pendidikan, $kode_jenjang) {
                    return $item->pend_terakhir === $pendidikan && $item->kode_jenjang === $kode_jenjang;
                })->unique('id')->count();
            }
        }


        $jenjangLabels = array_values($jenjangList);

        $gtkKualifikasiDatasets = [];

        foreach ($pendidikanLabels as $pendidikan) {
            $data = [];
            foreach ($jenjangLabels as $labelJenjang) {
                $data[] = $gtkKualifikasiByJenjang[$pendidikan][$labelJenjang] ?? 0;
            }

            $gtkKualifikasiDatasets[] = [
                'label' => $pendidikan,
                'data' => $data,
                'backgroundColor' => $colors[$pendidikan],
                'stack' => 'Stack 0',
            ];
        }


        // ================================== Gtk by Status Kepegawaian
        $statusKepegawaianLabels = ['PNS', 'PPPK', 'Honorer Daerah', 'Honorer Sekolah', 'GTY/PTY', 'Lainnya'];

        $statusKepegawaianColors = [
            'PNS' => '#007bff',
            'PPPK' => '#28a745',
            'Honorer Daerah' => '#ffc107',
            'Honorer Sekolah' => '#fd7e14',
            'GTY/PTY' => '#6f42c1',
            'Lainnya' => '#6c757d',
        ];


        $gtk_wali_kelas = DB::table('mst_rombel as r')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'r.wali_kelas_ptk_id')
            ->select('s.kode_jenjang', 'g.id', 'g.status_kepegawaian', 'g.status_keaktifan', 'g.jenis_gtk');

        $gtk_pembelajaran = DB::table('mst_pembelajaran as pb')
            ->join('mst_rombel as r', 'r.id', '=', 'pb.rombongan_belajar_id')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'pb.gtk_id')
            ->select('s.kode_jenjang', 'g.id', 'g.status_kepegawaian', 'g.status_keaktifan', 'g.jenis_gtk');

        $gtk_union = $gtk_wali_kelas->unionAll($gtk_pembelajaran);

        $gtk_data = DB::query()->fromSub($gtk_union, 'gtk_data')
            ->where('status_keaktifan', 'Aktif')
            ->where('jenis_gtk', $guruJenisId) // ambil yang guru saja
            ->get();


        $gtkKepegawaianByJenjang = [];

        foreach ($statusKepegawaianLabels as $status) {
            foreach ($jenjangList as $kode_jenjang => $labelJenjang) {
                $gtkKepegawaianByJenjang[$status][$labelJenjang] = $gtk_data->filter(function ($item) use ($status, $kode_jenjang) {
                    return $item->status_kepegawaian === $status && $item->kode_jenjang === $kode_jenjang;
                })->unique('id')->count();
            }
        }

        $gtkKepegawaianDatasets = [];

        $jenjangLabelsKepegawaian = array_values($jenjangList);

        foreach ($statusKepegawaianLabels as $status) {
            $data = [];
            foreach ($jenjangLabelsKepegawaian as $labelJenjang) {
                $data[] = $gtkKepegawaianByJenjang[$status][$labelJenjang] ?? 0;
            }

            $gtkKepegawaianDatasets[] = [
                'label' => $status,
                'data' => $data,
                'backgroundColor' => $statusKepegawaianColors[$status],
                'stack' => 'Stack 0',
            ];
        }

        // Menampilkan Kegiatan di halaman beranda
        $berita = ExtInformasi::where('kategori', 'Berita')
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        $pengumuman = ExtInformasi::where('kategori', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        $kegiatan = ExtInformasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(1);


        // Kondisi Sarpras per Jenjang Sekolah
        $kondisiLabels = ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'];
        $kondisiColors = [
            'Baik' => '#28a745',
            'Rusak Ringan' => '#ffc107',
            'Rusak Sedang' => '#fd7e14',
            'Rusak Berat' => '#dc3545',
        ];

        $kondisiSarprasByJenjang = [];

        foreach ($kondisiLabels as $kondisi) {
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $jumlah = DB::table('mst_kondisi_sarpras as ks')
                    ->join('mst_sarpras_sekolah as ss', 'ks.id_mst_sarpras', '=', 'ss.id')
                    ->join('mst_sekolah as s', 'ss.sekolah_id', '=', 's.id')
                    ->where('ks.kondisi', $kondisi)
                    ->where('s.kode_jenjang', $kode_jenjang)
                    ->sum(DB::raw('CAST(ks.jumlah AS INTEGER)'));

                $kondisiSarprasByJenjang[$kondisi][$nama_jenjang] = $jumlah;
            }
        }

        // Siapkan dataset untuk Chart.js
        $kondisiSarprasDatasets = [];

        foreach ($kondisiLabels as $kondisi) {
            $data = [];
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $data[] = $kondisiSarprasByJenjang[$kondisi][$nama_jenjang] ?? 0;
            }

            $kondisiSarprasDatasets[] = [
                'label' => $kondisi,
                'data' => $data,
                'backgroundColor' => $kondisiColors[$kondisi],
                'stack' => 'Stack 0',
            ];
        }

        $kondisiJenjangLabels = array_values($jenjangList);


        return view('frontend.pages.beranda', compact(
            'title',
            'statistik',
            'jenjangList',
            'jumlah_peserta_didik',
            'total_peserta_didik',
            'jumlah_guru',
            'total_guru',

            'akreditasiLabels',
            'akreditasiDatasets',
            'akreditasiJenjangLabels',

            'kecamatanLabels',
            'jumlahSekolahData',

            'gtkKualifikasiDatasets',
            'kualifikasiJenjangLabels',

            'jenjangLabelsKepegawaian',
            'gtkKepegawaianDatasets',

            // Kegiatan di halaman beranda
            'kegiatan',
            'berita',
            'pengumuman',

            'kondisiSarprasDatasets',
            'kondisiJenjangLabels',
        ));
    }
}
