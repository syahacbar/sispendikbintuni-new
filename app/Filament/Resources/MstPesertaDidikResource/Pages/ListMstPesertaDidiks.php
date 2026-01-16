<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use App\Filament\Resources\MstPesertaDidikResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;
use App\Filament\Imports\MstPesertaDidikImporter;
use Filament\Actions\ImportAction;
use Filament\Forms\Components\Select;
use App\Models\MstRombel;

class ListMstPesertaDidiks extends ListRecords
{
    protected static string $resource = MstPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data Peserta Didik')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
            ImportAction::make()
                ->label('Impor Data Peserta Didik')
                ->modalHeading('Impor Peserta Didik')
                ->icon('heroicon-o-arrow-up-tray')
                ->importer(MstPesertaDidikImporter::class)
                ->color('success')
                ->visible(fn() => auth()->user()->hasAnyRole(['super_admin', 'admin_sekolah']))
        ];
    }
}
