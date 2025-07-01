<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PesertaDidikResource\Pages;
use App\Filament\Resources\PesertaDidikResource\RelationManagers;
use App\Models\PesertaDidik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PesertaDidikResource extends Resource
{
    protected static ?string $model = PesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationLabel = 'Peserta Didik';
    protected static ?string $pluralModelLabel = 'Peserta Didik';
    protected static ?string $navigationGroup = 'Data Manajemen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sekolah_id')
                    ->required(),
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nisn')
                    ->required()
                    ->maxLength(10),
                Forms\Components\TextInput::make('nik')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_lahir')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('sekolah_id'),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date()
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
            'index' => Pages\ListPesertaDidiks::route('/'),
            'create' => Pages\CreatePesertaDidik::route('/create'),
            'edit' => Pages\EditPesertaDidik::route('/{record}/edit'),
        ];
    }
}
