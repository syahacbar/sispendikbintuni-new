<?php

namespace App\Filament\Resources\RegistrasiPesertaDidikResource\Pages;

use App\Filament\Resources\RegistrasiPesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRegistrasiPesertaDidiks extends ListRecords
{
    protected static string $resource = RegistrasiPesertaDidikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
