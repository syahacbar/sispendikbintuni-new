<?php

namespace App\Filament\Resources\MstRombelResource\Pages;

use App\Filament\Resources\MstRombelResource;
use App\Filament\Imports\MstRombelImporter;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListMstRombels extends ListRecords
{
    protected static string $resource = MstRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Data Rombel')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->color('primary')
                ->createAnother(false),
            ImportAction::make()
                ->label('Impor Data Rombel')
                ->modalHeading('Impor Rombel')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(MstRombelImporter::class)
                ->color('success')
                ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'admin_sekolah'])),
        ];
    }
}
