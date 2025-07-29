<?php

namespace App\Filament\Resources\ExtBannerMobileResource\Pages;

use App\Filament\Resources\ExtBannerMobileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtBannerMobiles extends ListRecords
{
    protected static string $resource = ExtBannerMobileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
