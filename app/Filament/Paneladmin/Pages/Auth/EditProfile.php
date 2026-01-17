<?php

namespace App\Filament\Paneladmin\Pages\Auth;

use Filament\Pages\Auth\EditProfile as BaseEditProfile;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Auth;

class EditProfile extends BaseEditProfile
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Tambahkan placeholder untuk informasi sekolah
                Placeholder::make('connected_school')
                    ->label('Anda terhubung dengan')
                    ->content(function () {
                        $user = Auth::user();
                        $sekolah = $user->sekolah;

                        return $sekolah
                            ? $sekolah->nama
                            : '-';
                    }),

                // Form components default dari Filament
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
            ]);
    }
}
