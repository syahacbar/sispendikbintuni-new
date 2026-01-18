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
use Illuminate\Validation\Rules\Password;

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
                            ->placeholder('Masukkan kata sandi saat ini')
                            ->password()
                            ->revealable()
                            ->requiredWith('password')
                            ->rules([
                                function () {
                                    return function (string $attribute, $value, \Closure $fail) {
                                        if (!empty($value) && !Hash::check($value, Auth::user()->password)) {
                                            $fail('Kata sandi saat ini tidak sesuai.');
                                        }
                                    };
                                },
                            ])
                            ->validationMessages([
                                'required_with' => 'Kata sandi saat ini wajib diisi jika ingin mengubah kata sandi.',
                            ])
                            ->dehydrated(false),

                        TextInput::make('password')
                            ->label('Kata sandi baru')
                            ->placeholder('Minimal 8 karakter, kombinasi huruf besar, kecil, angka & simbol')
                            ->password()
                            ->revealable()
                            ->requiredWith('current_password')
                            ->rule(
                                Password::default()
                                    ->min(8)
                                    ->mixedCase()           // Wajib huruf besar & kecil
                                    ->numbers()             // Wajib ada angka
                                    ->symbols()             // Wajib ada simbol
                                    ->uncompromised()       // Check against compromised passwords
                            )
                            ->same('password_confirmation')
                            ->validationMessages([
                                'required_with' => 'Kata sandi baru wajib diisi jika ingin mengubah kata sandi.',
                                'min' => 'Kata sandi minimal :min karakter.',
                                'same' => 'Kata sandi baru dan konfirmasi kata sandi harus sama.',
                            ])
                            ->validationAttribute('kata sandi')
                            ->dehydrated(false),

                        TextInput::make('password_confirmation')
                            ->label('Konfirmasi kata sandi baru')
                            ->placeholder('Ulangi kata sandi baru Anda')
                            ->password()
                            ->revealable()
                            ->requiredWith('password')
                            ->validationMessages([
                                'required_with' => 'Konfirmasi kata sandi wajib diisi.',
                            ])
                            ->validationAttribute('konfirmasi kata sandi')
                            ->dehydrated(false),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $user = Auth::user();

        // Update name
        $user->update([
            'name' => $data['name'],
        ]);

        // Update password if provided (validation already handled by form)
        if (!empty($data['password'])) {
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
