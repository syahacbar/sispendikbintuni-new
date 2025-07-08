<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Sarpras;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SarprasResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SarprasResource\RelationManagers;

class SarprasResource extends Resource
{
    protected static ?string $model = Sarpras::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Sarpras';
    protected static ?string $pluralModelLabel = 'Sarpras';
    protected static ?string $navigationGroup = 'Data Pendidikan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sekolah_id')
                    ->label('Sekolah')
                    ->relationship('sekolah', 'nama')
                    ->searchable()
                    ->preload()
                    ->default(fn() => Filament::auth()->user()->sekolah_id)
                    ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                    ->dehydrated(true)
                    ->required()
                    ->reactive(),
                Select::make('jenis_sarpras_id')
                    ->label('Jenis Sarpras')
                    ->relationship('jenisSarpras', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),

                Select::make('kategori')
                    ->options([
                        'Sarana' => 'Sarana',
                        'Prasarana' => 'Prasarana',
                    ])
                    ->required(),
                TextInput::make('jumlah_ideal')
                    ->required()
                    ->numeric(),
                TextInput::make('jumlah_saat_ini')
                    ->required()
                    ->numeric(),
                Select::make('kondisi')
                    ->options([
                        'Baik' => 'Baik',
                        'Rusak Ringan' => 'Rusak Ringan',
                        'Rusak Berat' => 'Rusak Berat',
                    ])
                    ->required(),
                Select::make('kurang_lebih')
                    ->options([
                        'Kurang' => 'Kurang',
                        'Lebih' => 'Lebih',
                    ])
                    ->required(),
                Textarea::make('keterangan')
                    ->required()
                    ->columnSpanFull(),
            ])->columns(4);
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
                TextColumn::make('jenisSarpras.nama')
                    ->label('Jenis Sarpras')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('kategori')
                    ->searchable(),
                TextColumn::make('jumlah_ideal')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('jumlah_saat_ini')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kondisi')
                    ->label('Kondisi')
                    ->searchable(),
                TextColumn::make('kurang_lebih')
                    ->label('Kurang Lebih')
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
            'index' => Pages\ListSarpras::route('/'),
            'create' => Pages\CreateSarpras::route('/create'),
            'edit' => Pages\EditSarpras::route('/{record}/edit'),
        ];
    }
}
