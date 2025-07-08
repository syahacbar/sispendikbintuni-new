<?php

namespace App\Filament\Resources\SarprasResource\Pages;

use App\Filament\Resources\SarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSarpras extends CreateRecord
{
    protected static string $resource = SarprasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
