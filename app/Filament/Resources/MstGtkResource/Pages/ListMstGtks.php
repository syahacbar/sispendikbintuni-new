<?php

namespace App\Filament\Resources\MstGtkResource\Pages;

use App\Filament\Resources\MstGtkResource;
use App\Models\MstSekolah;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions;

class ListMstGtks extends ListRecords
{
    protected static string $resource = MstGtkResource::class;

    public function getHeading(): string
    {
        return 'Data GTK';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Tambah Data GTK')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->createAnother(false),
        ];
    }
}
