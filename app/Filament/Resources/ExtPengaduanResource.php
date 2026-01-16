<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExtPengaduanResource\Pages;
use App\Filament\Resources\ExtPengaduanResource\RelationManagers;
use App\Models\ExtPengaduan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;

class ExtPengaduanResource extends Resource
{
    protected static ?string $model = ExtPengaduan::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';
    protected static ?string $navigationLabel = 'Pengaduan';
    protected static ?string $pluralLabel = 'Pengaduan';
    protected static ?string $slug = 'pegaduan-layanan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nomor_laporan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pelapor')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('judul_laporan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('no_hp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('kategori')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('dok_lampiran')
                    ->maxLength(255)
                    ->hiddenOn('view'),
                Forms\Components\Placeholder::make('dok_lampiran_view')
                    ->label('Dok Lampiran')
                    ->content(function ($record) {
                        if (empty($record->dok_lampiran)) {
                            return new \Illuminate\Support\HtmlString(
                                '<span class="inline-flex items-center rounded-md bg-gray-50 text-gray-600 px-2 py-1 text-xs font-medium ring-1 ring-inset ring-gray-500/10">
                                    Tidak ada file
                                </span>'
                            );
                        }

                        $extension = strtolower(pathinfo($record->dok_lampiran, PATHINFO_EXTENSION));
                        $label = strtoupper($extension) . ' File';
                        $url = asset('storage/' . $record->dok_lampiran);

                        $badgeColor = match ($extension) {
                            'pdf' => 'bg-red-50 text-red-700 ring-red-600/10',
                            'doc', 'docx' => 'bg-blue-50 text-blue-700 ring-blue-700/10',
                            'xls', 'xlsx', 'csv' => 'bg-green-50 text-green-700 ring-green-600/20',
                            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                            default => 'bg-gray-50 text-gray-600 ring-gray-500/10'
                        };

                        $iconPath = match ($extension) {
                            'pdf', 'doc', 'docx' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z',
                            'xls', 'xlsx', 'csv' => 'M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 01-1.125-1.125M3.375 19.5h1.5C5.496 19.5 6 18.996 6 18.375m-3.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-1.5A1.125 1.125 0 0118 18.375M20.625 4.5H3.375m17.25 0c.621 0 1.125.504 1.125 1.125M20.625 4.5h-1.5C18.504 4.5 18 5.004 18 5.625m3.75 0v1.5c0 .621-.504 1.125-1.125 1.125M3.375 4.5c-.621 0-1.125.504-1.125 1.125M3.375 4.5h1.5C5.496 4.5 6 5.004 6 5.625m-3.75 0v1.5c0 .621.504 1.125 1.125 1.125m0 0h1.5m-1.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m1.5-3.75C5.496 8.25 6 7.746 6 7.125v-1.5M4.875 8.25C5.496 8.25 6 8.754 6 9.375v1.5m0-5.25v5.25m0-5.25C6 5.004 6.504 4.5 7.125 4.5h9.75c.621 0 1.125.504 1.125 1.125m1.125 2.625h1.5m-1.5 0A1.125 1.125 0 0118 7.125v-1.5m1.125 2.625c-.621 0-1.125.504-1.125 1.125v1.5m2.625-2.625c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125M18 5.625v5.25M7.125 12h9.75m-9.75 0A1.125 1.125 0 016 10.875M7.125 12C6.504 12 6 12.504 6 13.125m0-2.25C6 11.496 6.504 12 7.125 12m9.75 0c.621 0 1.125-.504 1.125-1.125m-1.125 1.125c.621 0 1.125.504 1.125 1.125m-1.125-1.125v-1.5m0 1.5v5.25m0-5.25M18 10.875c0-.621-.504-1.125-1.125-1.125M7.125 12h9.75m-9.75 0c-.621 0-1.125.504-1.125 1.125M7.125 12c-.621 0-1.125-.504-1.125-1.125m9.75 1.125c.621 0 1.125.504 1.125 1.125m-1.125-1.125c.621 0 1.125-.504 1.125-1.125m-9.75 5.25h9.75',
                            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z',
                            default => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z'
                        };

                        return new \Illuminate\Support\HtmlString(
                            '<a href="' . $url . '" target="_blank">
                                <span class="inline-flex items-center gap-x-1.5 rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset ' . $badgeColor . '">
                                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="' . $iconPath . '" />
                                    </svg>
                                    ' . $label . '
                                </span>
                            </a>'
                        );
                    })
                    ->visibleOn('view'),
                Forms\Components\Textarea::make('isi')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255)
                    ->default('terkirim'),
                Forms\Components\TextInput::make('ip_address'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nomor_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pelapor')
                    ->searchable(),
                Tables\Columns\TextColumn::make('judul_laporan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\TextColumn::make('dok_lampiran')
                    ->label('Dok Lampiran')
                    ->formatStateUsing(function ($state) {
                        if (empty($state)) {
                            return 'Tidak ada file';
                        }

                        $extension = pathinfo($state, PATHINFO_EXTENSION);
                        return strtoupper($extension) . ' File';
                    })
                    ->badge()
                    ->color(function ($state) {
                        if (empty($state)) {
                            return 'gray';
                        }

                        $extension = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        return match ($extension) {
                            'pdf' => 'danger',
                            'doc', 'docx' => 'info',
                            'xls', 'xlsx', 'csv' => 'success',
                            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'warning',
                            default => 'gray'
                        };
                    })
                    ->icon(function ($state) {
                        if (empty($state)) {
                            return null;
                        }

                        $extension = strtolower(pathinfo($state, PATHINFO_EXTENSION));
                        return match ($extension) {
                            'pdf', 'doc', 'docx' => 'heroicon-o-document-text',
                            'xls', 'xlsx', 'csv' => 'heroicon-o-table-cells',
                            'jpg', 'jpeg', 'png', 'gif', 'webp' => 'heroicon-o-photo',
                            default => 'heroicon-o-document'
                        };
                    })
                    ->url(function ($state) {
                        if (empty($state)) {
                            return null;
                        }
                        return asset('storage/' . $state);
                    }, true) // true = open in new tab
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->openRecordUrlInNewTab(false)
            ->recordUrl(null)
            ->recordAction(null)

            ->filters([
                //
            ])
            // ->actions([
            //     Tables\Actions\EditAction::make(),
            //     Tables\Actions\DeleteAction::make(),
            // ])

            ->actions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExtPengaduans::route('/'),
            'create' => Pages\CreateExtPengaduan::route('/create'),
            'edit' => Pages\EditExtPengaduan::route('/{record}/edit'),
        ];
    }
}
