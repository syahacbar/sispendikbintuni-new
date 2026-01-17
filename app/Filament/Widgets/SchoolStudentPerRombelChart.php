<?php

namespace App\Filament\Widgets;

use App\Models\MstRombel;
use Filament\Widgets\ChartWidget;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;

class SchoolStudentPerRombelChart extends ChartWidget
{
    use HasWidgetShield;

    protected static ?string $heading = 'Jumlah Peserta Didik per Rombel';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $user = auth()->user();

        if (!$user || !$user->hasRole('admin_sekolah') || !$user->sekolah) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $sekolahId = $user->sekolah->id;

        $data = MstRombel::where('sekolah_id', $sekolahId)
            ->withCount('pesertaDidiks')
            ->get()
            ->map(function ($rombel) {
                return [
                    'label' => $rombel->nama,
                    'count' => $rombel->peserta_didiks_count,
                ];
            });

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peserta Didik',
                    'data' => $data->pluck('count')->toArray(),
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
