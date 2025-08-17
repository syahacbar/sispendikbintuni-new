<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\PtkChart;
use App\Filament\Widgets\ActiveUsers;
use App\Filament\Widgets\LatestUsers;
use App\Filament\Widgets\SekolahChart;
use App\Filament\Widgets\LatestPengaduan;
use App\Filament\Widgets\PesertaDidikChart;
use App\Filament\Widgets\KualifikasiPtkChart;
use App\Filament\Widgets\CustomDashboardStats;
use App\Filament\Widgets\DashSekolahCountData;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class DashboardSekolah extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Dasbor';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard Sekolah';

    public function getHeaderWidgets(): array
    {
        return [
            DashSekolahCountData::class,
            PtkChart::class,
            KualifikasiPtkChart::class,
        ];
    }
}
