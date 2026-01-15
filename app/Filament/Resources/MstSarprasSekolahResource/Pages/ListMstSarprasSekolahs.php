<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use App\Filament\Imports\MstSarprasSekolahImporter;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstSarprasSekolahs extends ListRecords
{
    protected static string $resource = MstSarprasSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Sarpras')
                ->icon('heroicon-o-plus')
                ->color('primary'),
            ImportAction::make()
                ->label('Impor Data Sarpras')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(MstSarprasSekolahImporter::class)
                ->color('success')
                ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'admin_sekolah'])),
        ];
    }
}
