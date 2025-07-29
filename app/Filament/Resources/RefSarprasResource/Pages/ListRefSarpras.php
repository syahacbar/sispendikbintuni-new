<?php

namespace App\Filament\Resources\RefSarprasResource\Pages;

use App\Filament\Resources\RefSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefSarpras extends ListRecords
{
    protected static string $resource = RefSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
