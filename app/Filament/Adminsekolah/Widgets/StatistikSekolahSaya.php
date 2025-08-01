<?php

namespace App\Filament\Adminsekolah\Widgets;

use App\Models\MstPesertaDidik;
use App\Models\MstRombel;
use App\Models\MstGtk;
use Filament\Widgets\Widget;

class StatistikSekolahSaya extends Widget
{
    protected static string $view = 'filament.adminsekolah.widgets.statistik-sekolah-saya';

    protected function getViewData(): array
    {
        $user = auth()->user();
        $sekolahId = $user->sekolah_id;

        // Ambil semua rombel dari sekolah user
        $rombelIds = MstRombel::where('sekolah_id', $sekolahId)->pluck('id');

        // Hitung jumlah siswa berdasarkan rombel
        $jumlahSiswa = MstPesertaDidik::whereIn('rombel_id', $rombelIds)->count();

        // Hitung jumlah GTK berdasarkan rombel
        $jumlahGuru = MstGtk::whereIn('rombel_id', $rombelIds)->count();

        return [
            'jumlahSiswa' => $jumlahSiswa,
            'jumlahGuru' => $jumlahGuru,
        ];
    }
}
