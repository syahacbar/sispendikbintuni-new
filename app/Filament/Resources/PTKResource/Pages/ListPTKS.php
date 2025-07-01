<?php

namespace App\Filament\Resources\PTKResource\Pages;

use App\Filament\Resources\PTKResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPTKS extends ListRecords
{
    protected static string $resource = PTKResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
