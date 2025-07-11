<?php

namespace App\Filament\Resources;

use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Informasi;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use App\Filament\Resources\InformasiResource\Pages;
use Illuminate\Database\Eloquent\Builder;

class InformasiResource extends Resource
{
    protected static ?string $model = Informasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationLabel = 'Informasi';
    protected static ?string $pluralModelLabel = 'Informasi';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';

    public static function getNavigationSort(): ?int
    {
        return 2;
    }


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Filament::auth()->user()->hasRole('admin_sekolah')) {
            $query->where('sekolah_id', Filament::auth()->user()->sekolah_id);
        }

        return $query;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->default(fn() => Filament::auth()->user()->sekolah_id)
                    ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                    ->dehydrated(fn() => true)
                    ->required(),
                TextInput::make('judul')
                    ->label('Judul Informasi')
                    ->required()
                    ->maxLength(100),
                Select::make('kategori')
                    ->label('Kategori')
                    ->options([
                        'Berita' => 'Berita',
                        'Pengumuman' => 'Pengumuman',
                        'Kegiatan' => 'Kegiatan',
                    ])
                    ->required(),
                RichEditor::make('deskripsi')
                    ->columnSpanFull(),

                FileUpload::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->directory('assets')
                    ->visibility('public')
                    ->image()
                    ->imagePreviewHeight('150')
                    ->downloadable()
                    ->openable()
                    ->nullable(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('gambar')
                    ->label('Gambar')
                    ->disk('public')
                    ->height(60)
                    ->width(80)
                    ->visibility('public'),
                TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => !auth()->user()->hasRole('admin_sekolah')),
                TextColumn::make('judul')
                    ->words(6)
                    ->searchable(),
                TextColumn::make('deskripsi')
                    ->words(13)
                    ->searchable(),
                TextColumn::make('kategori')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListInformasis::route('/'),
            'create' => Pages\CreateInformasi::route('/create'),
            'edit' => Pages\EditInformasi::route('/{record}/edit'),
        ];
    }
}
