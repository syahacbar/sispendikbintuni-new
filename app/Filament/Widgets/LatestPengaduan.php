<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Pengaduan;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPengaduan extends BaseWidget
{
    protected static ?string $heading = '5 Pengaduan Terbaru';
    protected static ?int $sort = 4;

    protected function getTableQuery(): Builder
    {
        return Pengaduan::query()->latest()->limit(5);
    }

    public function getTableRecordsPerPage(): int
    {
        return 5;
    }

    public function isTablePaginationEnabled(): bool
    {
        return false;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('nomor_laporan')->label('Nomor Laporan'),
            TextColumn::make('nama_pelapor')->label('Nama Pelapor'),
            TextColumn::make('email')->label('Email Pelapor'),
            TextColumn::make('no_hp')->label('No WA Pelapor'),
            TextColumn::make('kategori')->label('Kategori Laporan'),
            TextColumn::make('status')->badge()->label('Status'),
            TextColumn::make('created_at')->label('Tanggal')->dateTime('d M Y H:i'),
        ];
    }

    public function getColumnSpan(): int | string | array
    {
        return 'full';
    }
}
