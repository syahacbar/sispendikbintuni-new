<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class UsersChart extends ChartWidget
{
    protected static ?string $heading = 'User Baru';
    protected static ?int $sort = 3;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        $period = request()->get('period', 'daily');

        $query = User::query();

        switch ($period) {
            case 'weekly':
                $data = $query
                    ->select(DB::raw("DATE_FORMAT(created_at, '%x-%v') as label"), DB::raw('COUNT(*) as total'))
                    ->groupBy('label')
                    ->orderBy('label')
                    ->take(8)
                    ->get();
                break;

            case 'monthly':
                $data = $query
                    ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m') as label"), DB::raw('COUNT(*) as total'))
                    ->groupBy('label')
                    ->orderBy('label')
                    ->take(12)
                    ->get();
                break;

            default: // daily
                $data = $query
                    ->select(DB::raw("DATE(created_at) as label"), DB::raw('COUNT(*) as total'))
                    ->groupBy('label')
                    ->orderBy('label')
                    ->take(14)
                    ->get();
                break;
        }

        return [
            'datasets' => [
                [
                    'label' => 'User Baru',
                    'data' => $data->pluck('total'),
                    'borderColor' => '#10b981', // hijau
                    'backgroundColor' => 'rgba(16, 185, 129, 0.2)',
                ],
            ],
            'labels' => $data->pluck('label'),
        ];
    }
}
