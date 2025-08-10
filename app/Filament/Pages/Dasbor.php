<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Filament\Widgets\PtkChart;
use App\Filament\Widgets\ActiveUsers;
use App\Filament\Widgets\LatestUsers;
use App\Filament\Widgets\SekolahChart;
use App\Filament\Widgets\DashboardStats;
use App\Filament\Widgets\LatestPengaduan;
use App\Filament\Widgets\PesertaDidikChart;
use App\Filament\Widgets\CustomDashboardStats;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Dasbor extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard';

    public function getHeaderWidgets(): array
    {
        return [
            CustomDashboardStats::class,
            SekolahChart::class,
            PtkChart::class,
            PesertaDidikChart::class,
            LatestPengaduan::class,
            LatestUsers::class,
            ActiveUsers::class,
        ];
    }
}
