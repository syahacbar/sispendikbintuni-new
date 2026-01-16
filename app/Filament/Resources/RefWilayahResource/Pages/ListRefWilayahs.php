<?php

namespace App\Filament\Resources\RefWilayahResource\Pages;

use App\Filament\Resources\RefWilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Closure;

class ListRefWilayahs extends ListRecords
{
    protected static string $resource = RefWilayahResource::class;

    public function getHeading(): string
    {
        return 'Data Wilayah';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Wilayah')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
