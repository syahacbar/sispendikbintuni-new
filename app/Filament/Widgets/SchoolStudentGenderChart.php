<?php

namespace App\Filament\Widgets;

use App\Models\MstPesertaDidik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SchoolStudentGenderChart extends ChartWidget
{
    protected static ?string $heading = 'Grafik Gender Siswa';
    protected static ?int $sort = 3;
    protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getData(): array
    {
        $user = auth()->user();

        // Validasi user sekolah
        if (!$user->hasRole('admin_sekolah') || !$user->sekolah) {
            // Return empty or global stats if needed, but this widget is intended for DashboardSekolah
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $sekolah = $user->sekolah;

        $data = MstPesertaDidik::query()
            ->whereHas('rombels', function ($q) use ($sekolah) {
                $q->where('sekolah_id', $sekolah->id);
            })
            ->select('jenis_kelamin', DB::raw('count(*) as total'))
            ->groupBy('jenis_kelamin')
            ->orderBy('jenis_kelamin')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => [
                        '#3b82f6', // Blue
                        '#ec4899', // Pink
                    ],
                ],
            ],
            'labels' => $data->pluck('jenis_kelamin')->map(function ($val) {
                return $val == 'L' ? 'Laki-laki' : ($val == 'P' ? 'Perempuan' : $val);
            }),
        ];
    }
}
