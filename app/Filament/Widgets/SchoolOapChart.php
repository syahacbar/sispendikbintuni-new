<?php

namespace App\Filament\Widgets;

use App\Models\MstPesertaDidik;
use Filament\Widgets\ChartWidget;

class SchoolOapChart extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Siswa OAP vs Non-OAP';
    protected static ?int $sort = 4;
    protected static ?string $maxHeight = '300px';

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        $user = auth()->user();

        // Validasi user sekolah
        if (!$user->hasRole('admin_sekolah') || !$user->sekolah) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $sekolah = $user->sekolah;

        // Get students from this school only
        $students = MstPesertaDidik::query()
            ->whereHas('rombels', function ($q) use ($sekolah) {
                $q->where('sekolah_id', $sekolah->id);
            })
            ->get();

        $oapCount = 0;
        $nonOapCount = 0;

        foreach ($students as $student) {
            if ($student->isOap()) {
                $oapCount++;
            } else {
                $nonOapCount++;
            }
        }

        $total = $oapCount + $nonOapCount;
        $oapPercentage = $total > 0 ? round(($oapCount / $total) * 100, 1) : 0;
        $nonOapPercentage = $total > 0 ? round(($nonOapCount / $total) * 100, 1) : 0;

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Siswa',
                    'data' => [$oapCount, $nonOapCount],
                    'backgroundColor' => [
                        '#10b981', // Green for OAP
                        '#3b82f6', // Blue for Non-OAP
                    ],
                ],
            ],
            'labels' => [
                "OAP ({$oapPercentage}%)",
                "Non-OAP ({$nonOapPercentage}%)",
            ],
        ];
    }
}
