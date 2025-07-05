<?php

namespace App\Filament\Resources\KelompokMapelResource\Pages;

use App\Filament\Resources\KelompokMapelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKelompokMapel extends CreateRecord
{
    protected static string $resource = KelompokMapelResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
