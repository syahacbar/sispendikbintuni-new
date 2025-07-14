<?php


// app/Helpers/PengaturanHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class PengaturanHelper
{
    // public static function get($key, $default = null)
    // {
    //     return Cache::rememberForever("pengaturan_umum_$key", function () use ($key) {
    //         return DB::table('tbl_pengaturan_umums')->where('key', $key)->value('value');
    //     }) ?? $default;
    // }

    public static function clearCache($key)
    {
        Cache::forget("pengaturan_umum_$key");
    }
}
