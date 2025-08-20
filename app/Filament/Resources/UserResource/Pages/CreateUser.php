<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\MstSekolah;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        if ($this->data['sekolah_id'] ?? false) {
            MstSekolah::where('id', $this->data['sekolah_id'])
                ->update(['users_id' => $this->record->id]);
        }
    }
}
