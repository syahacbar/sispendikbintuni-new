<?php

namespace App\Filament\Resources\MstKondisiSarprasResource\Pages;

use App\Filament\Resources\MstKondisiSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstKondisiSarpras extends ListRecords
{
    protected static string $resource = MstKondisiSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
