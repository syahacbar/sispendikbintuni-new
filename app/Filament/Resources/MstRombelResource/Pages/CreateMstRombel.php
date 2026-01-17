<?php

namespace App\Filament\Resources\MstRombelResource\Pages;

use App\Filament\Resources\MstRombelResource;
use App\Models\MstSekolah;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMstRombel extends CreateRecord
{
    protected static string $resource = MstRombelResource::class;

    protected static bool $canCreateAnother = false;


    public function getHeading(): string
    {
        return 'Tambah Data Rombel';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $user = auth()->user();

        // Jika admin_sekolah, auto-fill sekolah_id
        if ($user->hasRole('admin_sekolah')) {
            $sekolah = MstSekolah::where('users_id', $user->id)->first();

            if ($sekolah) {
                $data['sekolah_id'] = $sekolah->id;
            }
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

