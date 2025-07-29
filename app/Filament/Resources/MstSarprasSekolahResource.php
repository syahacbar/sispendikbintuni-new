<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstSarprasSekolahResource\Pages;
use App\Filament\Resources\MstSarprasSekolahResource\RelationManagers;
use App\Models\MstSarprasSekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MstSarprasSekolahResource extends Resource
{
    protected static ?string $model = MstSarprasSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Sarpras';
    protected static ?string $pluralLabel = 'Sarpras';
    protected static ?string $slug = 'data-sarana-prasarana';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sekolah_id')
                    ->required(),
                Forms\Components\TextInput::make('sarpras_id')
                    ->required(),
                Forms\Components\TextInput::make('nama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jumlah_saat_ini')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('jumlah_ideal')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->label('Nama Sekolah')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sarpras.nama')
                    ->label('Nama Sarpras')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah_saat_ini')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jumlah_ideal')
                    ->searchable(),
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
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListMstSarprasSekolahs::route('/'),
            'create' => Pages\CreateMstSarprasSekolah::route('/create'),
            'edit' => Pages\EditMstSarprasSekolah::route('/{record}/edit'),
        ];
    }
}
