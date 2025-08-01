<?php

namespace App\Filament\Adminsekolah\Resources\SekolahResource\Pages;

use App\Filament\Adminsekolah\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSekolahs extends ListRecords
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
