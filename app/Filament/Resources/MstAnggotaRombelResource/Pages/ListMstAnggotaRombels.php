<?php

namespace App\Filament\Resources\MstAnggotaRombelResource\Pages;

use App\Filament\Resources\MstAnggotaRombelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstAnggotaRombels extends ListRecords
{
    protected static string $resource = MstAnggotaRombelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
