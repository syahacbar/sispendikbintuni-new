<?php

namespace App\Filament\Resources\MstSarprasSekolahResource\Pages;

use App\Filament\Resources\MstSarprasSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListMstSarprasSekolahs extends ListRecords
{
    protected static string $resource = MstSarprasSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Sarpras')
                ->icon('heroicon-o-plus')
                ->color('primary'),
        ];
    }
}
