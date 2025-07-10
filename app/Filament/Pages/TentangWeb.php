<?php

namespace App\Filament\Pages;

use App\Models\Tentang;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;


class TentangWeb extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Tentang';
    protected static ?string $modelLabel = 'Tentang';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $title = 'Tentang';
    protected static string $view = 'filament.pages.tentang';

    public ?array $data = [];

    public ?string $new_key = '';
    public ?string $new_value = '';

    public function mount(): void
    {
        $this->form->fill([
            'items' => Tentang::orderBy('sort_order')
                ->get()
                ->map(fn($item) => [
                    'key' => $item->key,
                    'value' => $item->value,
                ])
                ->toArray()
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Repeater::make('items')
                    ->label('Informasi Tentang')
                    ->schema([
                        TextInput::make('key')
                            ->label('Key')
                            ->required(),

                        TextInput::make('value')
                            ->label('Value')
                            ->required(),

                        TextInput::make('sort_order')
                            ->hidden() // tidak tampil di UI
                            ->dehydrated(true), // ikut disimpan
                    ])
                    ->default(fn() => Tentang::orderBy('sort_order')->get()->map(fn($item) => [
                        'key' => $item->key,
                        'value' => $item->value,
                        'sort_order' => $item->sort_order,
                    ])->toArray())
                    ->createItemButtonLabel('Tambah Informasi')
                    ->columns(2),

            ])
            ->statePath('data');
    }

    public function save()
    {
        $newData = $this->form->getState()['items'] ?? [];

        $oldData = Tentang::orderBy('sort_order')->get()->keyBy('key');

        $changed = [];

        foreach ($newData as $index => $item) {
            $original = $oldData[$item['key']] ?? null;

            if ($original && (int) $original->sort_order !== (int) $item['sort_order']) {
                $changed[] = [
                    'key' => $item['key'],
                    'old' => $original->sort_order,
                    'new' => $item['sort_order'],
                ];
            }
        }

        // Jika hanya dua item yang berubah, lakukan swap
        if (count($changed) === 2) {
            $a = $changed[0];
            $b = $changed[1];

            Tentang::where('key', $a['key'])->update(['sort_order' => $b['old']]);
            Tentang::where('key', $b['key'])->update(['sort_order' => $a['old']]);
        } else {
            // Jika lebih dari dua, update semua (fallback biasa)
            foreach ($newData as $i => $item) {
                Tentang::updateOrCreate(
                    ['key' => $item['key']],
                    [
                        'value' => $item['value'],
                        'sort_order' => $i,
                    ]
                );
            }
        }

        Notification::make()
            ->title('Data berhasil disimpan.')
            ->success()
            ->send();
    }
}
