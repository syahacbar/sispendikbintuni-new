<?php

namespace App\Filament\Resources\PTKResource\Pages;

use App\Filament\Resources\PTKResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePTK extends CreateRecord
{
    protected static string $resource = PTKResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
