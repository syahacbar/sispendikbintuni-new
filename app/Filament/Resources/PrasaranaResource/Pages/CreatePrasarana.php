<?php

namespace App\Filament\Resources\PrasaranaResource\Pages;

use App\Filament\Resources\PrasaranaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePrasarana extends CreateRecord
{
    protected static string $resource = PrasaranaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
