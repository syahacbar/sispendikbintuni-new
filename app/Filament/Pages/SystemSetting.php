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
use Filament\Forms\Components\Select;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Illuminate\Support\Facades\Mail;

class SystemSetting extends Page
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
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
                    ->persistTabInQueryString()
                    ->tabs([
                        Tabs\Tab::make('Deskripsi Web')
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
                            ])->columns(3),
                        Tabs\Tab::make('Login Google')
                            ->icon('heroicon-m-cog-6-tooth')
                            ->schema([
                                Section::make('Google OAuth Login')
                                    ->description('Konfigurasi untuk login dengan akun Google')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('google_login_enabled')
                                            ->label('Aktifkan Login dengan Google')
                                            ->helperText('Jika diaktifkan, tombol "Login dengan Google" akan muncul di halaman login')
                                            ->default(false)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('google_client_id')
                                            ->label('Google Client ID')
                                            ->helperText('Client ID dari Google Cloud Console')
                                            ->visible(fn(callable $get) => $get('google_login_enabled'))
                                            ->required(fn(callable $get) => $get('google_login_enabled'))
                                            ->columnSpanFull(),

                                        TextInput::make('google_client_secret')
                                            ->label('Google Client Secret')
                                            ->helperText('Client Secret dari Google Cloud Console')
                                            ->password()
                                            ->revealable()
                                            ->visible(fn(callable $get) => $get('google_login_enabled'))
                                            ->required(fn(callable $get) => $get('google_login_enabled'))
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\Placeholder::make('google_redirect_info')
                                            ->label('Authorized Redirect URI')
                                            ->content(fn() => url('/paneladmin/auth/google/callback'))
                                            ->helperText('Gunakan URL ini sebagai "Authorized redirect URI" di Google Cloud Console')
                                            ->visible(fn(callable $get) => $get('google_login_enabled'))
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible()
                                    ->collapsed(false),

                                Section::make('Google Services')
                                    ->description('Konfigurasi layanan Google lainnya')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('recaptcha_enabled')
                                            ->label('Aktifkan Google reCAPTCHA')
                                            ->helperText('Jika diaktifkan, checkbox reCAPTCHA akan muncul di halaman login')
                                            ->default(false)
                                            ->live()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\Toggle::make('recaptcha_pengaduan_enabled')
                                            ->label('Aktifkan Google reCAPTCHA di Halaman Pengaduan')
                                            ->helperText('Jika diaktifkan, checkbox reCAPTCHA akan muncul di halaman pengaduan')
                                            ->default(false)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('recaptcha_site_key')
                                            ->label('Google reCAPTCHA Site Key')
                                            ->visible(fn(callable $get) => $get('recaptcha_enabled') || $get('recaptcha_pengaduan_enabled'))
                                            ->required(fn(callable $get) => $get('recaptcha_enabled') || $get('recaptcha_pengaduan_enabled')),
                                        TextInput::make('recaptcha_secret_key')
                                            ->label('Google reCAPTCHA Secret Key')
                                            ->visible(fn(callable $get) => $get('recaptcha_enabled') || $get('recaptcha_pengaduan_enabled'))
                                            ->required(fn(callable $get) => $get('recaptcha_enabled') || $get('recaptcha_pengaduan_enabled')),
                                        TextInput::make('google_analytics')
                                            ->label('Google Analytics ID'),
                                        TextInput::make('google_tag_manager')
                                            ->label('Google Tag Manager ID'),
                                        TextInput::make('google_site_verification')
                                            ->label('Google Site Verification Code'),
                                    ])
                                    ->columns(2)
                                    ->collapsible()
                                    ->collapsed(false),
                            ]),
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

                        Tabs\Tab::make('Konfigurasi Email')
                            ->icon('heroicon-m-envelope')
                            ->schema([
                                Section::make('Pilihan Driver Email')
                                    ->description('Pilih driver email yang akan digunakan dan isi konfigurasi yang diperlukan')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('email_verification_enabled')
                                            ->label('Aktifkan Verifikasi Email Saat Registrasi')
                                            ->helperText('Jika diaktifkan, user baru harus memverifikasi email mereka sebelum bisa mengakses aplikasi')
                                            ->default(true)
                                            ->live()
                                            ->columnSpanFull(),

                                        Select::make('mail_driver')
                                            ->label('Mail Driver')
                                            ->options([
                                                'smtp' => 'cPanel Hosting',
                                                'sendgrid' => 'SendGrid',
                                                'mailgun' => 'Mailgun',
                                                'ses' => 'Amazon SES',
                                            ])
                                            ->default('smtp')
                                            ->required()
                                            ->live()
                                            ->helperText('Pilih provider email yang akan digunakan untuk mengirim email')
                                            ->columnSpanFull(),
                                    ])
                                    ->collapsible(),

                                // SMTP / cPanel Configuration
                                Section::make('Konfigurasi SMTP')
                                    ->description('Pengaturan untuk Generic SMTP atau cPanel Hosting')
                                    ->schema([
                                        TextInput::make('mail_host')
                                            ->label('Mail Host')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->placeholder('mail.yourdomain.com')
                                            ->helperText('Hostname server SMTP Anda'),

                                        TextInput::make('mail_port')
                                            ->label('Mail Port')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->numeric()
                                            ->default(587)
                                            ->helperText('587 untuk TLS, 465 untuk SSL, 25 tanpa enkripsi'),

                                        TextInput::make('mail_username')
                                            ->label('Username / Email')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->placeholder('noreply@yourdomain.com')
                                            ->helperText('Alamat email atau username untuk autentikasi SMTP'),

                                        TextInput::make('mail_password')
                                            ->label('Password')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->password()
                                            ->revealable()
                                            ->helperText('Password untuk autentikasi SMTP'),

                                        Select::make('mail_encryption')
                                            ->label('Enkripsi')
                                            ->options([
                                                'tls' => 'TLS',
                                                'ssl' => 'SSL',
                                                'none' => 'None',
                                            ])
                                            ->default('tls')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->helperText('Protokol enkripsi yang digunakan'),

                                        TextInput::make('mail_from_address')
                                            ->label('From Address')
                                            ->email()
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->placeholder('noreply@yourdomain.com')
                                            ->helperText('Alamat email pengirim default'),

                                        TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'smtp')
                                            ->placeholder('System Notification')
                                            ->helperText('Nama pengirim default'),
                                    ])
                                    ->columns(2)
                                    ->visible(fn(callable $get) => $get('mail_driver') === 'smtp')
                                    ->collapsible(),

                                // SendGrid Configuration
                                Section::make('Konfigurasi SendGrid')
                                    ->description('Pengaturan untuk SendGrid API')
                                    ->schema([
                                        TextInput::make('sendgrid_api_key')
                                            ->label('SendGrid API Key')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'sendgrid')
                                            ->password()
                                            ->revealable()
                                            ->helperText('API Key dari SendGrid Dashboard')
                                            ->columnSpanFull(),

                                        TextInput::make('mail_from_address')
                                            ->label('From Address')
                                            ->email()
                                            ->required(fn(callable $get) => $get('mail_driver') === 'sendgrid')
                                            ->placeholder('noreply@yourdomain.com')
                                            ->helperText('Alamat email pengirim (harus verified di SendGrid)'),

                                        TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'sendgrid')
                                            ->placeholder('System Notification')
                                            ->helperText('Nama pengirim default'),
                                    ])
                                    ->columns(2)
                                    ->visible(fn(callable $get) => $get('mail_driver') === 'sendgrid')
                                    ->collapsible(),

                                // Mailgun Configuration
                                Section::make('Konfigurasi Mailgun')
                                    ->description('Pengaturan untuk Mailgun API')
                                    ->schema([
                                        TextInput::make('mailgun_domain')
                                            ->label('Mailgun Domain')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'mailgun')
                                            ->placeholder('mg.yourdomain.com')
                                            ->helperText('Domain yang terdaftar di Mailgun'),

                                        TextInput::make('mailgun_secret')
                                            ->label('Mailgun API Key')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'mailgun')
                                            ->password()
                                            ->revealable()
                                            ->helperText('API Key dari Mailgun Dashboard'),

                                        TextInput::make('mailgun_endpoint')
                                            ->label('Mailgun Endpoint')
                                            ->default('api.mailgun.net')
                                            ->helperText('Endpoint regional Mailgun (default: api.mailgun.net, EU: api.eu.mailgun.net)'),

                                        TextInput::make('mail_from_address')
                                            ->label('From Address')
                                            ->email()
                                            ->required(fn(callable $get) => $get('mail_driver') === 'mailgun')
                                            ->placeholder('noreply@yourdomain.com')
                                            ->helperText('Alamat email pengirim'),

                                        TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'mailgun')
                                            ->placeholder('System Notification')
                                            ->helperText('Nama pengirim default'),
                                    ])
                                    ->columns(2)
                                    ->visible(fn(callable $get) => $get('mail_driver') === 'mailgun')
                                    ->collapsible(),

                                // Amazon SES Configuration
                                Section::make('Konfigurasi Amazon SES')
                                    ->description('Pengaturan untuk Amazon Simple Email Service')
                                    ->schema([
                                        TextInput::make('aws_access_key_id')
                                            ->label('AWS Access Key ID')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'ses')
                                            ->helperText('AWS Access Key ID dari IAM'),

                                        TextInput::make('aws_secret_access_key')
                                            ->label('AWS Secret Access Key')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'ses')
                                            ->password()
                                            ->revealable()
                                            ->helperText('AWS Secret Access Key dari IAM'),

                                        Select::make('aws_default_region')
                                            ->label('AWS Region')
                                            ->options([
                                                'us-east-1' => 'US East (N. Virginia)',
                                                'us-west-2' => 'US West (Oregon)',
                                                'ap-southeast-1' => 'Asia Pacific (Singapore)',
                                                'ap-southeast-2' => 'Asia Pacific (Sydney)',
                                                'ap-northeast-1' => 'Asia Pacific (Tokyo)',
                                                'eu-west-1' => 'Europe (Ireland)',
                                                'eu-central-1' => 'Europe (Frankfurt)',
                                            ])
                                            ->default('us-east-1')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'ses')
                                            ->helperText('Region AWS SES yang digunakan'),

                                        TextInput::make('aws_ses_configuration_set')
                                            ->label('Configuration Set')
                                            ->helperText('(Opsional) Configuration set untuk tracking dan analytics'),

                                        TextInput::make('mail_from_address')
                                            ->label('From Address')
                                            ->email()
                                            ->required(fn(callable $get) => $get('mail_driver') === 'ses')
                                            ->placeholder('noreply@yourdomain.com')
                                            ->helperText('Alamat email pengirim (harus verified di SES)'),

                                        TextInput::make('mail_from_name')
                                            ->label('From Name')
                                            ->required(fn(callable $get) => $get('mail_driver') === 'ses')
                                            ->placeholder('System Notification')
                                            ->helperText('Nama pengirim default'),
                                    ])
                                    ->columns(2)
                                    ->visible(fn(callable $get) => $get('mail_driver') === 'ses')
                                    ->collapsible(),

                                // Test Email Section
                                // Section::make('Test Konfigurasi Email')
                                //     ->description('Kirim email test untuk memverifikasi konfigurasi')
                                //     ->schema([
                                //         TextInput::make('test_email_address')
                                //             ->label('Email Tujuan Test')
                                //             ->email()
                                //             ->placeholder('your@email.com')
                                //             ->helperText('Masukkan email untuk menerima test email')
                                //             ->columnSpanFull(),
                                //     ])
                                //     ->collapsible(),
                            ]),

                        Tabs\Tab::make('Footer')
                            ->icon('heroicon-m-link')
                            ->schema([
                                Section::make('Pengaturan Layout Footer')
                                    ->description('Konfigurasi tampilan dan struktur footer website')
                                    ->schema([
                                        \Filament\Forms\Components\Select::make('footer_mode')
                                            ->label('Mode Footer')
                                            ->options([
                                                'classic' => 'Mode Klasik (3 Kolom Tetap)',
                                                'widget' => 'Mode Widget (Kustomisasi Penuh)',
                                            ])
                                            ->default('classic')
                                            ->live()
                                            ->afterStateUpdated(fn($state, callable $set) => $state === 'classic' ? $set('footer_columns', 3) : null)
                                            ->helperText('Mode Klasik: Menggunakan 3 kolom tetap (Navigasi, Link Umum, Kemendikdasmen). Mode Widget: Fleksibilitas penuh dengan widget area.')
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\Select::make('footer_columns')
                                            ->label('Jumlah Kolom')
                                            ->options([
                                                2 => '2 Kolom',
                                                3 => '3 Kolom',
                                                4 => '4 Kolom',
                                            ])
                                            ->default(3)
                                            ->visible(fn(callable $get) => $get('footer_mode') === 'widget')
                                            ->live()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\ColorPicker::make('footer_bg_color')
                                            ->label('Warna Background Footer')
                                            ->default('#212529')
                                            ->helperText('Warna background untuk footer (default: dark)')
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                // CLASSIC MODE SECTIONS
                                Section::make('Mode Klasik - Navigasi')
                                    ->description('Atur daftar navigasi footer')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'classic')
                                    ->schema([
                                        Repeater::make('footer_navigasi')
                                            ->label('Navigasi')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required()
                                                    ->url(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_navigasi', '[]'), true))
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null),
                                    ])
                                    ->collapsible(),

                                Section::make('Mode Klasik - Link Umum')
                                    ->description('Atur daftar link umum di footer')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'classic')
                                    ->schema([
                                        Repeater::make('footer_link')
                                            ->label('Link Umum')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required()
                                                    ->url(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_link', '[]'), true))
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null),
                                    ])
                                    ->collapsible(),

                                Section::make('Mode Klasik - Kemendikdasmen')
                                    ->description('Atur daftar link Kemendikdasmen di footer')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'classic')
                                    ->schema([
                                        Repeater::make('footer_kemendikdasmen')
                                            ->label('Kemendikdasmen')
                                            ->schema([
                                                TextInput::make('label')
                                                    ->label('Nama Link')
                                                    ->required(),
                                                TextInput::make('url')
                                                    ->label('URL')
                                                    ->required()
                                                    ->url(),
                                            ])
                                            ->default(fn() => json_decode(SysSetting::getValue('footer_kemendikdasmen', '[]'), true))
                                            ->columns(2)
                                            ->reorderable()
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null),
                                    ])
                                    ->collapsible(),

                                // WIDGET MODE - AREA 1
                                Section::make('Widget Area 1')
                                    ->description('Konfigurasi widget untuk kolom pertama')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'widget')
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('footer_widget_1.enabled')
                                            ->label('Aktifkan Widget')
                                            ->default(true)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_1.title')
                                            ->label('Judul Widget')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled'))
                                            ->placeholder('Contoh: Tentang Kami'),

                                        \Filament\Forms\Components\Select::make('footer_widget_1.type')
                                            ->label('Tipe Widget')
                                            ->options([
                                                'navigation' => 'Navigation Links',
                                                'custom_text' => 'Custom Text/HTML',
                                                'contact' => 'Contact Info',
                                                'social_media' => 'Social Media',
                                                'recent_posts' => 'Recent Posts',
                                            ])
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled'))
                                            ->live()
                                            ->default('custom_text'),

                                        // Navigation Links
                                        Repeater::make('footer_widget_1.links')
                                            ->label('Links')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'navigation')
                                            ->schema([
                                                TextInput::make('label')->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                                            ->columnSpanFull(),

                                        // Custom Text/HTML
                                        \Filament\Forms\Components\RichEditor::make('footer_widget_1.content')
                                            ->label('Konten')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'custom_text')
                                            ->columnSpanFull(),

                                        // Contact Info
                                        TextInput::make('footer_widget_1.address')
                                            ->label('Alamat')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'contact')
                                            ->columnSpanFull(),
                                        TextInput::make('footer_widget_1.phone')
                                            ->label('Telepon')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'contact'),
                                        TextInput::make('footer_widget_1.email')
                                            ->label('Email')
                                            ->email()
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'contact'),

                                        // Social Media
                                        Repeater::make('footer_widget_1.platforms')
                                            ->label('Platform Social Media')
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'social_media')
                                            ->schema([
                                                \Filament\Forms\Components\Select::make('platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'instagram' => 'Instagram',
                                                        'twitter' => 'Twitter',
                                                        'youtube' => 'YouTube',
                                                        'tiktok' => 'TikTok',
                                                        'linkedin' => 'LinkedIn',
                                                    ])
                                                    ->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->columnSpanFull(),

                                        // Recent Posts
                                        \Filament\Forms\Components\TextInput::make('footer_widget_1.post_count')
                                            ->label('Jumlah Post')
                                            ->numeric()
                                            ->default(5)
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'recent_posts'),
                                        \Filament\Forms\Components\Toggle::make('footer_widget_1.show_date')
                                            ->label('Tampilkan Tanggal')
                                            ->default(true)
                                            ->visible(fn(callable $get) => $get('footer_widget_1.enabled') && $get('footer_widget_1.type') === 'recent_posts'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                // WIDGET MODE - AREA 2
                                Section::make('Widget Area 2')
                                    ->description('Konfigurasi widget untuk kolom kedua')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'widget' && $get('footer_columns') >= 2)
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('footer_widget_2.enabled')
                                            ->label('Aktifkan Widget')
                                            ->default(true)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_2.title')
                                            ->label('Judul Widget')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled'))
                                            ->placeholder('Contoh: Link Cepat'),

                                        \Filament\Forms\Components\Select::make('footer_widget_2.type')
                                            ->label('Tipe Widget')
                                            ->options([
                                                'navigation' => 'Navigation Links',
                                                'custom_text' => 'Custom Text/HTML',
                                                'contact' => 'Contact Info',
                                                'social_media' => 'Social Media',
                                                'recent_posts' => 'Recent Posts',
                                            ])
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled'))
                                            ->live()
                                            ->default('navigation'),

                                        Repeater::make('footer_widget_2.links')
                                            ->label('Links')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'navigation')
                                            ->schema([
                                                TextInput::make('label')->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\RichEditor::make('footer_widget_2.content')
                                            ->label('Konten')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'custom_text')
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_2.address')
                                            ->label('Alamat')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'contact')
                                            ->columnSpanFull(),
                                        TextInput::make('footer_widget_2.phone')
                                            ->label('Telepon')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'contact'),
                                        TextInput::make('footer_widget_2.email')
                                            ->label('Email')
                                            ->email()
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'contact'),

                                        Repeater::make('footer_widget_2.platforms')
                                            ->label('Platform Social Media')
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'social_media')
                                            ->schema([
                                                \Filament\Forms\Components\Select::make('platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'instagram' => 'Instagram',
                                                        'twitter' => 'Twitter',
                                                        'youtube' => 'YouTube',
                                                        'tiktok' => 'TikTok',
                                                        'linkedin' => 'LinkedIn',
                                                    ])
                                                    ->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\TextInput::make('footer_widget_2.post_count')
                                            ->label('Jumlah Post')
                                            ->numeric()
                                            ->default(5)
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'recent_posts'),
                                        \Filament\Forms\Components\Toggle::make('footer_widget_2.show_date')
                                            ->label('Tampilkan Tanggal')
                                            ->default(true)
                                            ->visible(fn(callable $get) => $get('footer_widget_2.enabled') && $get('footer_widget_2.type') === 'recent_posts'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                // WIDGET MODE - AREA 3
                                Section::make('Widget Area 3')
                                    ->description('Konfigurasi widget untuk kolom ketiga')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'widget' && $get('footer_columns') >= 3)
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('footer_widget_3.enabled')
                                            ->label('Aktifkan Widget')
                                            ->default(true)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_3.title')
                                            ->label('Judul Widget')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled'))
                                            ->placeholder('Contoh: Kontak Kami'),

                                        \Filament\Forms\Components\Select::make('footer_widget_3.type')
                                            ->label('Tipe Widget')
                                            ->options([
                                                'navigation' => 'Navigation Links',
                                                'custom_text' => 'Custom Text/HTML',
                                                'contact' => 'Contact Info',
                                                'social_media' => 'Social Media',
                                                'recent_posts' => 'Recent Posts',
                                            ])
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled'))
                                            ->live()
                                            ->default('contact'),

                                        Repeater::make('footer_widget_3.links')
                                            ->label('Links')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'navigation')
                                            ->schema([
                                                TextInput::make('label')->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\RichEditor::make('footer_widget_3.content')
                                            ->label('Konten')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'custom_text')
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_3.address')
                                            ->label('Alamat')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'contact')
                                            ->columnSpanFull(),
                                        TextInput::make('footer_widget_3.phone')
                                            ->label('Telepon')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'contact'),
                                        TextInput::make('footer_widget_3.email')
                                            ->label('Email')
                                            ->email()
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'contact'),

                                        Repeater::make('footer_widget_3.platforms')
                                            ->label('Platform Social Media')
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'social_media')
                                            ->schema([
                                                \Filament\Forms\Components\Select::make('platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'instagram' => 'Instagram',
                                                        'twitter' => 'Twitter',
                                                        'youtube' => 'YouTube',
                                                        'tiktok' => 'TikTok',
                                                        'linkedin' => 'LinkedIn',
                                                    ])
                                                    ->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\TextInput::make('footer_widget_3.post_count')
                                            ->label('Jumlah Post')
                                            ->numeric()
                                            ->default(5)
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'recent_posts'),
                                        \Filament\Forms\Components\Toggle::make('footer_widget_3.show_date')
                                            ->label('Tampilkan Tanggal')
                                            ->default(true)
                                            ->visible(fn(callable $get) => $get('footer_widget_3.enabled') && $get('footer_widget_3.type') === 'recent_posts'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),

                                // WIDGET MODE - AREA 4
                                Section::make('Widget Area 4')
                                    ->description('Konfigurasi widget untuk kolom keempat')
                                    ->visible(fn(callable $get) => $get('footer_mode') === 'widget' && $get('footer_columns') >= 4)
                                    ->schema([
                                        \Filament\Forms\Components\Toggle::make('footer_widget_4.enabled')
                                            ->label('Aktifkan Widget')
                                            ->default(true)
                                            ->live()
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_4.title')
                                            ->label('Judul Widget')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled'))
                                            ->placeholder('Contoh: Social Media'),

                                        \Filament\Forms\Components\Select::make('footer_widget_4.type')
                                            ->label('Tipe Widget')
                                            ->options([
                                                'navigation' => 'Navigation Links',
                                                'custom_text' => 'Custom Text/HTML',
                                                'contact' => 'Contact Info',
                                                'social_media' => 'Social Media',
                                                'recent_posts' => 'Recent Posts',
                                            ])
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled'))
                                            ->live()
                                            ->default('social_media'),

                                        Repeater::make('footer_widget_4.links')
                                            ->label('Links')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'navigation')
                                            ->schema([
                                                TextInput::make('label')->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->itemLabel(fn(array $state): ?string => $state['label'] ?? null)
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\RichEditor::make('footer_widget_4.content')
                                            ->label('Konten')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'custom_text')
                                            ->columnSpanFull(),

                                        TextInput::make('footer_widget_4.address')
                                            ->label('Alamat')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'contact')
                                            ->columnSpanFull(),
                                        TextInput::make('footer_widget_4.phone')
                                            ->label('Telepon')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'contact'),
                                        TextInput::make('footer_widget_4.email')
                                            ->label('Email')
                                            ->email()
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'contact'),

                                        Repeater::make('footer_widget_4.platforms')
                                            ->label('Platform Social Media')
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'social_media')
                                            ->schema([
                                                \Filament\Forms\Components\Select::make('platform')
                                                    ->options([
                                                        'facebook' => 'Facebook',
                                                        'instagram' => 'Instagram',
                                                        'twitter' => 'Twitter',
                                                        'youtube' => 'YouTube',
                                                        'tiktok' => 'TikTok',
                                                        'linkedin' => 'LinkedIn',
                                                    ])
                                                    ->required(),
                                                TextInput::make('url')->required()->url(),
                                            ])
                                            ->columns(2)
                                            ->collapsible()
                                            ->columnSpanFull(),

                                        \Filament\Forms\Components\TextInput::make('footer_widget_4.post_count')
                                            ->label('Jumlah Post')
                                            ->numeric()
                                            ->default(5)
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'recent_posts'),
                                        \Filament\Forms\Components\Toggle::make('footer_widget_4.show_date')
                                            ->label('Tampilkan Tanggal')
                                            ->default(true)
                                            ->visible(fn(callable $get) => $get('footer_widget_4.enabled') && $get('footer_widget_4.type') === 'recent_posts'),
                                    ])
                                    ->columns(2)
                                    ->collapsible(),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();

        // Remove test email address from saved data
        unset($data['test_email_address']);

        // Encode array repeater ke JSON sebelum disimpan
        if (isset($data['footer_navigasi'])) {
            $data['footer_navigasi'] = json_encode($data['footer_navigasi']);
        }
        if (isset($data['footer_link'])) {
            $data['footer_link'] = json_encode($data['footer_link']);
        }
        if (isset($data['footer_kemendikdasmen'])) {
            $data['footer_kemendikdasmen'] = json_encode($data['footer_kemendikdasmen']);
        }

        // Encode widget areas ke JSON
        if (isset($data['footer_widget_1'])) {
            $data['footer_widget_1'] = json_encode($data['footer_widget_1']);
        }
        if (isset($data['footer_widget_2'])) {
            $data['footer_widget_2'] = json_encode($data['footer_widget_2']);
        }
        if (isset($data['footer_widget_3'])) {
            $data['footer_widget_3'] = json_encode($data['footer_widget_3']);
        }
        if (isset($data['footer_widget_4'])) {
            $data['footer_widget_4'] = json_encode($data['footer_widget_4']);
        }

        SysSetting::setBulk($data);

        Notification::make()
            ->title('Settings Updated')
            ->body('Basic settings have been successfully updated.')
            ->success()
            ->send();
    }

    public function testEmailConfig()
    {
        $data = $this->form->getState();
        $testEmail = $data['test_email_address'] ?? null;

        if (!$testEmail) {
            Notification::make()
                ->title('Email Tujuan Diperlukan')
                ->body('Silakan masukkan alamat email tujuan untuk test.')
                ->warning()
                ->send();
            return;
        }

        try {
            // Apply current form configuration temporarily
            $this->applyMailConfig($data);

            // Send test email
            Mail::raw('Ini adalah test email dari sistem. Jika Anda menerima email ini, konfigurasi email Anda sudah benar.', function ($message) use ($testEmail, $data) {
                $message->to($testEmail)
                    ->subject('Test Email - ' . ($data['mail_from_name'] ?? config('app.name')));
            });

            Notification::make()
                ->title('Test Email Berhasil Dikirim')
                ->body("Email test telah dikirim ke {$testEmail}. Silakan periksa inbox Anda.")
                ->success()
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Test Email Gagal')
                ->body('Error: ' . $e->getMessage())
                ->danger()
                ->send();
        }
    }

    protected function applyMailConfig(array $config)
    {
        $driver = $config['mail_driver'] ?? 'smtp';

        switch ($driver) {
            case 'smtp':
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => $config['mail_host'] ?? '',
                    'mail.mailers.smtp.port' => $config['mail_port'] ?? 587,
                    'mail.mailers.smtp.encryption' => $config['mail_encryption'] === 'none' ? null : $config['mail_encryption'],
                    'mail.mailers.smtp.username' => $config['mail_username'] ?? '',
                    'mail.mailers.smtp.password' => $config['mail_password'] ?? '',
                    'mail.from.address' => $config['mail_from_address'] ?? '',
                    'mail.from.name' => $config['mail_from_name'] ?? '',
                ]);
                break;

            case 'sendgrid':
                config([
                    'mail.default' => 'smtp',
                    'mail.mailers.smtp.transport' => 'smtp',
                    'mail.mailers.smtp.host' => 'smtp.sendgrid.net',
                    'mail.mailers.smtp.port' => 587,
                    'mail.mailers.smtp.encryption' => 'tls',
                    'mail.mailers.smtp.username' => 'apikey',
                    'mail.mailers.smtp.password' => $config['sendgrid_api_key'] ?? '',
                    'mail.from.address' => $config['mail_from_address'] ?? '',
                    'mail.from.name' => $config['mail_from_name'] ?? '',
                ]);
                break;

            case 'mailgun':
                config([
                    'mail.default' => 'mailgun',
                    'services.mailgun.domain' => $config['mailgun_domain'] ?? '',
                    'services.mailgun.secret' => $config['mailgun_secret'] ?? '',
                    'services.mailgun.endpoint' => $config['mailgun_endpoint'] ?? 'api.mailgun.net',
                    'mail.from.address' => $config['mail_from_address'] ?? '',
                    'mail.from.name' => $config['mail_from_name'] ?? '',
                ]);
                break;

            case 'ses':
                config([
                    'mail.default' => 'ses',
                    'services.ses.key' => $config['aws_access_key_id'] ?? '',
                    'services.ses.secret' => $config['aws_secret_access_key'] ?? '',
                    'services.ses.region' => $config['aws_default_region'] ?? 'us-east-1',
                    'services.ses.configuration_set' => $config['aws_ses_configuration_set'] ?? null,
                    'mail.from.address' => $config['mail_from_address'] ?? '',
                    'mail.from.name' => $config['mail_from_name'] ?? '',
                ]);
                break;
        }
    }
}
