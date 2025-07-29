<?php

namespace App\Filament\Resources\MstPembelajaranResource\Pages;

use App\Filament\Resources\MstPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMstPembelajarans extends ListRecords
{
    protected static string $resource = MstPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
