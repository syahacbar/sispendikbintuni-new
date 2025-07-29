<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstSarprasSekolahs extends ListRecords
{
    protected static string $resource = MstSarprasSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
