<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RegistrasiPesertaDidikResource\Pages;
use App\Filament\Resources\RegistrasiPesertaDidikResource\RelationManagers;
use App\Models\RegistrasiPesertaDidik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RegistrasiPesertaDidikResource extends Resource
{
    protected static ?string $model = RegistrasiPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Registrasi Peserta Didik';
    protected static ?string $navigationGroup = 'Data Pendidikan';

    protected static ?string $modelLabel = 'Registrasi Peserta Didik';
    protected static ?string $pluralModelLabel = 'Registrasi Peserta Didik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('peserta_didik_id')
                    ->required(),
                Forms\Components\DatePicker::make('tanggal_masuk')
                    ->required(),
                Forms\Components\TextInput::make('jenis_pendaftaran')
                    ->required()
                    ->maxLength(50),
                Forms\Components\TextInput::make('asal_sekolah')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('peserta_didik_id'),
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_pendaftaran')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal_sekolah')
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
            'index' => Pages\ListRegistrasiPesertaDidiks::route('/'),
            'create' => Pages\CreateRegistrasiPesertaDidik::route('/create'),
            'edit' => Pages\EditRegistrasiPesertaDidik::route('/{record}/edit'),
        ];
    }
}
