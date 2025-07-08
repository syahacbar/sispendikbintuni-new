<?php

namespace App\Filament\Resources\SarprasResource\Pages;

use App\Filament\Resources\SarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSarpras extends ListRecords
{
    protected static string $resource = SarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
