<?php

namespace App\Filament\Resources\MstSekolahResource\Pages;

use App\Filament\Resources\MstSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstSekolahs extends ListRecords
{
    protected static string $resource = MstSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
