<?php

namespace App\Filament\Pages;

use App\Models\Basic;
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

class Basicsetting extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-paint-brush';
    protected static string $view = 'filament.pages.basicsetting';
    protected static ?string $navigationLabel = 'Tema & API';
    protected static ?string $modelLabel = 'Tema & API';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Tema & API';

    public ?array $data = [];

    public static function getNavigationSort(): ?int
    {
        return 5;
    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Pengaturan Tema')
                            ->icon('heroicon-m-paint-brush')
                            ->schema([
                                Fieldset::make('Identitas Web')
                                    ->schema([
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('description')
                                            ->required(),
                                        TextInput::make('footer')
                                            ->label('Footer Text')
                                            ->required(),
                                        TextInput::make('created_by')
                                            ->label('Credit Footer')
                                            ->required(),
                                    ])->columns(2),
                                Fieldset::make('Logo dan Favicon')
                                    ->schema([
                                        FileUpload::make('logo_light')
                                            ->label('Logo')
                                            ->image()
                                            ->previewable(true)
                                            ->imagePreviewHeight('200')
                                            ->loadingIndicatorPosition('left')
                                            ->panelAspectRatio('2:1')
                                            ->panelLayout('integrated')
                                            ->removeUploadedFileButtonPosition('right')
                                            ->uploadButtonPosition('left')
                                            ->uploadProgressIndicatorPosition('left')
                                            ->nullable(),

                                        FileUpload::make('favicon')
                                            ->image()
                                            ->previewable(true)
                                            ->imagePreviewHeight('200')
                                            ->loadingIndicatorPosition('left')
                                            ->panelAspectRatio('2:1')
                                            ->panelLayout('integrated')
                                            ->removeUploadedFileButtonPosition('right')
                                            ->uploadButtonPosition('left')
                                            ->uploadProgressIndicatorPosition('left')
                                            ->nullable(),
                                    ])->columns(4),
                            ]),
                        Tab::make('Pengaturan API')
                            ->icon('heroicon-m-cog')
                            ->schema([
                                Fieldset::make('Google API')
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
                                    ])->columns(2),
                                Fieldset::make('Google reCAPTCHA')
                                    ->schema([
                                        TextInput::make('recaptcha_site_key')
                                            ->label('Google Recaptcha Site Key')
                                            ->required(),
                                        TextInput::make('recaptcha_secret_key')
                                            ->label('Google Recaptcha Secret Key')
                                            ->required(),
                                    ])->columns(2),
                            ]),
                        Tab::make('Pengaturan Email')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                Section::make('Sender Identity')
                                    ->description('Set your forum title and description in the field below.')
                                    ->schema([
                                        TextInput::make('name')
                                            ->required()
                                            ->label('Sender Name')
                                            ->maxLength(255),

                                        TextInput::make('email')
                                            ->email()
                                            ->required()
                                            ->maxLength(255),

                                        Select::make('driver')
                                            ->label('Mail Driver')
                                            ->options([
                                                'mailgun' => 'Mailgun',
                                                'smtp' => 'SMTP',
                                            ])
                                            ->default('mailgun')
                                            ->reactive()
                                            ->required(),
                                    ])->columns(3),

                                Section::make('Mailgun Settings')
                                    ->description('Set your Mailgun settings in the field below.')
                                    ->schema([
                                        TextInput::make('secret_key')
                                            ->required(fn(Get $get) => $get('driver') === 'mailgun')
                                            ->maxLength(255),

                                        TextInput::make('domain')
                                            ->required(fn(Get $get) => $get('driver') === 'mailgun')
                                            ->maxLength(255),

                                        Select::make('region')
                                            ->options([
                                                'US' => 'United States',
                                                'EU' => 'Europe',
                                                'Asia' => 'Asia',
                                                'AU' => 'Australia',
                                            ])
                                            ->default('US')
                                            ->required(fn(Get $get) => $get('driver') === 'mailgun'),

                                    ])->columns(3)
                                    ->visible(fn(Get $get) => $get('driver') === 'mailgun'),


                                Section::make('SMTP Settings')
                                    ->description('Set your SMTP settings in the field below.')
                                    ->schema([
                                        TextInput::make('host')
                                            ->required(fn(Get $get) => $get('driver') === 'smtp')
                                            ->maxLength(255),

                                        Select::make('encryption')
                                            ->options([
                                                'ssl' => 'SSL',
                                                'tls' => 'TLS',
                                                'none' => 'None',
                                            ])
                                            ->default('tls')
                                            ->required(fn(Get $get) => $get('driver') === 'smtp'),

                                        TextInput::make('port')
                                            ->required(fn(Get $get) => $get('driver') === 'smtp')
                                            ->numeric(),

                                        TextInput::make('username')
                                            ->required(fn(Get $get) => $get('driver') === 'smtp')
                                            ->maxLength(255),

                                        TextInput::make('password')
                                            ->required(fn(Get $get) => $get('driver') === 'smtp')
                                            ->password()
                                            ->maxLength(255),

                                    ])->columns(3)
                                    ->visible(fn(Get $get) => $get('driver') === 'smtp'),

                                Toggle::make('status')
                                    ->default(true)
                                    ->live()
                                    ->columnSpanFull()
                                    ->required(),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();
        Basic::setBulk($data);

        Notification::make()
            ->title('Settings Updated')
            ->body('Basic settings have been successfully updated.')
            ->success()
            ->send();
    }
}
