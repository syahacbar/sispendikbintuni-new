<?php

namespace App\Filament\Widgets;

use App\Models\MstSekolah;
use App\Models\Sekolah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SekolahChart extends ChartWidget
{
    // use HasPageShield;

    protected static ?string $heading = 'Perbandingan Sekolah per Jenjang';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = MstSekolah::select('kode_jenjang', DB::raw('count(*) as total'))
            ->groupBy('kode_jenjang')
            ->orderBy('kode_jenjang')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Sekolah',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => $data->pluck('kode_jenjang'),
        ];
    }
}
