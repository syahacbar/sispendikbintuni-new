<?php

namespace App\Http\Controllers\Frontend;

use App\Models\MstSekolah;
use App\Models\MstGtk;
use App\Models\ExtInformasi;
use App\Models\ExtBannerMobile;
use App\Models\RefJenjangPendidikan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BerandaController extends Controller
{
    public function index()
    {
        $title = 'Beranda';

        //=== Start bagian slider ====//
        $banners = ExtBannerMobile::where('is_active', true)->get();
        //=== Akhir bagian slider ====//

        //=== Start bagian chart Jumlah Sekolah ====//
        $jenjangList = RefJenjangPendidikan::orderBy('kode')->pluck('kode', 'kode')->toArray();

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

        $gtk_wali_kelas = DB::table('mst_rombel as r')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'r.wali_kelas_ptk_id')
            ->select('s.kode_jenjang', 'g.id');

        $gtk_pembelajaran = DB::table('mst_pembelajaran as pb')
            ->join('mst_rombel as r', 'r.id', '=', 'pb.rombongan_belajar_id')
            ->join('mst_sekolah as s', 's.id', '=', 'r.sekolah_id')
            ->join('mst_gtk as g', 'g.id', '=', 'pb.gtk_id')
            ->select('s.kode_jenjang', 'g.id');

        $gtk_union = $gtk_wali_kelas->unionAll($gtk_pembelajaran);

        $gtk_data = DB::query()->fromSub($gtk_union, 'gtk_data')->get();

        $gtk_unique = $gtk_data->unique('id');

        $jumlah_guru = $gtk_unique->groupBy('kode_jenjang')
            ->map(fn($group) => $group->count())
            ->toArray();

        $total_guru = $gtk_unique->count();

        //=== Start bagian chart Sebaran Sekolah per Kecamatan ====//
        $sebaranSekolahKecamatan = DB::table('mst_sekolah')
            ->join('ref_wilayah', DB::raw("LEFT(mst_sekolah.kode_wilayah, 8)"), '=', 'ref_wilayah.kode')
            ->select('ref_wilayah.nama as kecamatan', DB::raw('COUNT(*) as jumlah'))
            ->whereRaw("LENGTH(REPLACE(ref_wilayah.kode, '.', '')) = 6")
            ->groupBy('ref_wilayah.nama')
            ->orderBy('ref_wilayah.nama')
            ->get();

        $kecamatanLabels = $sebaranSekolahKecamatan->pluck('kecamatan');
        $jumlahSekolahData = $sebaranSekolahKecamatan->pluck('jumlah');
        //=== Akhir bagian chart Sebaran Sekolah per Kecamatan ====//

        //=== Start bagian Akreditasi Sekolah ====//
        $akreditasiLabels = ['A', 'B', 'C', 'Belum Terakreditasi'];

        $colors = [
            'A' => '#28a745',
            'B' => '#ffc107',
            'C' => '#dc3545',
            'Belum Terakreditasi' => '#6c757d',
        ];

        $akreditasiByJenjang = [];

        foreach ($akreditasiLabels as $akreditasi) {
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $akreditasiByJenjang[$akreditasi][$nama_jenjang] = MstSekolah::where('kode_jenjang', $kode_jenjang)
                    ->where('akreditasi', $akreditasi)
                    ->count();
            }
        }

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

        $akreditasiJenjangLabels = array_values($jenjangList);
        //=== Akhir bagian Akreditasi Sekolah ====//

        //=== Start bagian Kualifikasi Pendidikan Guru ====//
        $pendidikanLabels = MstGtk::where('jenis_gtk', 'Guru')
            ->select('pend_terakhir')
            ->distinct()
            ->pluck('pend_terakhir')
            ->toArray();

        $gtkKualifikasiByJenjang = [];

        foreach ($pendidikanLabels as $pendidikan) {
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $gtkKualifikasiByJenjang[$pendidikan][$nama_jenjang] = MstGtk::where('jenis_gtk', 'Guru')
                    ->where('pend_terakhir', $pendidikan)
                    ->whereHas('sekolah_tempat_tugas', function ($q) use ($kode_jenjang) {
                        $q->where('kode_jenjang', $kode_jenjang);
                    })
                    ->count();
            }
        }

        // === Buat warna dinamis sesuai jumlah pendidikan === //
        $generateColors = function ($count) {
            $colors = [];
            for ($i = 0; $i < $count; $i++) {
                $hue = ($i * 360 / max(1, $count));
                $colors[] = "hsl($hue, 70%, 50%)";
            }
            return $colors;
        };

        $colorsList = $generateColors(count($pendidikanLabels));

        $gtkKualifikasiDatasets = [];
        foreach ($pendidikanLabels as $i => $pendidikan) {
            $data = [];
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $data[] = $gtkKualifikasiByJenjang[$pendidikan][$nama_jenjang] ?? 0;
            }

            $gtkKualifikasiDatasets[] = [
                'label' => $pendidikan,
                'data' => $data,
                'backgroundColor' => $colorsList[$i],
                'stack' => 'Stack 0'
            ];
        }

        $kualifikasiJenjangLabels = array_values($jenjangList);
        //=== Akhir bagian Kualifikasi Pendidikan Guru ====//


        //=== Start bagian informasi di beranda (berita, pengumuman, kegiatan) ====//
        $berita = ExtInformasi::where('kategori', 'Berita')
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        $pengumuman = ExtInformasi::where('kategori', 'Pengumuman')
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        $kegiatan = ExtInformasi::where('kategori', 'Kegiatan')
            ->orderBy('created_at', 'desc')
            ->paginate(1);
        //=== Akhir bagian informasi di beranda (berita, pengumuman, kegiatan) ====//

        //=== Start bagian Jumlah PTK ====//
        $gtk_all = DB::table('mst_gtk as g')
            ->join('mst_sekolah as s', 's.npsn', '=', 'g.tempat_tugas')
            ->select('s.kode_jenjang', 'g.id')
            ->where('g.status_keaktifan', 'Aktif')
            ->get();

        $jumlah_ptk = $gtk_all->groupBy('kode_jenjang')
            ->map(fn($group) => $group->count())
            ->toArray();

        $total_ptk = $gtk_all->count();
        //=== Akhir bagian Jumlah PTK ====//


        //=== Start bagian Kondisi Sarpras per Jenjang ====//
        $kondisiLabels = ['Baik', 'Rusak Ringan', 'Rusak Sedang', 'Rusak Berat'];
        $kondisiColors = [
            'Baik' => '#28a745',
            'Rusak Ringan' => '#ffc107',
            'Rusak Sedang' => '#fd7e14',
            'Rusak Berat' => '#dc3545',
        ];

        $kondisiSarprasByJenjang = [];

        $kondisiMap = [
            'Baik' => 'kondisi_baik',
            'Rusak Ringan' => 'kondisi_rusak_ringan',
            'Rusak Sedang' => 'kondisi_rusak_sedang',
            'Rusak Berat' => 'kondisi_rusak_berat',
        ];

        $kondisiSarprasByJenjang = [];

        foreach ($kondisiMap as $label => $kolomKondisi) {
            foreach ($jenjangList as $kode_jenjang => $nama_jenjang) {
                $jumlah = DB::table('mst_sarpras_sekolah as ss')
                    ->join('mst_sekolah as s', 'ss.sekolah_id', '=', 's.id')
                    ->where('s.kode_jenjang', $kode_jenjang)
                    ->sum(DB::raw("CAST(ss.{$kolomKondisi} AS INTEGER)"));

                $kondisiSarprasByJenjang[$label][$nama_jenjang] = $jumlah;
            }
        }

        // Siapkan dataset untuk
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

        $hasKondisiSarprasData = collect($kondisiSarprasDatasets)
            ->pluck('data')
            ->flatten()
            ->sum() > 0;
        //=== Akhir bagian Kondisi Sarpras per Jenjang ====//


        return view('frontend.pages.beranda', compact(
            'title',
            'banners',
            'kecamatanLabels',
            'jumlahSekolahData',
            'statistik',
            'jenjangList',
            'jumlah_peserta_didik',
            'total_peserta_didik',
            'jumlah_guru',
            'total_guru',
            'akreditasiLabels',
            'akreditasiDatasets',
            'akreditasiJenjangLabels',
            'gtkKualifikasiDatasets',
            'kualifikasiJenjangLabels',
            'jumlah_ptk',
            'total_ptk',
            'kondisiJenjangLabels',
            'kondisiSarprasDatasets',
            'kondisiLabels',
            'hasKondisiSarprasData',
            'kegiatan',
            'berita',
            'pengumuman',


        ));
    }
}
