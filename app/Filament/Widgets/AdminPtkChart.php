<?php

namespace App\Filament\Widgets;

use App\Models\MstGtk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AdminPtkChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik GTK';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $user = auth()->user();

        $query = MstGtk::query();

        // Filter hanya sekolah user login
        if ($user->hasRole('admin_sekolah') && $user->sekolah) {
            $query->where('tempat_tugas', $user->sekolah->npsn);
        }

        $data = $query
            ->select('status_kepegawaian', DB::raw('count(*) as total'))
            ->groupBy('status_kepegawaian')
            ->orderBy('status_kepegawaian')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah GTK',
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
