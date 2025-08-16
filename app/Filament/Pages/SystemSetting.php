<?php

namespace App\Filament\Pages;

use App\Models\SysSetting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Repeater;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class SystemSetting extends Page
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.web-settings';
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $modelLabel = 'Pengaturan';
    protected static ?string $title = 'Pengaturan';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';

    public ?array $data = [];

    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public function mount(): void
    {
        $this->form->fill(SysSetting::getAllAsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Tabs')
                    ->tabs([
                        Tabs\Tab::make('Pengaturan Web')
                            ->icon('heroicon-m-globe-alt')
                            ->schema([

                                TextInput::make('site_name')
                                    ->label('Nama Web')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('author')
                                    ->label('Author')
                                    ->required(),
                                TextInput::make('keywords')
                                    ->label('Keywords')
                                    ->required(),
                                Textarea::make('site_description')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->columnSpanFull(),
                                TextInput::make('site_tagline')
                                    ->label('Slogan')
                                    ->required(),
                                TextInput::make('copyright')
                                    ->label('Hak Cipta')
                                    ->required(),
                                TextInput::make('design_by')
                                    ->label('Didesain Oleh')
                                    ->required(),
                                TextInput::make('welcome_text')
                                    ->label('Welcom Text')
                                    ->required(),

                            ])->columns(3),
                        Tabs\Tab::make('Google Integration')
                            ->icon('heroicon-m-cog-6-tooth')
                            ->schema([
                                TextInput::make('recaptcha_site_key')
                                    ->label('Google reCAPTCHA Site Key'),
                                TextInput::make('recaptcha_secret_key')
                                    ->label('Google reCAPTCHA Secret Key'),
                                TextInput::make('google_analytics')
                                    ->label('Google Analytics ID'),
                                TextInput::make('google_tag_manager')
                                    ->label('Google Tag Manager ID'),
                                TextInput::make('google_site_verification')
                                    ->label('Google Site Verification Code'),
                            ])->columns(3),
                        Tabs\Tab::make('Kontak & Media Sosial')
                            ->icon('heroicon-m-phone')
                            ->schema([
                                TextArea::make('address')
                                    ->label('Alamat')
                                    ->columnSpanFull()
                                    ->required(),
                                TextInput::make('postal_code')
                                    ->label('Kode Pos')
                                    ->required(),
                                TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->required(),
                                TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->required(),
                                TextInput::make('phone')
                                    ->label('Nomor HP')
                                    ->required(),
                                TextInput::make('email')
                                    ->label('Email')
                                    ->required(),
                                TextInput::make('facebook')
                                    ->label('Facebook')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('instagram')
                                    ->label('Instagram')
                                    ->required(),
                                TextInput::make('tiktok')
                                    ->label('Tiktok')
                                    ->required(),
                                TextInput::make('youtube')
                                    ->label('Youtube')
                                    ->required(),
                                TextInput::make('twitter')
                                    ->label('Twitter')
                                    ->required(),
                            ])->columns(3),
                        Tabs\Tab::make('Logo & Favicon')
                            ->icon('heroicon-m-photo')
                            ->schema([
                                FileUpload::make('logo')
                                    ->previewable(true)
                                    ->image()
                                    ->maxSize(1024)
                                    ->maxFiles(1)
                                    ->directory('logos')
                                    ->openable()
                                    ->imageEditor()
                                    ->imageEditorAspectRatios([
                                        '1:1',
                                    ])
                                    ->dehydrated(),

                                FileUpload::make('favicon')
                                    ->previewable(true)
                                    ->image()
                                    ->maxSize(1024)
                                    ->maxFiles(1)
                                    ->directory('favicons')
                                    ->openable(),
                            ])->columns(4),

                        Tabs\Tab::make('Footer')
                            ->icon('heroicon-m-link')
                            ->schema([
                                Section::make('Navigasi')
                                    ->description('Atur daftar navigasi footer')
                                    ->schema([
                                        Repeater::make('footer_navigasi')
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->label('Navigasi')
                                            ->grid(2)
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_navigasi', '[]'), true))
                                            ->columns(2),
                                    ]),

                                Section::make('Link Umum')
                                    ->description('Atur daftar link umum di footer')
                                    ->schema([
                                        Repeater::make('footer_link')
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->label('Link Umum')
                                            ->grid(2)
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_link', '[]'), true))
                                            ->columns(2),
                                    ]),

                                Section::make('Kemendikdasmen')
                                    ->description('Atur daftar link Kemendikdasmen di footer')
                                    ->schema([
                                        Repeater::make('footer_kemendikdasmen')
                                            ->deletable(false)
                                            ->reorderable(false)
                                            ->label('Kemendikdasmen')
                                            ->grid(2)
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_kemendikdasmen', '[]'), true))
                                            ->columns(2),
                                    ]),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();

        // Encode array repeater ke JSON sebelum disimpan
        $data['footer_navigasi'] = json_encode($data['footer_navigasi']);
        $data['footer_link'] = json_encode($data['footer_link']);
        $data['footer_kemendikdasmen'] = json_encode($data['footer_kemendikdasmen']);

        SysSetting::setBulk($data);

        Notification::make()
            ->title('Settings Updated')
            ->body('Basic settings have been successfully updated.')
            ->success()
            ->send();
    }
}
