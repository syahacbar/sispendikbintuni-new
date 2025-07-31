<?php

namespace App\Filament\Resources\MstPesertaDidikResource\Pages;

use App\Filament\Resources\MstPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstPesertaDidiks extends ListRecords
{
    protected static string $resource = MstPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
