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

class SchoolDashboardStats extends Widget
{
    // use HasPageShield;

    protected static string $view = 'filament.widgets.custom-dashboard-stats';

    public function getViewData(): array
    {
        $user = auth()->user();

        // Initialize counts to 0
        $totalPesertaDidik = 0;
        $totalGtk = 0;
        $totalRombel = 0;
        $totalSarpras = 0;

        // Validasi user memiliki sekolah
        if ($user->hasRole('admin_sekolah') && $user->sekolah) {
            $sekolah = $user->sekolah;

            // GTK: Filter by tempat_tugas = npsn
            $totalGtk = MstGtk::where('tempat_tugas', $sekolah->npsn)->count();

            // Peserta Didik: Filter via Rombel -> Sekolah
            $totalPesertaDidik = MstPesertaDidik::whereHas('rombels', function ($q) use ($sekolah) {
                $q->where('sekolah_id', $sekolah->id);
            })->count();

            // Rombel: Filter by sekolah_id
            $totalRombel = MstRombel::where('sekolah_id', $sekolah->id)->count();

            // Sarpras: Filter by sekolah_id
            $totalSarpras = MstSarprasSekolah::where('sekolah_id', $sekolah->id)->count();
        }

        return [
            'cards' => [
                [
                    'title' => 'Peserta Didik Saya',
                    'value' => $totalPesertaDidik,
                    'icon' => 'heroicon-o-users',
                    'color' => 'success',
                ],
                [
                    'title' => 'Guru & Tenaga Kependidikan',
                    'value' => $totalGtk,
                    'icon' => 'heroicon-o-user-group',
                    'color' => 'primary',
                ],
                [
                    'title' => 'Rombongan Belajar',
                    'value' => $totalRombel,
                    'icon' => 'heroicon-o-collection',
                    'color' => 'warning',
                ],
                [
                    'title' => 'Sarana & Prasarana',
                    'value' => $totalSarpras,
                    'icon' => 'heroicon-o-office-building',
                    'color' => 'info',
                ],
            ],
        ];
    }
}
