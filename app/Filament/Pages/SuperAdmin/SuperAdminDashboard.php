<?php

namespace App\Filament\Pages\SuperAdmin;

use Filament\Pages\Page;
use App\Filament\Widgets\PtkChart;
use App\Filament\Widgets\ActiveUsers;
use App\Filament\Widgets\LatestUsers;
use App\Filament\Widgets\SekolahChart;
use App\Filament\Widgets\LatestPengaduan;
use App\Filament\Widgets\PesertaDidikChart;
use App\Filament\Widgets\CustomDashboardStats;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SuperAdminDashboard extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard Superadmin';
    protected static ?string $navigationLabel = 'Dasbor';
    protected static ?string $slug = 'superadmin/dasbor';

    public function getHeading(): string
    {
        return 'Dasbor';
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\AdminDashboardStats::class,
            \App\Filament\Widgets\AdminSekolahChart::class,
            \App\Filament\Widgets\AdminPesertaDidikChart::class,
            \App\Filament\Widgets\AdminPtkChart::class,
            \App\Filament\Widgets\AdminLatestPengaduan::class,
            \App\Filament\Widgets\AdminLatestUsers::class,
            \App\Filament\Widgets\AdminActiveUsers::class,
        ];
    }
}
