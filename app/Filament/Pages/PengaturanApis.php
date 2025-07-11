<?php

namespace App\Filament\Pages;

use App\Models\PengaturanAPI;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;

class PengaturanApis extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static string $view = 'filament.pages.pengaturan-api';
    protected static ?string $navigationLabel = 'Pengaturan API';
    protected static ?string $modelLabel = 'Pengaturan API';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan API';

    public ?array $data = [];

    public static function getNavigationSort(): ?int
    {
        return 5;
    }


    public function mount(): void
    {
        $this->form->fill(PengaturanAPI::getAllAsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tab::make('Pengaturan API')
                            ->icon('heroicon-m-cog')
                            ->schema([
                                Fieldset::make('Google Auth API')
                                    ->schema([
                                        TextInput::make('google_client_id')
                                            ->label('Google Client ID')
                                            ->required(),

                                        TextInput::make('google_client_secret')
                                            ->label('Google Client Secret')
                                            ->required(),

                                        TextInput::make('google_redirect_uri')
                                            ->label('Google Redirect URI')
                                            ->required(),
                                    ])->columns(3),
                                Fieldset::make('Google reCAPTCHA')
                                    ->schema([
                                        TextInput::make('recaptcha_site_key')
                                            ->label('Google Recaptcha Site Key')
                                            ->required(),
                                        TextInput::make('recaptcha_secret_key')
                                            ->label('Google Recaptcha Secret Key')
                                            ->required(),
                                    ])->columns(2),
                                Fieldset::make('WA Zenziva')
                                    ->schema([
                                        TextInput::make('zenziva_userkey')
                                            ->label('Zenziva Userkey')
                                            ->required(),
                                        TextInput::make('zenziva_passkey')
                                            ->label('Zenziva Passkey')
                                            ->required(),
                                        TextInput::make('zenziva_sender')
                                            ->label('Zenziva Sender')
                                            ->required(),
                                    ])->columns(3),
                                Fieldset::make('Google Maps API')
                                    ->schema([
                                        TextInput::make('google_maps_api_key')
                                            ->label('API Key')
                                            ->required(),
                                    ])->columns(2),
                                Fieldset::make('Google Maps API')
                                    ->schema([
                                        TextInput::make('firebase_server_key')
                                            ->label('Firebase Server Key')
                                            ->required(),
                                        TextInput::make('firebase_project_id')
                                            ->label('Firebase Project ID')
                                            ->required(),
                                    ])->columns(2),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();
        PengaturanAPI::setBulk($data);

        Notification::make()
            ->title('Pengaturan API Updated')
            ->body('Pengatuan API berhasil diperbarui.')
            ->success()
            ->send();
    }
}
