<?php

namespace App\Filament\Resources\RefJenjangPendidikanResource\Pages;

use App\Filament\Resources\RefJenjangPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefJenjangPendidikans extends ListRecords
{
    protected static string $resource = RefJenjangPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
