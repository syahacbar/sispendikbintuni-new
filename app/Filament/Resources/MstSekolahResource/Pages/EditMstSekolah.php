<?php

namespace App\Filament\Resources\MstSekolahResource\Pages;

use App\Filament\Resources\MstSekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMstSekolah extends EditRecord
{
    protected static string $resource = MstSekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Ubah Data Sekolah';
    }

    public function getHeading(): string
    {
        return 'Data Sekolah';
    }
}
