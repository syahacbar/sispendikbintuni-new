<?php

namespace App\Filament\Resources\ExtBannerMobileResource\Pages;

use App\Filament\Resources\ExtBannerMobileResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExtBannerMobiles extends ListRecords
{
    protected static string $resource = ExtBannerMobileResource::class;

    public function getHeading(): string
    {
        return 'Banner Mobile';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Banner')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
