<?php

namespace App\Filament\Widgets;

use App\Models\Sekolah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SekolahChart extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Sekolah per Jenjang';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = Sekolah::select('jenjang', DB::raw('count(*) as total'))
            ->groupBy('jenjang')
            ->orderBy('jenjang')
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
            'labels' => $data->pluck('jenjang'),
        ];
    }
}
