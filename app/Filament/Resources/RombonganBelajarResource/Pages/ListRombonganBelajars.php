<?php

namespace App\Filament\Resources\RombonganBelajarResource\Pages;

use App\Filament\Resources\RombonganBelajarResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRombonganBelajars extends ListRecords
{
    protected static string $resource = RombonganBelajarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
