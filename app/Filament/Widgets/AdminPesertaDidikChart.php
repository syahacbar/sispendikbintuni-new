<?php

namespace App\Filament\Widgets;

use data;
use App\Models\RefWilayah;
use App\Models\PesertaDidik;
use App\Models\MstPesertaDidik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class AdminPesertaDidikChart extends ChartWidget
{

    // use HasPageShield;
    protected static ?string $heading = 'Grafik Peserta Didik';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        return \Illuminate\Support\Facades\Cache::remember('admin_peserta_didik_chart', 60 * 60, function () {
            // Join through rombel to school to group students by school
            $data = DB::table('mst_peserta_didik')
                ->select('mst_sekolah.nama', DB::raw('count(distinct mst_peserta_didik.id) as total'))
                ->join('mst_anggota_rombel', 'mst_peserta_didik.id', '=', 'mst_anggota_rombel.peserta_didik_id')
                ->join('mst_rombel', 'mst_anggota_rombel.rombel_id', '=', 'mst_rombel.id')
                ->join('mst_sekolah', 'mst_rombel.sekolah_id', '=', 'mst_sekolah.id')
                ->groupBy('mst_sekolah.nama')
                ->orderBy('total', 'desc')
                ->get();

            return [
                'datasets' => [
                    [
                        'label' => 'Jumlah Peserta Didik per Sekolah',
                        'data' => $data->pluck('total'),
                        'backgroundColor' => '#3b82f6',
                    ],
                ],
                'labels' => $data->pluck('nama'),
            ];
        });
    }
}
