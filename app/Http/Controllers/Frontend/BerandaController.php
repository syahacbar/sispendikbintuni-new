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


        // Tampilkan data statistik sekolah (semua, negeri dan swasra)
        $jenjangList = ['PAUD', 'SD', 'SMP', 'SMA', 'SMK', 'PKBM'];
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

        return view('frontend.pages.beranda', compact(
            'pengaturan',
            'statistik',
            'jenjangList',
        ));
    }
}
