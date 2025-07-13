<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class PetaSebaranController extends Controller
{
    public function index()
    {
        $data = DB::table('tbl_sekolahs')
            ->select('id as sekolah_id', 'nama', 'jenjang', 'latitude as lat', 'longitude as lng')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json($data);
    }
}
