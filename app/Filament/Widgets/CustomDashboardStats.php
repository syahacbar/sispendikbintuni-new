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

class CustomDashboardStats extends Widget
{
    // use HasPageShield;

    protected static string $view = 'filament.widgets.custom-dashboard-stats';

    // public function getViewData(): array
    // {
    //     return [
    //         'cards' => [
    //             [
    //                 'title' => 'Total Sekolah',
    //                 'value' => MstSekolah::count(),
    //             ],
    //             [
    //                 'title' => 'Total Peserta Didk',
    //                 'value' => MstPesertaDidik::count(),
    //             ],
    //             [
    //                 'title' => 'Total PTK',
    //                 'value' => MstGtk::count(),
    //             ],
    //             [
    //                 'title' => 'Total Users',
    //                 'value' => User::count(),
    //             ],
    //             [
    //                 'title' => 'Active Users',
    //                 'value' => User::role(['super_admin', 'admin_dinas', 'admin_sekolah'])
    //                     ->whereIn('id', function ($query) {
    //                         $query->select('user_id')->from('sessions')->whereNotNull('user_id');
    //                     })->count(),
    //             ],
    //             [
    //                 'title' => 'Total Pengaduan',
    //                 'value' => ExtPengaduan::count(),
    //             ],
    //             [
    //                 'title' => 'Total Rombel',
    //                 'value' => MstRombel::count(),
    //             ],
    //             [
    //                 'title' => 'Total Sarana',
    //                 'value' => RefSarpras::count(),
    //             ],
    //             [
    //                 'title' => 'Total Prasarana',
    //                 'value' => MstSarprasSekolah::count(),
    //             ],
    //             [
    //                 'title' => 'Total Kurikulum',
    //                 'value' => RefKurikulum::count(),
    //             ],
    //             [
    //                 'title' => 'Total Mata pelajaran',
    //                 'value' => RefMapel::count(),
    //             ],
    //             [
    //                 'title' => 'Total Informasi',
    //                 'value' => ExtInformasi::count(),
    //             ],
    //         ],
    //     ];
    // }

    public function getViewData(): array
    {
        $totalSekolah = MstSekolah::count();
        $totalPesertaDidik = MstPesertaDidik::count();
        $totalGtk = MstGtk::count();
        $totalUsers = User::count();
        $activeUsers = User::role(['super_admin', 'admin_dinas', 'admin_sekolah'])
            ->whereIn('id', function ($query) {
                $query->select('user_id')->from('sessions')->whereNotNull('user_id');
            })->count();

        return [
            'cards' => [
                [
                    'title' => 'Total Sekolah',
                    'value' => $totalSekolah,
                    'icon' => 'heroicon-o-academic-cap',
                    'color' => 'primary',
                ],
                [
                    'title' => 'Total Peserta Didik',
                    'value' => $totalPesertaDidik,
                    'icon' => 'heroicon-o-users',
                    'color' => 'success',
                ],
                [
                    'title' => 'Total GTK',
                    'value' => $totalGtk,
                    'icon' => 'heroicon-o-user-group',
                    'color' => 'warning',
                ],
                [
                    'title' => 'Total Users',
                    'value' => $totalUsers,
                    'icon' => 'heroicon-o-user',
                    'color' => 'info',
                ],
                [
                    'title' => 'Active Users',
                    'value' => $activeUsers,
                    'icon' => 'heroicon-o-signal',
                    'color' => 'success',
                ],
                [
                    'title' => 'Total Pengaduan',
                    'value' => ExtPengaduan::count(),
                    'icon' => 'heroicon-o-chat-alt-2',
                    'color' => 'danger',
                ],
                [
                    'title' => 'Total Rombel',
                    'value' => MstRombel::count(),
                    'icon' => 'heroicon-o-collection',
                    'color' => 'success',
                ],
                [
                    'title' => 'Total Sarana',
                    'value' => RefSarpras::count(),
                    'icon' => 'heroicon-o-archive',
                    'color' => 'primary',
                ],
                [
                    'title' => 'Total Prasarana',
                    'value' => MstSarprasSekolah::count(),
                    'icon' => 'heroicon-o-office-building',
                    'color' => 'warning',
                ],
            ],
        ];
    }
}
