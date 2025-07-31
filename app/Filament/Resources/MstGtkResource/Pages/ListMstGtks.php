<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstGtks extends ListRecords
{
    protected static string $resource = MstGtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
