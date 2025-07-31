<?php

namespace App\Filament\Resources\RefWilayahResource\Pages;

use App\Filament\Resources\RefWilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefWilayahs extends ListRecords
{
    protected static string $resource = RefWilayahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
