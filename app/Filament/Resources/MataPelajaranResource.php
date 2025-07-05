<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MataPelajaran;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MataPelajaranResource\Pages;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationLabel = 'Mata Pelajaran';
    protected static ?string $pluralModelLabel = 'Mata Pelajaran';
    protected static ?string $navigationGroup = 'Data Pendidikan';

    public static function getNavigationSort(): ?int
    {
        return 6;
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
        return $form->schema([
            Select::make('sekolah_id')
                ->label('Sekolah')
                ->relationship('sekolah', 'nama')
                ->searchable()
                ->preload()
                ->default(fn() => Filament::auth()->user()->sekolah_id)
                ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                ->dehydrated(fn() => true)
                ->required(),

            TextInput::make('kode_mapel')
                ->label('Kode Mapel')
                ->maxLength(50),

            TextInput::make('nama_mapel')
                ->label('Nama Mata Pelajaran')
                ->required()
                ->maxLength(100),

            Select::make('kelompok_mapels_id')
                ->label('Kelompok Mapel')
                ->relationship('kelompokMapel', 'nama')
                ->searchable()
                ->preload()
                ->required(),

            Select::make('jenjang')
                ->label('Jenjang')
                ->options([
                    'TK' => 'TK',
                    'KB' => 'KB',
                    'TPA' => 'TPA',
                    'SPS' => 'SPS',
                    'PKBM' => 'PKBM',
                    'SKB' => 'SKB',
                    'SD' => 'SD',
                    'SMP' => 'SMP',
                    'SMK' => 'SMK',
                    'SMA' => 'SMA',
                    'SLB' => 'SLB',
                ])
                ->required(),

            Select::make('kurikulum_id')
                ->label('Kurikulum')
                ->relationship('kurikulum', 'nama')
                ->searchable()
                ->preload()
                ->required(),

            Checkbox::make('is_praktik')
                ->label('Apakah Praktik?'),

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_mapel')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('kode_mapel')
                    ->label('Kode')
                    ->sortable(),
                TextColumn::make('kelompokMapel.nama')
                    ->label('Kelompok'),
                TextColumn::make('jenjang')
                    ->sortable(),
                TextColumn::make('kurikulum.nama')
                    ->label('Kurikulum'),
                TextColumn::make('is_praktik')
                    ->label('Praktik')
                    ->formatStateUsing(fn($state) => $state ? 'Ya' : 'Tidak')
                    ->badge()
                    ->color(fn($state) => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->dateTime()->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
