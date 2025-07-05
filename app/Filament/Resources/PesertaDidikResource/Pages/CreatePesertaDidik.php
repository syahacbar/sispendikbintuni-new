<?php

namespace App\Filament\Resources\PesertaDidikResource\Pages;

use App\Filament\Resources\PesertaDidikResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePesertaDidik extends CreateRecord
{
    protected static string $resource = PesertaDidikResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
