<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use App\Filament\Resources\MstPesertaDidikResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class ListMstPesertaDidiks extends ListRecords
{
    protected static string $resource = MstPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Peserta Didik')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
