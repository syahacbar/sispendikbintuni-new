<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RombelMapelResource\Pages;
use App\Filament\Resources\RombelMapelResource\RelationManagers;
use App\Models\RombelMapel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RombelMapelResource extends Resource
{
    protected static ?string $model = RombelMapel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Rombel Mapel';
    protected static ?string $pluralModelLabel = 'Rombel Mapel';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rombongan_belajar_id')
                    ->required(),
                Forms\Components\TextInput::make('mata_pelajaran_id')
                    ->required(),
                Forms\Components\TextInput::make('ptk_id')
                    ->required(),
                Forms\Components\TextInput::make('jam_mengajar')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('rombongan_belajar_id'),
                Tables\Columns\TextColumn::make('mata_pelajaran_id'),
                Tables\Columns\TextColumn::make('ptk_id'),
                Tables\Columns\TextColumn::make('jam_mengajar')
                    ->numeric()
                    ->sortable(),
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
            'index' => Pages\ListRombelMapels::route('/'),
            'create' => Pages\CreateRombelMapel::route('/create'),
            'edit' => Pages\EditRombelMapel::route('/{record}/edit'),
        ];
    }
}
