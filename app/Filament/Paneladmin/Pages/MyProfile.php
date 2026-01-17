<?php

namespace App\Filament\Paneladmin\Pages;

use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class MyProfile extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.my-profile';

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $title = 'Profil Saya';

    // Define custom route
    protected static string $routePath = 'my-profile';

    // Jangan tampilkan di sidebar navigation - akan diakses via User Menu
    protected static bool $shouldRegisterNavigation = false;

    public ?array $data = [];

    public function mount(): void
    {
        $user = Auth::user();

        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->schema([
                        // Informasi sekolah
                        Placeholder::make('connected_school')
                            ->label('Anda terhubung dengan')
                            ->content(function () {
                                $user = Auth::user();
                                $sekolah = $user->sekolah;

                                return $sekolah
                                    ? $sekolah->nama
                                    : '-';
                            })
                            ->columnSpanFull(),

                        // Form fields
                        TextInput::make('name')
                            ->label('Nama')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->label('Alamat email')
                            ->email()
                            ->disabled()
                            ->required()
                            ->maxLength(255),
                    ]),

                Section::make('Ubah Kata Sandi')
                    ->schema([
                        TextInput::make('current_password')
                            ->label('Kata sandi saat ini')
                            ->password()
                            ->revealable(),

                        TextInput::make('password')
                            ->label('Kata sandi baru')
                            ->password()
                            ->revealable(),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi kata sandi baru')
                            ->password()
                            ->revealable()
                            ->same('password'),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Update name and email
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Update password if provided
        if (!empty($data['current_password']) && !empty($data['password'])) {
            // Validasi password saat ini
            if (!Hash::check($data['current_password'], $user->password)) {
                Notification::make()
                    ->title('Kata sandi saat ini tidak sesuai')
                    ->danger()
                    ->send();
                return;
            }

            // Update password baru
            $user->update([
                'password' => Hash::make($data['password']),
            ]);

            Notification::make()
                ->title('Profil dan kata sandi berhasil diperbarui')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Profil berhasil diperbarui')
                ->success()
                ->send();
        }

        // Refresh form (clear password fields)
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
    }
}
