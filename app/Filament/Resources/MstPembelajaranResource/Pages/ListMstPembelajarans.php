<?php

namespace App\Filament\Resources\MstPembelajaranResource\Pages;

use App\Filament\Resources\MstPembelajaranResource;
use App\Filament\Imports\MstPembelajaranImporter;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstPembelajarans extends ListRecords
{
    protected static string $resource = MstPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data Pemebelajaran')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
            Actions\ImportAction::make()
                ->importer(MstPembelajaranImporter::class)
                ->label('Import Data Pembelajaran')
                ->modalHeading('Impor Pembelajaran')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success'),
        ];
    }
}
