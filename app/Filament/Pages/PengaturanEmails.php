<?php

namespace App\Filament\Pages;

use App\Models\PengaturanEmail;
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

class PengaturanEmails extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.pengaturan-email';
    protected static ?string $navigationLabel = 'Pengaturan Email';
    protected static ?string $modelLabel = 'Pengaturan Email';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Email';

    public ?array $data = [];

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->hasRole('super_admin');
    }



    public function mount(): void
    {
        $this->form->fill(PengaturanEmail::getAllAsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
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
        PengaturanEmail::setBulk($data);

        Notification::make()
            ->title('Settings Updated')
            ->body('Basic settings have been successfully updated.')
            ->success()
            ->send();
    }
}
