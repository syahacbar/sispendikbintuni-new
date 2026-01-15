<?php

namespace App\Filament\Resources\MstAnggotaRombelResource\Pages;

use App\Filament\Resources\MstAnggotaRombelResource;
use App\Filament\Imports\MstAnggotaRombelImporter;
use Filament\Actions;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstAnggotaRombels extends ListRecords
{
    protected static string $resource = MstAnggotaRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data Anggota')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
            ImportAction::make()
                ->label('Impor Anggota Rombel')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(MstAnggotaRombelImporter::class)
                ->color('success')
                ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'admin_sekolah'])),
        ];
    }
}
