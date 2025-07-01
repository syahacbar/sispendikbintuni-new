<?php

namespace App\Filament\Resources\KurikulumResource\Pages;

use App\Filament\Resources\KurikulumResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKurikulums extends ListRecords
{
    protected static string $resource = KurikulumResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
