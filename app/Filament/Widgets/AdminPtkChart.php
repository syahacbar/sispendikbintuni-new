<?php

namespace App\Filament\Widgets;

use App\Models\MstGtk;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class AdminPtkChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik GTK';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $data = DB::table('mst_gtk')
            ->select('mst_sekolah.nama', DB::raw('count(*) as total'))
            ->join('mst_sekolah', 'mst_gtk.tempat_tugas', '=', 'mst_sekolah.npsn')
            ->groupBy('mst_sekolah.nama')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah GTK per Sekolah',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => '#10b981',
                ],
            ],
            'labels' => $data->pluck('nama'),
        ];
    }
}
