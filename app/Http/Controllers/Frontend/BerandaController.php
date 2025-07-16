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
        $wilayahMap = Wilayah::whereIn('kode', $kecamatanCodes)->pluck('nama', 'kode');

        // 3. Siapkan data untuk Chart.js
        $kecamatanLabels = $sebaranSekolahKecamatan->map(
            fn($item) => $wilayahMap[$item->kode_wilayah] ?? $item->kode_wilayah
        );
        $jumlahSekolahData = $sebaranSekolahKecamatan->pluck('jumlah');

        return view('frontend.pages.beranda', compact(
            'statistik',
            'jenjangList',
            'jumlah_peserta_didik',
            'total_peserta_didik',
            'jumlah_guru',
            'total_guru',


            'kecamatanLabels',
            'jumlahSekolahData',
        ));
    }
}
