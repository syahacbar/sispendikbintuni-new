<?php

namespace App\Filament\Resources\InformasiResource\Pages;

use App\Filament\Resources\InformasiResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateInformasi extends CreateRecord
{
    protected static string $resource = InformasiResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
