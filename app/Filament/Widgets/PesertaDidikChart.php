<?php

namespace App\Filament\Widgets;

use data;
use App\Models\RefWilayah;
use App\Models\PesertaDidik;
use App\Models\MstPesertaDidik;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class PesertaDidikChart extends ChartWidget
{

    // use HasPageShield;
    protected static ?string $heading = 'Grafik Peserta Didik per Jenjang';
    protected static ?int $sort = 2;

    protected function getType(): string
    {
        return 'line';
    }

    protected function getData(): array
    {
        // Join ke ref_wilayah untuk ambil nama kecamatan
        $data = DB::table('mst_peserta_didik')
            ->select('ref_wilayah.nama', DB::raw('count(*) as total'))
            ->join('ref_wilayah', 'mst_peserta_didik.kode_wilayah', '=', 'ref_wilayah.kode')
            ->whereRaw("LENGTH(REPLACE(mst_peserta_didik.kode_wilayah, '.', '')) = 6") // hanya kecamatan
            ->groupBy('ref_wilayah.nama')
            ->orderBy('ref_wilayah.nama')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peserta Didik',
                    'data' => $data->pluck('total'),
                    'backgroundColor' => '#3b82f6',
                ],
            ],
            'labels' => $data->pluck('nama'),
        ];
    }
}
