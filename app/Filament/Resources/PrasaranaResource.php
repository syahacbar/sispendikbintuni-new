<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Prasarana;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PrasaranaResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PrasaranaResource\RelationManagers;

class PrasaranaResource extends Resource
{
    protected static ?string $model = Prasarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Prasarana';
    protected static ?string $pluralModelLabel = 'Prasarana';
    protected static ?string $navigationGroup = 'Data Pendidikan';


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
                    ->dehydrated(fn() => true)
                    ->required(),
                Forms\Components\TextInput::make('jenis_prasarana')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
            ]);
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
                Tables\Columns\TextColumn::make('jenis_prasarana')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jumlah')
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
            'index' => Pages\ListPrasaranas::route('/'),
            'create' => Pages\CreatePrasarana::route('/create'),
            'edit' => Pages\EditPrasarana::route('/{record}/edit'),
        ];
    }
}
