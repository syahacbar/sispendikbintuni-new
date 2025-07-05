<?php

namespace App\Filament\Resources;

use App\Models\Ptk;
use Filament\Forms;
use Filament\Tables;
use App\Models\Sekolah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use App\Models\RombonganBelajar;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\RombonganBelajarResource\Pages;
use App\Filament\Resources\RombonganBelajarResource\RelationManagers;

class RombonganBelajarResource extends Resource
{
    protected static ?string $model = RombonganBelajar::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera-slash';
    protected static ?string $navigationLabel = 'Rombongan Belajar';
    protected static ?string $pluralModelLabel = 'Rombongan Belajar';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function getNavigationSort(): ?int
    {
        return 5;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->default(fn() => Filament::auth()->user()->sekolah_id)
                    ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                    ->dehydrated(true)
                    ->required()
                    ->reactive(),

                TextInput::make('nama_rombel')
                    ->required()
                    ->maxLength(50),

                Select::make('wali_ptk_id')
                    ->label('Wali Kelas')
                    ->options(function (callable $get) {
                        $sekolahId = $get('sekolah_id') ?? Filament::auth()->user()->sekolah_id;

                        if (!$sekolahId) {
                            return [];
                        }

                        return Ptk::where('sekolah_id', $sekolahId)->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive(),

                TextInput::make('tingkat_kelas')
                    ->required()
                    ->numeric(),
                TextInput::make('semester')
                    ->required()
                    ->maxLength(6),
                Select::make('kurikulum_id')
                    ->label('Kurikulum')
                    ->relationship('kurikulum', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->sortable()
                    ->searchable()
                    ->visible(fn() => !auth()->user()->hasRole('admin_sekolah')),
                TextColumn::make('wali.nama'),
                TextColumn::make('nama_rombel')
                    ->searchable(),
                TextColumn::make('tingkat_kelas')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('semester')
                    ->searchable(),
                TextColumn::make('kurikulum.nama'),
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
            'index' => Pages\ListRombonganBelajars::route('/'),
            'create' => Pages\CreateRombonganBelajar::route('/create'),
            'edit' => Pages\EditRombonganBelajar::route('/{record}/edit'),
        ];
    }
}
