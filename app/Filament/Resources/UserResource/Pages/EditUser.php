<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Actions;
use App\Models\MstSekolah;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        if ($this->data['sekolah_id'] ?? false) {
            MstSekolah::where('users_id', $this->record->id)->update(['users_id' => null]);

            // set sekolah baru
            MstSekolah::where('id', $this->data['sekolah_id'])
                ->update(['users_id' => $this->record->id]);
        }
    }
}
