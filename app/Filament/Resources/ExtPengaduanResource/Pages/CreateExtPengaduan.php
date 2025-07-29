<?php

namespace App\Filament\Resources\ExtPengaduanResource\Pages;

use App\Filament\Resources\ExtPengaduanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtPengaduan extends CreateRecord
{
    protected static string $resource = ExtPengaduanResource::class;

    protected function getFormActions(): array
    {
        return [];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
