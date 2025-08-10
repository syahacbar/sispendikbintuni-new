<?php

namespace App\Filament\Widgets;

use App\Models\MstGtk;
use App\Models\Ptk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class PtkChart extends ChartWidget
{
    // use HasPageShield;

    protected static ?string $heading = 'Grafik GTK by Status';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = MstGtk::select('status_kepegawaian', DB::raw('count(*) as total'))
            ->groupBy('status_kepegawaian')
            ->orderBy('status_kepegawaian')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Ptk',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => $data->pluck('status_kepegawaian'),
        ];
    }
}
