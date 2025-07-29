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
                    'value' => MstSekolah::count(),
                ],
                [
                    'title' => 'Total Peserta Didk',
                    'value' => MstPesertaDidik::count(),
                ],
                [
                    'title' => 'Total PTK',
                    'value' => MstGtk::count(),
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
                    'value' => ExtPengaduan::count(),
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
                    'value' => MstSarprasSekolah::count(),
                ],
                [
                    'title' => 'Total Kurikulum',
                    'value' => RefKurikulum::count(),
                ],
                [
                    'title' => 'Total Mata pelajaran',
                    'value' => RefMapel::count(),
                ],
                [
                    'title' => 'Total Informasi',
                    'value' => ExtInformasi::count(),
                ],
            ],
        ];
    }
}
