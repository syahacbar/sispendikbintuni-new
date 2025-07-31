<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstPesertaDidikResource\Pages;
use App\Filament\Resources\MstPesertaDidikResource\RelationManagers;
use App\Models\MstPesertaDidik;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MstPesertaDidikResource extends Resource
{
    protected static ?string $model = MstPesertaDidik::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Peserta Didik';
    protected static ?string $pluralLabel = 'Peserta Didik';
    protected static ?string $slug = 'data-peserta-didik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nisn')
                    ->maxLength(10),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(20),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(100),
                Forms\Components\DatePicker::make('tgl_lahir'),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('agama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('alamat')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('kode_wilayah')
                    ->maxLength(100),
                Forms\Components\TextInput::make('kode_pos')
                    ->maxLength(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tgl_lahir')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->searchable(),
                Tables\Columns\TextColumn::make('agama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('wilayah.nama')
                    ->label('Wilayah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kode_pos')
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
                // Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListMstPesertaDidiks::route('/'),
            // 'create' => Pages\CreateMstPesertaDidik::route('/create'),
            // 'edit' => Pages\EditMstPesertaDidik::route('/{record}/edit'),
        ];
    }
}
