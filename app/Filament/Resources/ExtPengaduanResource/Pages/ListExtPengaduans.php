<?php

namespace App\Filament\Resources\ExtPengaduanResource\Pages;

use App\Filament\Resources\ExtPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtPengaduans extends ListRecords
{
    protected static string $resource = ExtPengaduanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
