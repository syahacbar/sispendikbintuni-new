<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Prasarana;
use Filament\Tables\Table;
use App\Models\JenisSarpras;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PrasaranaResource\Pages;

class PrasaranaResource extends Resource
{
    protected static ?string $model = Prasarana::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';
    protected static ?string $navigationLabel = 'Prasarana';
    protected static ?string $pluralModelLabel = 'Prasarana';
    protected static ?string $navigationGroup = 'Data Pendidikan';


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        if (Filament::auth()->user()->hasRole('admin_sekolah')) {
            $query->where('sekolah_id', Filament::auth()->user()->sekolah_id);
        }

        return $query;
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
                    ->default(fn() => Filament::auth()->user()->sekolah_id)
                    ->disabled(fn() => Filament::auth()->user()->hasRole('admin_sekolah'))
                    ->dehydrated(fn() => true)
                    ->required(),
                Select::make('jenis_prasarana_id')
                    ->label('Jenis Prasarana')
                    ->options(function () {
                        $user = Filament::auth()->user();
                        $sudahDipakai = Prasarana::where('sekolah_id', $user->sekolah_id)
                            ->pluck('jenis_prasarana_id')
                            ->toArray();

                        return JenisSarpras::whereNotIn('id', $sudahDipakai)
                            ->pluck('nama', 'id');
                    })
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('jumlah')
                    ->required()
                    ->numeric(),
                Select::make('kondisi')
                    ->options([
                        'Bagus' => 'Bagus',
                        'Rusak' => 'Rusak',
                    ])
                    ->required(),
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
                TextColumn::make('jenis_prasarana.nama')
                    ->label('Jenis Prasarana')
                    ->searchable(),
                TextColumn::make('jumlah')
                    ->numeric()
                    ->sortable(),
                BadgeColumn::make('kondisi')
                    ->label('Kondisi')
                    ->colors([
                        'success' => 'Bagus',
                        'danger' => 'Rusak',
                    ])
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
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
