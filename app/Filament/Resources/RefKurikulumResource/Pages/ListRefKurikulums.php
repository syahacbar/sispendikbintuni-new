<?php

namespace App\Filament\Resources\RefKurikulumResource\Pages;

use App\Filament\Resources\RefKurikulumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Closure;
class ListRefKurikulums extends ListRecords
{
    protected static string $resource = RefKurikulumResource::class;

    public function getHeading(): string
    {
        return 'Data Kurikulum';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Kurikulum')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
