<?php

namespace App\Filament\Resources\ExtBannerMobileResource\Pages;

use App\Filament\Resources\ExtBannerMobileResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExtBannerMobile extends CreateRecord
{
    protected static string $resource = ExtBannerMobileResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
