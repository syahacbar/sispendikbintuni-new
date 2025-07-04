<?php

namespace App\Filament\Resources\RombonganBelajarResource\Pages;

use App\Filament\Resources\RombonganBelajarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRombonganBelajar extends CreateRecord
{
    protected static string $resource = RombonganBelajarResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
