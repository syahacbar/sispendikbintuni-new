<?php

namespace App\Filament\Resources\AnggotaRombelResource\Pages;

use App\Filament\Resources\AnggotaRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnggotaRombels extends ListRecords
{
    protected static string $resource = AnggotaRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
