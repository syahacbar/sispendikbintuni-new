<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstGtkResource\Pages;
use App\Filament\Resources\MstGtkResource\RelationManagers;
use App\Models\MstGtk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MstGtkResource extends Resource
{
    protected static ?string $model = MstGtk::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'GTK';
    protected static ?string $pluralLabel = 'GTK';
    protected static ?string $slug = 'data-gtk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('nik')
                    ->maxLength(20),
                Forms\Components\TextInput::make('nip')
                    ->maxLength(20),
                Forms\Components\TextInput::make('nuptk')
                    ->maxLength(20),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->maxLength(255),
                Forms\Components\DatePicker::make('tgl_lahir'),
                Forms\Components\TextInput::make('jenis_kelamin')
                    ->maxLength(255),
                Forms\Components\TextInput::make('agama')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_kepegawaian')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jenis_gtk'),
                Forms\Components\TextInput::make('pend_terakhir')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_keaktifan')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
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
                Tables\Columns\TextColumn::make('status_kepegawaian')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenisGtk.nama'),
                Tables\Columns\TextColumn::make('pend_terakhir')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_keaktifan')
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
            'index' => Pages\ListMstGtks::route('/'),
            // 'create' => Pages\CreateMstGtk::route('/create'),
            // 'edit' => Pages\EditMstGtk::route('/{record}/edit'),
        ];
    }
}
