<?php

namespace App\Filament\Resources\JenisSarprasResource\Pages;

use App\Filament\Resources\JenisSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisSarpras extends ListRecords
{
    protected static string $resource = JenisSarprasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
