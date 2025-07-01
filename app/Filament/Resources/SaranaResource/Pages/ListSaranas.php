<?php

namespace App\Filament\Resources\SaranaResource\Pages;

use App\Filament\Resources\SaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSaranas extends ListRecords
{
    protected static string $resource = SaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
