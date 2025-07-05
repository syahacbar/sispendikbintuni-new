<?php

namespace App\Filament\Widgets;

use App\Models\Ptk;
use App\Models\Tag;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\Pengaduan;
use App\Models\PesertaDidik;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class DashboardStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total Users', User::count())
                ->description('Jumlah seluruh pengguna')
                ->icon('heroicon-o-users'),

            Card::make('Total Pengaduan', Pengaduan::count())
                ->description('Jumlah seluruh laporan')
                ->icon('heroicon-o-document-text'),

            Card::make('Active Users', User::role(['super_admin', 'admin_dinas', 'admin_sekolah'])
                ->whereIn('id', function ($query) {
                    $query->select('user_id')
                        ->from('sessions')
                        ->whereNotNull('user_id');
                })
                ->count())
                ->description('User yang aktif saat ini')
                ->icon('heroicon-o-users'),

            Card::make('Total Sekolah', Sekolah::count())
                ->description('Jumlah seluruh sekolah')
                ->icon('heroicon-o-document-text'),

            Card::make('Total PTK', Ptk::count())
                ->description('Jumlah seluruh PTK')
                ->icon('heroicon-o-document-text'),

            Card::make('Total Peserta Didik', PesertaDidik::count())
                ->description('Jumlah seluruh Peserta Didik')
                ->icon('heroicon-o-document-text'),
        ];
    }
}
