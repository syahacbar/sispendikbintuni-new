<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sekolah;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\RombonganBelajar;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
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
    protected static ?string $navigationGroup = 'Data Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('wali_ptk_id')
                    ->label('Wali Kelas')
                    ->relationship('wali', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('nama_rombel')
                    ->required()
                    ->maxLength(50),
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
                Tables\Columns\TextColumn::make('sekolah.nama'),
                Tables\Columns\TextColumn::make('wali.nama'),
                Tables\Columns\TextColumn::make('nama_rombel')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tingkat_kelas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kurikulum.nama'),
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
