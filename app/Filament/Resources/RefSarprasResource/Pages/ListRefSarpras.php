<?php

namespace App\Filament\Resources\RefSarprasResource\Pages;

use App\Filament\Resources\RefSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Closure;

class ListRefSarpras extends ListRecords
{
    protected static string $resource = RefSarprasResource::class;

    public function getHeading(): string
    {
        return 'Data Jenis Sarpras';
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return null;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Jenis Sarpras')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
