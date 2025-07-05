<?php

namespace App\Filament\Resources\JenisSarprasResource\Pages;

use App\Filament\Resources\JenisSarprasResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisSarpras extends CreateRecord
{
    protected static string $resource = JenisSarprasResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
