<?php


namespace App\Filament\Paneladmin\Pages;

use App\Models\MstSekolah;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Component;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Database\Eloquent\Model;
use Filament\Support\Exceptions\Halt;

class Register extends BaseRegister
{
    /**
     * ============================
     * FORM SCHEMA
     * ============================
     */
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                            $this->getNameFormComponent(),
                            $this->getEmailFormComponent(),
                            $this->getPasswordFormComponent(),
                            $this->getPasswordConfirmationFormComponent(),
                            $this->getSekolahFormComponent(),
                        ])
                    ->statePath('data'),
            ),
        ];
    }

    /**
     * ============================
     * DROPDOWN SEKOLAH
     * ============================
     */
    protected function getSekolahFormComponent(): Component
    {
        return Select::make('sekolah_id')
            ->label('Sekolah')
            ->options(
                MstSekolah::query()
                    ->whereNull('users_id') // 🔐 hanya sekolah belum punya akun
                    ->orderBy('nama')
                    ->pluck('nama', 'id')
            )
            ->searchable()
            ->preload()
            ->required();
    }

    /**
     * ============================
     * HANDLE REGISTRATION
     * ============================
     */
    protected function handleRegistration(array $data): Model
    {
        $sekolahId = $data['sekolah_id'];
        unset($data['sekolah_id']);

        // ⛔ Cegah sekolah dipakai ulang (race condition)
        if (MstSekolah::where('id', $sekolahId)->whereNotNull('users_id')->exists()) {
            throw Halt::make();
        }

        /** @var \App\Models\User $user */
        $user = parent::handleRegistration($data);

        // 🔗 Hubungkan user ke sekolah
        MstSekolah::where('id', $sekolahId)
            ->update([
                    'users_id' => $user->id,
                ]);

        // 🔐 Assign role Filament Shield
        $user->assignRole('admin_sekolah');

        return $user;
    }
}
