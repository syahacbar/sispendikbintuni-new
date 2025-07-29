<?php

namespace App\Filament\Pages;

use App\Models\SysSetting;
use App\Models\Tentang;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\Layout\Grid as LayoutGrid;
use Filament\Forms\Get;
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

use Filament\Infolists\Components\TextEntry;

class TentangWeb extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Tentang Web';
    protected static ?string $modelLabel = 'Tentang Web';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $title = 'Tentang Web';
    protected static string $view = 'filament.pages.tentang';

    public ?array $data = [];

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
