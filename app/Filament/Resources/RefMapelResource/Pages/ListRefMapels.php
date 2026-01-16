<?php

namespace App\Filament\Resources\RefMapelResource\Pages;

use App\Filament\Resources\RefMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Closure;

class ListRefMapels extends ListRecords
{
    protected static string $resource = RefMapelResource::class;

    public function getHeading(): string
    {
        return 'Data Mata Pelajaran';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Mata Pelajaran')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
