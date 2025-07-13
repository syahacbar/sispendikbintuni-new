<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function distrikList()
{
    $cachedData = Cache::remember('api_distrik_list', now()->addMinutes(10), function () {
        $jenjangList = ['TK','KB','TPA','SPS','PKBM','SKB','SD','SMP','SMA','SMK','SLB'];

        $distrik = DB::table('tbl_wilayahs')
            ->whereRaw('CHAR_LENGTH(kode) = 8')
            ->where('kode', 'like', '92.06.%')
            ->get();

        $total_negeri = 0;
        $total_swasta = 0;
        $rekap_jenjang = [];

        // Inisialisasi rekap_jenjang
        foreach ($jenjangList as $j) {
            $rekap_jenjang[$j] = ['negeri' => 0, 'swasta' => 0, 'total' => 0];
        }

        $data = [];

        foreach ($distrik as $item) {
            $result = [
                'kode' => $item->kode,
                'nama' => $item->nama,
            ];

            $negeri_distrik = 0;
            $swasta_distrik = 0;

            foreach ($jenjangList as $jenjang) {
                $negeri = DB::table('tbl_sekolahs')
                    ->where('kode_wilayah', $item->kode)
                    ->where('jenjang', $jenjang)
                    ->where('status_sekolah', 'Negeri')
                    ->count();

                $swasta = DB::table('tbl_sekolahs')
                    ->where('kode_wilayah', $item->kode)
                    ->where('jenjang', $jenjang)
                    ->where('status_sekolah', 'Swasta')
                    ->count();

                // Simpan ke per distrik
                $result[$jenjang] = [
                    'negeri' => $negeri,
                    'swasta' => $swasta,
                    'total' => $negeri + $swasta,
                ];

                // Tambahkan ke total distrik
                $negeri_distrik += $negeri;
                $swasta_distrik += $swasta;

                // Tambahkan ke rekap jenjang global
                $rekap_jenjang[$jenjang]['negeri'] += $negeri;
                $rekap_jenjang[$jenjang]['swasta'] += $swasta;
                $rekap_jenjang[$jenjang]['total'] += ($negeri + $swasta);
            }

            $result['total_negeri'] = $negeri_distrik;
            $result['total_swasta'] = $swasta_distrik;
            $result['total_semua'] = $negeri_distrik + $swasta_distrik;

            $total_negeri += $negeri_distrik;
            $total_swasta += $swasta_distrik;

            $data[] = $result;
        }

        return [
            'total_negeri' => $total_negeri,
            'total_swasta' => $total_swasta,
            'total_semua' => $total_negeri + $total_swasta,
            'rekap_jenjang' => $rekap_jenjang,
            'data' => $data
        ];
    });

    return response()->json([
        'status' => 'success',
        'total_negeri' => $cachedData['total_negeri'],
        'total_swasta' => $cachedData['total_swasta'],
        'total_semua' => $cachedData['total_semua'],
        'rekap_jenjang' => $cachedData['rekap_jenjang'],
        'data' => $cachedData['data']
    ]);
}

}
