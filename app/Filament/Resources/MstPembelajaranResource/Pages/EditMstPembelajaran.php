<?php

namespace App\Filament\Resources\MstPembelajaranResource\Pages;

use App\Filament\Resources\MstPembelajaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstPembelajaran extends EditRecord
{
    protected static string $resource = MstPembelajaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
