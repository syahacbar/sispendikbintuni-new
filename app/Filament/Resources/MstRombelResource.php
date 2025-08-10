<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MstRombelResource\Pages;
use App\Filament\Resources\MstRombelResource\RelationManagers;
use App\Models\MstRombel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class MstRombelResource extends Resource
{
    protected static ?string $model = MstRombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-group';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $navigationLabel = 'Rombel';
    protected static ?string $pluralLabel = 'Rombel';
    protected static ?string $slug = 'data-rombongan-belajar';
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sekolah_id'),
                Forms\Components\TextInput::make('kurikulum_id'),
                Forms\Components\TextInput::make('nama')
                    ->maxLength(100),
                Forms\Components\TextInput::make('tingkat')
                    ->numeric(),
                Forms\Components\TextInput::make('jurusan')
                    ->maxLength(50),
                Forms\Components\TextInput::make('kapasitas')
                    ->numeric(),
                Forms\Components\TextInput::make('wali_kelas_ptk_id'),
                Forms\Components\TextInput::make('semester_id'),
                Forms\Components\Toggle::make('status_aktif')
                    ->required(),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama')
                    ->label('Sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kurikulum.nama')
                    ->label('Kurikulum')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tingkat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kapasitas')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('waliKelas.nama')
                    ->label('Wali Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('semester.nama_semester')
                    ->label('Semester')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('status_aktif')
                    ->boolean(),
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
                // Tables\Actions\EditAcion::make(),
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
            'index' => Pages\ListMstRombels::route('/'),
            // 'create' => Pages\CreateMstRombel::route('/create'),
            // 'edit' => Pages\EditMstRombel::route('/{record}/edit'),
        ];
    }
}
