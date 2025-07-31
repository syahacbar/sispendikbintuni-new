<?php

namespace App\Filament\Resources\MstRombelResource\Pages;

use App\Filament\Resources\MstRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstRombels extends ListRecords
{
    protected static string $resource = MstRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
