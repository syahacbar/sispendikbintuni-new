<?php

namespace App\Filament\Resources\RefJenisGtkResource\Pages;

use App\Filament\Resources\RefJenisGtkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRefJenisGtks extends ListRecords
{
    protected static string $resource = RefJenisGtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
