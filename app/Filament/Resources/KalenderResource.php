<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Kalender;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\KalenderResource\Pages;

class KalenderResource extends Resource
{
    protected static ?string $model = Kalender::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $navigationLabel = 'Kalender';
    protected static ?string $pluralModelLabel = 'Kalender';
    protected static ?string $navigationGroup = 'Manajemen Konten Web';

    public static function getNavigationSort(): ?int
    {
        return 3;
    }


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
                TextInput::make('nama')
                    ->required()
                    ->maxLength(255),
                DatePicker::make('tanggal_mulai')
                    ->default(now())
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->required(),

                DatePicker::make('tanggal_akhir')
                    ->native(false)
                    ->seconds(false)
                    ->displayFormat('d/m/Y')
                    ->default(now())
                    ->required()
                    ->default(now()->addDay()),
                TextInput::make('deskripsi')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('tanggal_mulai')
                    ->date()
                    ->sortable(),
                TextColumn::make('tanggal_akhir')
                    ->date()
                    ->sortable(),
                TextColumn::make('deskripsi')
                    ->searchable(),
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
            'index' => Pages\ListKalenders::route('/'),
            'create' => Pages\CreateKalender::route('/create'),
            'edit' => Pages\EditKalender::route('/{record}/edit'),
        ];
    }
}
