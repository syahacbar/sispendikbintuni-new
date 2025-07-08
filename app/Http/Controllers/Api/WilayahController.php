<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WilayahController extends Controller
{
    public function getDistrikWithSchoolCounts()
    {
        // Ambil data distrik dan jumlah sekolah berdasarkan jenjang
        $data = DB::table('tbl_wilayahs as w')
            ->leftJoin('tbl_sekolahs as s', 'w.kode', '=', 's.kode_wilayah')
            ->select(
                'w.kode',
                'w.nama',
                DB::raw("COUNT(CASE WHEN s.jenjang = 'TK' THEN 1 END) as jumlah_tk"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'KB' THEN 1 END) as jumlah_kb"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'TPA' THEN 1 END) as jumlah_tpa"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SPS' THEN 1 END) as jumlah_sps"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'PKBM' THEN 1 END) as jumlah_pkbm"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SD' THEN 1 END) as jumlah_sd"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SMP' THEN 1 END) as jumlah_smp"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SMA' THEN 1 END) as jumlah_sma"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SMK' THEN 1 END) as jumlah_smk"),
                DB::raw("COUNT(CASE WHEN s.jenjang = 'SLB' THEN 1 END) as jumlah_slb"),
                DB::raw("COUNT(s.id) as total_sekolah")
            )
            ->whereRaw("LEFT(w.kode,6) = '92.06.'") // filter kode distrik saja (asumsi 6 digit)
            ->whereRaw("LENGTH(w.kode) = 8") // filter kode distrik saja (asumsi 6 digit)
            ->groupBy('w.kode', 'w.nama')
            ->orderBy('w.nama')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
