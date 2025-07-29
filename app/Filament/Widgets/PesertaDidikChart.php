<?php

namespace App\Filament\Widgets;

use App\Models\MstPesertaDidik;
use App\Models\PesertaDidik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PesertaDidikChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Peserta Didik per Jenjang';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = MstPesertaDidik::select('kode_wilayah', DB::raw('count(*) as total'))
            ->groupBy('kode_wilayah')
            ->orderBy('kode_wilayah')
            ->get();


        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peserta Didik',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#3b82f6',
                        '#10b981',
                        '#f59e0b',
                        '#ef4444',
                    ],
                ],
            ],
            'labels' => $data->pluck('kode_wilayah'),
        ];
    }
}
