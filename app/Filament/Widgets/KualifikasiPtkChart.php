<?php

namespace App\Filament\Widgets;

use App\Models\MstGtk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KualifikasiPtkChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik GTK by Status Kepegawaian';
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
            ->select('pend_terakhir', DB::raw('count(*) as total'))
            ->groupBy('pend_terakhir')
            ->orderBy('pend_terakhir')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Grafik Pendidikan GTK',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => $data->pluck('pend_terakhir'),
        ];
    }
}
