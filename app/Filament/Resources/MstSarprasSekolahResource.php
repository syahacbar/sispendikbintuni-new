<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\MstSekolah;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\MstSarprasSekolah;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MstSarprasSekolahResource\Pages;

class MstSarprasSekolahResource extends Resource
{
    protected static ?string $model = MstSarprasSekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Sarpras';
    protected static ?string $pluralLabel = 'Sarpras';
    protected static ?string $slug = 'data-sarana-prasarana';

    public static function form(Form $form): Form
    {
        $user = auth()->user();

        return $form->schema([
            Forms\Components\Hidden::make('sekolah_id')
                ->default(function () use ($user) {
                    if ($user->hasRole('admin_sekolah')) {
                        return \App\Models\MstSekolah::where('users_id', $user->id)->value('id');
                    }
                    return null;
                }),

            Forms\Components\Select::make('sarpras_id')
                ->relationship('sarpras', 'nama')
                ->label('Jenis Sarpras')
                ->required(),

            Forms\Components\TextInput::make('nama')
                ->label('Nama Sarpras')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('kondisi_baik')
                ->label('Kondisi Baik')
                ->numeric()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('kondisi_rusak_ringan')
                ->label('Rusak Ringan')
                ->numeric()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('kondisi_rusak_sedang')
                ->label('Rusak Sedang')
                ->numeric()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('kondisi_rusak_berat')
                ->label('Rusak Berat')
                ->numeric()
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('jumlah_saat_ini')
                ->numeric()
                ->required()
                ->default(0),
            Forms\Components\TextInput::make('jumlah_ideal')
                ->numeric()
                ->required()
                ->maxLength(255),
            Forms\Components\TextArea::make('keterangan')
                ->label('Keterangan')
                ->required()
                ->maxLength(255),
        ])->columns(4);
    }

    public static function table(Table $table): Table
    {
        $user = auth()->user();

        $columns = [];

        if (!$user->hasRole('admin_sekolah')) {
            $columns[] = Tables\Columns\TextColumn::make('sekolah.nama')
                ->label('Nama Sekolah')
                ->searchable()
                ->sortable();
        }

        $columns = array_merge($columns, [
            Tables\Columns\TextColumn::make('index')
                ->label('No. ')
                ->rowIndex(),
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama Sarpras')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('sarpras.nama')
                ->label('Jenis Sarpras')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('jumlah_saat_ini')
                ->label('Jumlah Saat Ini')
                ->numeric()
                ->sortable(),
            Tables\Columns\TextColumn::make('jumlah_ideal')
                ->label('Jumlah Ideal')
                ->numeric()
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('kondisi_baik')
                ->label('Kondisi Baik')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('kondisi_rusak_ringan')
                ->label('Rusak Ringan')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('kondisi_rusak_sedang')
                ->label('Rusak Sedang')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('kondisi_rusak_berat')
                ->label('Rusak Berat')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah')
                ->numeric()
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('keterangan')
                ->label('Keterangan')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ]);

        return $table
            ->columns($columns)
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user->hasRole('admin_sekolah')) {
            $sekolahId = MstSekolah::where('users_id', $user->id)->value('id');

            $query->where('sekolah_id', $sekolahId);
        }

        return $query;
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMstSarprasSekolahs::route('/'),
            'create' => Pages\CreateMstSarprasSekolah::route('/create'),
            'edit' => Pages\EditMstSarprasSekolah::route('/{record}/edit'),
        ];
    }
}
