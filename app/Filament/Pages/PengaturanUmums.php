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
                                        TextInput::make('title')
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('tagline')
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
                                        FileUpload::make('logo')
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
                        Tabs\Tab::make('Sambutan')
                            ->icon('heroicon-m-megaphone')
                            ->schema([
                                Fieldset::make('Identitas Web')
                                    ->schema([
                                        TextInput::make('judul_sambutan')
                                            ->label('Judul')
                                            ->required()
                                            ->maxLength(255),

                                        RichEditor::make('isi_sambutan')
                                            ->label('Isi Sambutan')
                                            ->required()
                                            ->columnSpanFull(),

                                        FileUpload::make('gambar_kadin')
                                            ->label('Foto Kepala Dinas Pendidikan')
                                            ->disk('public')
                                            ->directory('assets')
                                            ->visibility('public')
                                            ->image()
                                            ->downloadable()
                                            ->openable()
                                            ->previewable(true)
                                            ->nullable(),
                                    ])->columns(2),
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
