<?php

namespace App\Filament\Widgets;

use App\Models\Informasi;
use App\Models\Kurikulum;
use App\Models\MataPelajaran;
use App\Models\Ptk;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Pengaduan;
use App\Models\PesertaDidik;
use App\Models\Prasarana;
use App\Models\RombonganBelajar;
use App\Models\Sarana;
use Filament\Widgets\Widget;

class CustomDashboardStats extends Widget
{
    protected static string $view = 'filament.widgets.custom-dashboard-stats';
    // protected int | string | array $columnSpan = 'full';

    public function getViewData(): array
    {
        return [
            'cards' => [
                [
                    'title' => 'Total Sekolah',
                    'value' => Sekolah::count(),
                ],
                [
                    'title' => 'Total Peserta Didk',
                    'value' => PesertaDidik::count(),
                ],
                [
                    'title' => 'Total PTK',
                    'value' => Ptk::count(),
                ],
                [
                    'title' => 'Total Users',
                    'value' => User::count(),
                ],
                [
                    'title' => 'Active Users',
                    'value' => User::role(['super_admin', 'admin_dinas', 'admin_sekolah'])
                        ->whereIn('id', function ($query) {
                            $query->select('user_id')->from('sessions')->whereNotNull('user_id');
                        })->count(),
                ],
                [
                    'title' => 'Total Pengaduan',
                    'value' => Pengaduan::count(),
                ],
                [
                    'title' => 'Total Rombel',
                    'value' => RombonganBelajar::count(),
                ],
                [
                    'title' => 'Total Sarana',
                    'value' => Sarana::count(),
                ],
                [
                    'title' => 'Total Prasarana',
                    'value' => Prasarana::count(),
                ],
                [
                    'title' => 'Total Kurikulum',
                    'value' => Kurikulum::count(),
                ],
                [
                    'title' => 'Total Mata pelajaran',
                    'value' => MataPelajaran::count(),
                ],
                [
                    'title' => 'Total Informasi',
                    'value' => Informasi::count(),
                ],
            ],
        ];
    }
}
