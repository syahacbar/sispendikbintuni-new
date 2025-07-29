<?php

namespace App\Filament\Resources\RefKurikulumResource\Pages;

use App\Filament\Resources\RefKurikulumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefKurikulums extends ListRecords
{
    protected static string $resource = RefKurikulumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
