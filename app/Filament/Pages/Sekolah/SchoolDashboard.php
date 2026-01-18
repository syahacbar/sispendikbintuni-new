<?php

namespace App\Filament\Pages\Sekolah;

use Filament\Pages\Page;
use App\Filament\Widgets\PtkChart;
use App\Filament\Widgets\SekolahChart;
use App\Filament\Widgets\PesertaDidikChart;
use App\Filament\Widgets\KualifikasiPtkChart;
use App\Filament\Widgets\DashSekolahCountData;
use App\Filament\Widgets\SchoolStudentGenderChart;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SchoolDashboard extends Page
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Dasbor';
    protected static string $view = 'filament.pages.dashboard';
    protected static ?string $title = 'Dashboard Sekolah';
    protected static ?string $slug = 'sekolah/dasbor';

    public function getHeading(): string
    {
        return 'Dasbor';
    }

    public function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\SchoolDashboardStats::class,
            \App\Filament\Widgets\SchoolStudentPerRombelChart::class,
            \App\Filament\Widgets\SchoolStudentGenderChart::class,
            \App\Filament\Widgets\SchoolOapChart::class,
            \App\Filament\Widgets\SchoolPtkChart::class,
            \App\Filament\Widgets\SchoolKualifikasiPtkChart::class,
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->hasRole('admin_sekolah');
    }
}
