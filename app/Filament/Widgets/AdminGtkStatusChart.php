<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;

class AdminGtkStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Status Kepegawaian GTK';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('admin_gtk_status_chart', 60 * 60, function () {
            $data = DB::table('mst_gtk')
                ->select('status_kepegawaian', DB::raw('count(*) as total'))
                ->whereNotNull('status_kepegawaian')
                ->where('status_kepegawaian', '!=', '')
                ->groupBy('status_kepegawaian')
                ->orderBy('total', 'desc')
                ->get();

            return [
                'datasets' => [
                    [
                        'label' => 'Jumlah GTK',
                        'data' => $data->pluck('total'),
                        'backgroundColor' => [
                            '#3b82f6', // Blue
                            '#10b981', // Emerald
                            '#f59e0b', // Amber
                            '#ef4444', // Red
                            '#8b5cf6', // Violet
                            '#ec4899', // Pink
                            '#6366f1', // Indigo
                        ],
                    ],
                ],
                'labels' => $data->pluck('status_kepegawaian'),
            ];
        });
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
