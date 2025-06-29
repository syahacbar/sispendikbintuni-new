<?php

namespace App\Filament\Resources\PrasaranaResource\Pages;

use App\Filament\Resources\PrasaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrasaranas extends ListRecords
{
    protected static string $resource = PrasaranaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
