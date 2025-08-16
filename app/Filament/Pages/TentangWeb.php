<?php

namespace App\Filament\Pages;

use App\Models\SysSetting;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Fieldset;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\RichEditor;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class TentangWeb extends Page implements HasForms
{
    use InteractsWithForms, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Tentang Web';
    protected static ?string $modelLabel = 'Tentang Web';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $title = 'Tentang Web';
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
                        RichEditor::make('deskripsi')
                            ->label('Deskripsi Web')
                            ->columnSpanFull()
                            ->required(),

                        RichEditor::make('visi')
                            ->label('Visi'),

                        RichEditor::make('misi')
                            ->label('Misi'),

                        RichEditor::make('tujuan')
                            ->label('Tujuan'),
                    ])->columns(3),
            ])
            ->statePath('data');
    }


    public function save()
    {
        $data = $this->form->getState();
        SysSetting::setBulk($data);

        Notification::make()
            ->title('Tentang Diperbarui')
            ->body('Konten halaman Tentang berhasil diperbarui.')
            ->success()
            ->send();
    }
}
