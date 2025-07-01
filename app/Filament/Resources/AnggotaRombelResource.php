<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnggotaRombelResource\Pages;
use App\Filament\Resources\AnggotaRombelResource\RelationManagers;
use App\Models\AnggotaRombel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnggotaRombelResource extends Resource
{
    protected static ?string $model = AnggotaRombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';
    protected static ?string $navigationLabel = 'Anggota Rombel';
    protected static ?string $navigationGroup = 'Data Pendidikan';
    protected static ?string $pluralModelLabel = 'Anggota Rombel';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        return static::getModel()::count() > 5 ? 'warning' : 'success';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rombongan_belajar_id')
                    ->required(),
                Forms\Components\TextInput::make('peserta_didik_id')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID'),
                Tables\Columns\TextColumn::make('rombongan_belajar_id'),
                Tables\Columns\TextColumn::make('peserta_didik_id'),
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
            'index' => Pages\ListAnggotaRombels::route('/'),
            'create' => Pages\CreateAnggotaRombel::route('/create'),
            'edit' => Pages\EditAnggotaRombel::route('/{record}/edit'),
        ];
    }
}
