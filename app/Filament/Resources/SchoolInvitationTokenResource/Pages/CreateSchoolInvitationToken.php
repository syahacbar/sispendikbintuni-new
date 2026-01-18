<?php

namespace App\Filament\Resources\SchoolInvitationTokenResource\Pages;

use App\Filament\Resources\SchoolInvitationTokenResource;
use App\Models\SchoolInvitationToken;
use App\Mail\SchoolInvitationMail;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class CreateSchoolInvitationToken extends CreateRecord
{
    protected static string $resource = SchoolInvitationTokenResource::class;

    protected static bool $canCreateAnother = false;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    public function getHeading(): string
    {
        return 'Tambah Token Undangan';
    }

    /**
     * Mutate data sebelum create
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate token unik
        $data['token'] = SchoolInvitationToken::generateUniqueToken(16);

        // Set creator
        $data['created_by_user_id'] = auth()->id();

        return $data;
    }

    /**
     * Hook setelah record dibuat
     */
    protected function afterCreate(): void
    {
        $record = $this->record;

        // Jika ada email, tawarkan untuk mengirim email
        if ($record->email) {
            Notification::make()
                ->title('Token berhasil dibuat!')
                ->body("Token: {$record->token}. Gunakan tombol 'Kirim Email' untuk mengirim undangan.")
                ->success()
                ->seconds(10)
                ->send();
        } else {
            Notification::make()
                ->title('Token berhasil dibuat!')
                ->body("Token: {$record->token}. Salin dan bagikan token ini kepada calon operator.")
                ->success()
                ->seconds(10)
                ->send();
        }
    }
}
