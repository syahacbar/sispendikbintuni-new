<?php

namespace App\Filament\Pages;

use App\Models\SysSetting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\RichEditor;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class Sambutan extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Sambutan';
    protected static ?string $modelLabel = 'Sambutan';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $title = 'Sambutan';
    protected static string $view = 'filament.pages.tentang';

    public ?array $data = [];


    public function mount(): void
    {
        $this->form->fill(SysSetting::getAllAsArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Fieldset::make('')
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
            ])
            ->statePath('data');
    }


    public function save()
    {
        $data = $this->form->getState();
        SysSetting::setBulk($data);

        Notification::make()
            ->title('Sambutan Diperbarui')
            ->body('Konten sambutan berhasil diperbarui.')
            ->success()
            ->send();
    }
}
