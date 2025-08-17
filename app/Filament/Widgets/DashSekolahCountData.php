<?php

namespace App\Filament\Widgets;

use App\Models\Ptk;
use App\Models\User;
use App\Models\MstGtk;
use App\Models\Sarana;
use App\Models\Sekolah;
use App\Models\RefMapel;
use App\Models\MstRombel;
use App\Models\MstSekolah;
use App\Models\RefSarpras;
use App\Models\ExtInformasi;
use App\Models\ExtPengaduan;
use App\Models\PesertaDidik;
use App\Models\RefKurikulum;
use Filament\Widgets\Widget;
use App\Models\MstPesertaDidik;
use App\Models\RombonganBelajar;
use App\Models\MstSarprasSekolah;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class DashSekolahCountData extends Widget
{
    // use HasPageShield;

    protected static string $view = 'filament.widgets.custom-dashboard-stats';

    public function getViewData(): array
    {
        $user = auth()->user();

        // Default (global count)
        $totalSekolah = MstSekolah::count();
        $totalPesertaDidik = MstPesertaDidik::count();
        $totalGtk = MstGtk::count();
        $totalSarpras = MstSarprasSekolah::count();

        // Kalau role admin_sekolah → filter
        if ($user->hasRole('admin_sekolah') && $user->sekolah) {
            $sekolah = $user->sekolah;

            // GTK → filter by tempat_tugas = npsn
            $totalGtk = MstGtk::where('tempat_tugas', $sekolah->npsn)->count();

            // Peserta didik → filter lewat rombel yang punya sekolah_id = sekolah.id
            $totalPesertaDidik = MstPesertaDidik::whereHas('rombels', function ($q) use ($sekolah) {
                $q->where('sekolah_id', $sekolah->id);
            })->count();

            // Sarpras → filter by sekolah_id
            $totalSarpras = MstSarprasSekolah::where('sekolah_id', $sekolah->id)->count();
        }

        return [
            'cards' => [
                [
                    'title' => 'Total Peserta Didik',
                    'value' => $totalPesertaDidik,
                ],
                [
                    'title' => 'Total PTK',
                    'value' => $totalGtk,
                ],
                [
                    'title' => 'Total Rombel',
                    'value' => MstRombel::count(),
                ],
                [
                    'title' => 'Total Sarana',
                    'value' => RefSarpras::count(),
                ],
                [
                    'title' => 'Total Prasarana',
                    'value' => $totalSarpras,
                ],
                [
                    'title' => 'Total Kurikulum',
                    'value' => RefKurikulum::count(),
                ],
                [
                    'title' => 'Total Mata pelajaran',
                    'value' => RefMapel::count(),
                ],
            ],
        ];
    }
}
