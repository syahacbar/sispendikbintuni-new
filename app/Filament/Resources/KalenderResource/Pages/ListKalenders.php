<?php

namespace App\Filament\Resources\KalenderResource\Pages;

use App\Filament\Resources\KalenderResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKalenders extends ListRecords
{
    protected static string $resource = KalenderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
