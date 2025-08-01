<?php

namespace App\Filament\Resources\ExtBannerMobileResource\Pages;

use App\Filament\Resources\ExtBannerMobileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditExtBannerMobile extends EditRecord
{
    protected static string $resource = ExtBannerMobileResource::class;

    protected static ?string $title = 'Ubah Data Banner';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
