<?php

namespace App\Filament\Adminsekolah\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Adminsekolah\Widgets\StatistikSekolahSaya::class,
        ];
    }
}
