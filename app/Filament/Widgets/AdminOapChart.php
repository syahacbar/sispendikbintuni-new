<?php

namespace App\Filament\Widgets;

use App\Models\MstPesertaDidik;
use Filament\Widgets\ChartWidget;

class AdminOapChart extends ChartWidget
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
        return \Illuminate\Support\Facades\Cache::remember('admin_oap_chart_data', 60 * 60, function () {
            // Keywords for fallback matching (lower case for case insensitive check in SQL if needed, 
            // but usually LIKE is case insensitive in MySQL/Postgres default collations)
            $papuaKeywords = [
                'Papua',
                'Bintuni',
                'Sorong',
                'Manokwari',
                'Jayapura',
                'Merauke',
                'Nabire',
                'Timika',
                'Fakfak',
                'Kaimana',
                'Wamena',
                'Biak',
                'Serui',
                'Ransiki'
            ];

            // Build SQL for keywords
            $keywordSql = implode(' OR ', array_map(fn($k) => "tempat_lahir LIKE '%$k%'", $papuaKeywords));

            $data = \Illuminate\Support\Facades\DB::table('mst_peserta_didik')
                ->select(\Illuminate\Support\Facades\DB::raw("
                    SUM(CASE 
                        WHEN kode_wilayah IS NOT NULL AND kode_wilayah != '' THEN 
                            CASE WHEN REPLACE(kode_wilayah, '.', '') LIKE '91%' 
                                   OR REPLACE(kode_wilayah, '.', '') LIKE '92%'
                                   OR REPLACE(kode_wilayah, '.', '') LIKE '93%'
                                   OR REPLACE(kode_wilayah, '.', '') LIKE '94%'
                                   OR REPLACE(kode_wilayah, '.', '') LIKE '95%'
                            THEN 1 ELSE 0 END
                        ELSE 
                            CASE WHEN $keywordSql THEN 1 ELSE 0 END
                    END) as oap_count
                "), \Illuminate\Support\Facades\DB::raw('COUNT(*) as total'))
                ->first();

            $oapCount = (int) $data->oap_count;
            $total = (int) $data->total;
            $nonOapCount = $total - $oapCount;

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
        });
    }
}
