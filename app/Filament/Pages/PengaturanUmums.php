<?php

namespace App\Filament\Pages;

use App\Models\PengaturanUmum;
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
use Filament\Forms\Components\RichEditor;

class PengaturanUmums extends Page
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.pengaturan-umum';
    protected static ?string $navigationLabel = 'Pengaturan Umum';
    protected static ?string $modelLabel = 'Pengaturan Umum';
    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Umum';

    public ?array $data = [];

    public static function getNavigationSort(): ?int
    {
        return 5;
    }


    public function mount(): void
    {
        $this->form->fill(PengaturanUmum::getAllAsArray());
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
                                        TextInput::make('judul')
                                            ->label('Judul Web')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('deskripsi')
                                            ->label('Deskripsi')
                                            ->required()
                                            ->maxLength(255),
                                        TextInput::make('slogan')
                                            ->label('Slogan')
                                            ->required(),
                                        TextInput::make('hak_cipta')
                                            ->label('Hak Cipta')
                                            ->required(),
                                        TextInput::make('nama_instansi')
                                            ->label('Nama Instansi')
                                            ->required(),
                                        TextInput::make('teks_selamat_datang')
                                            ->label('Welcome Text')
                                            ->required(),
                                        TextInput::make('alamat_lengkap')
                                            ->label('Alamat Kantor')
                                            ->required(),
                                        TextInput::make('kode_pos')
                                            ->label('Kode Pos')
                                            ->required(),
                                        TextInput::make('no_hp')
                                            ->label('Nomor HP')
                                            ->required(),
                                        TextInput::make('telepon')
                                            ->label('Telepon')
                                            ->required(),
                                    ])->columns(3),
                                Fieldset::make('Media Sosial')
                                    ->schema([
                                        TextInput::make('facebook')
                                            ->label('Facebook')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('email')
                                            ->label('Email')
                                            ->required(),
                                        TextInput::make('instagram')
                                            ->label('Instagram')
                                            ->required(),
                                        TextInput::make('youtube')
                                            ->label('Youtube')
                                            ->required(),
                                        TextInput::make('twitter')
                                            ->label('Twitter')
                                            ->required(),
                                    ])->columns(3),
                                Fieldset::make('Logo dan Favicon')
                                    ->schema([
                                        FileUpload::make('logo')
                                            ->label('Logo')
                                            ->image()
                                            ->previewable(true)
                                            ->imagePreviewHeight('150')
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
                                            ->imagePreviewHeight('150')
                                            ->loadingIndicatorPosition('left')
                                            ->panelAspectRatio('2:1')
                                            ->panelLayout('integrated')
                                            ->removeUploadedFileButtonPosition('right')
                                            ->uploadButtonPosition('left')
                                            ->uploadProgressIndicatorPosition('left')
                                            ->nullable(),
                                    ])->columns(4),
                            ]),
                    ])
            ])
            ->statePath('data');
    }

    public function save()
    {
        $data = $this->form->getState();
        PengaturanUmum::setBulk($data);

        Notification::make()
            ->title('Settings Updated')
            ->body('Basic settings have been successfully updated.')
            ->success()
            ->send();
    }
}
